<?php

namespace App\Http\Controllers\Fleet;

use App\Classes\RapairOrderStateService;
use App\Classes\RepairOrderReferenceGenerator;
use App\Events\RepairOrderCreated;
use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Services\GeminiService;
use App\Models\File;
use App\Models\RepairOrder;
use App\Models\RepairOrderState;
use App\Models\SparePart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FleetRepairOrderIaController extends Controller
{

    public function create()
    {
        return view('fleet.repair_orders.ia.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        try {
            $file = $request->file('file');

            $fileModel = File::storeFile($file, 'OCR File');

            $result = app(GeminiService::class)->extractDataFromOCR($fileModel);

            dd($result);
            DB::beginTransaction();

            if (Auth::user()->fleet->repair_order_needs_authorization) {
                $state = RepairOrderState::PENDING_AUTHORIZATION;
            } else {
                $state = RepairOrderState::AUTHORIZED;
            }

            $order = new RepairOrder();
            $order->fleet_id = Auth::user()->fleet->id;
            $order->reference = RepairOrderReferenceGenerator::generate(Auth::user()->fleet);
            $order->state_id = $state;
            $order->type = $data['type'] ?? 'preventive';
            $order->vehicle_id = $data['vehicle_id'];
            $order->garage_id = $data['garage_id'];
            $order->creator_user_id = Auth::user()->id;
            $order->kms = $data['kms'];
            $order->work_hours_chassis = $data['work_hours_chassis'];
            $order->work_hours_equipment = $data['work_hours_equipment'];
            $order->assigned_user_id = [auth()->id()];
            $order->internal_notes = $data['internal_notes'] ?? '';
            $order->related_incident_id = $request->incident_id;
            $order->related_guarantee_id = $request->guarantee_id;
            $order->created_at = $request->created_at;

            if ($state == RepairOrderState::AUTHORIZED) {
                $order->authorized_at = now();
            }

            $order->save();

            RapairOrderStateService::transit($order->id, $state);

            $this->createLines($order, $request->toArray());

            $sparePart = SparePart::where('reference', $request->line_reference)->first();
            if (isset($sparePart) && $sparePart->stock < $sparePart->safety_stock) {
                $alert = new Alert();
                $alert->fleet_id = Auth::user()->fleet->id;
                $alert->vehicle_id = $data['vehicle_id'];
                $alert->title = 'El stock de repuestos está bajo';
                $alert->description = 'El repuesto ' . $sparePart->reference . ' tiene un stock por debajo del stock de seguridad';
                $alert->save();
            }

            event(new RepairOrderCreated($order));

            DB::commit();

            return redirect()->route('fleet.repair-orders.show', $order);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        if (isset($result['error'])) {
            return view('fleet.vehicles.ia.create', [
                'error' => 'Error procesando el archivo: ' . $result['error_details']['message']
            ]);
        }

        return view('fleet.vehicles.ia.create', [
            'results' => $result
        ]);
    }
}
