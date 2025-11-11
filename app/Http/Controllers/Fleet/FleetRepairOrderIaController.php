<?php

namespace App\Http\Controllers\Fleet;

use App\Classes\RapairOrderStateService;
use App\Classes\RepairOrderReferenceGenerator;
use App\Events\RepairOrderCreated;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessOCRJob;
use App\Models\Alert;
use App\Services\GeminiService;
use App\Models\File;
use App\Models\RepairOrder;
use App\Models\RepairOrderOperation;
use App\Models\RepairOrderPart;
use App\Models\RepairOrderState;
use App\Models\SparePart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FleetRepairOrderIaController extends Controller
{

    public function create(RepairOrder $repair_order)
    {
        return view('fleet.repair_orders.ia.create', [
            'repair_order' => $repair_order
        ]);
    }

    public function store(Request $request, RepairOrder $repair_order)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png',
        ]);

        try {
            $file = $request->file('file');
            $fileModel = File::storeFile($file, 'OCR File');

            // Despachar el job para procesar el OCR de forma asíncrona
            $job = new ProcessOCRJob($repair_order, $fileModel);
            $job->handle();

            return redirect()->route('fleet.repair-orders.show', $repair_order)
                ->with('success', 'El archivo se ha subido correctamente. El procesamiento OCR se está ejecutando en segundo plano.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al subir el archivo: ' . $e->getMessage());
        }
    }
}
