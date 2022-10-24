<?php

namespace App\Http\Controllers\Fleet;

use App\Events\VehicleCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\VehicleRequest;
use App\Models\Customer;
use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\RepairOrder;
use App\Models\RepairOrderState;
use App\Models\Vehicle;
use App\Models\VehicleCounterHistory;
use App\Models\VehicleState;
use App\Models\VehicleType;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetVehicleController extends Controller
{
    public function index(Request $request)
    {
        $vehicles = Vehicle::filter($request->all())
            ->where('fleet_id', Auth::user()->fleet->id)
            ->orWhereHas('guestFleet', function($q) {
                $q->where('fleet_id', Auth::user()->fleet->id);
            })
            ->orderBy('plate')->paginate(20);

        return view('fleet.vehicles.index', [
            'vehicles' => $vehicles,
            'chassis_manufacturers' => Manufacturer::whereHas('models', function ($q) {
                $q->where('category', '!=', 'equipment');
            })->orderBy('name')->get(),
            'equipment_manufacturers' => Manufacturer::whereHas('models', function ($q) {
                $q->where('category', 'equipment');
            })->orderBy('name')->get(),
            'chassis_models' => Manufacturer::find($request->chassis_maker_id) ? Manufacturer::find($request->chassis_maker_id)->models->sortBy('name') : collect([]),
            'equipment_models' => Manufacturer::find($request->equipment_maker_id) ? Manufacturer::find($request->equipment_maker_id)->models->sortBy('name') : collect([]),
            'customers' => Customer::where('fleet_id', Auth::user()->fleet->id)->orderBy('name')->get(),
            'states' => VehicleState::all(),
        ]);
    }

    public function create()
    {
        return view('fleet.vehicles.create', [
            'manufacturers' => Manufacturer::all(),
            'models' => Model::all(),
            'versions' => Version::all(),
            'types' => VehicleType::orderBy('name')->get(),
            'states' => VehicleState::orderBy('name')->get(),
        ]);
    }

    public function store(VehicleRequest $request)
    {
        $vehicle = new Vehicle($request->all());
        $vehicle->fleet_id = Auth::user()->fleet->id;
        $vehicle->save();
        event(new VehicleCreated($vehicle));

        return redirect()->route('fleet.vehicles.edit', $vehicle)->with('success_message', 'Vehículo creado');
    }

    public function show(Request $request, Vehicle $vehicle)
    {
        $this->authorize('view', $vehicle);

        $filters = RepairOrder::filters($request->all());

        $expense_data = (new FleetKpiExpenseController)->monthly(now()->subMonths(12)->format('Y-m-d'), now()->format('Y-m-d'), ['plate' => $vehicle->plate]);

        return view('fleet.vehicles.show', [
            'expense_data' => $expense_data,
            'vehicle' => $vehicle,
            'states' => RepairOrderState::all(),
            'repair_orders' => RepairOrder::where($filters)->latest()->get(),
        ]);
    }

    public function edit(Vehicle $vehicle)
    {
        $this->authorize('view', $vehicle);

        return view('fleet.vehicles.edit', [
            'vehicle' => $vehicle,
            'manufacturers' => Manufacturer::all(),
            'models' => $vehicle->chassisMaker ? $vehicle->chassisMaker->models : collect([]),
            'versions' => $vehicle->chassisModel ? $vehicle->chassisModel->versions : collect([]),
            'types' => VehicleType::orderBy('name')->get(),
            'states' => VehicleState::orderBy('name')->get(),
        ]);
    }

    public function update(VehicleRequest $request, Vehicle $vehicle)
    {
        $is_updating_counters = false;

        // Log state changes. Set as Discharged automatically if discharged_date is set.
        if ($request->state_id && ($vehicle->state_id != $request->state_id)) {
            $vehicle->changeState($request->state_id);
        } elseif (empty($vehicle->discharged_date) && $request->discharged_date) {
            $vehicle->changeState(VehicleState::DISCHARGED);
        }

        if ($request->kms && $request->kms != $vehicle->kms) {
            $is_updating_counters = true;
            $vehicle->incrementKms($request->kms - $vehicle->kms);
        }

        // If equipment hours updated then update counters
        if ($request->equipment_work_hours != $vehicle->equipment_work_hours) {
            $is_updating_counters = true;

            $diff = $request->equipment_work_hours - $vehicle->equipment_work_hours;
            $vehicle->counters()
                ->where('vehicle_category', 'equipment')
                ->where('type', 'work_hours')
                ->get()
                ->each(function ($counter) use ($diff) {
                    $counter->current + $diff < 0
                        ? $counter->update(['current' => 0])
                        : $counter->increment('current', $diff);
                });
        }

        // If chassis can hours updated then update counters
        if ($request->chassis_can_work_hours != $vehicle->chassis_can_work_hours) {
            $is_updating_counters = true;

            $diff = $request->chassis_can_work_hours - $vehicle->chassis_can_work_hours;
            $vehicle->counters()
                ->where('vehicle_category', 'chassis')
                ->where('type', 'work_hours')
                ->get()
                ->each(function ($counter) use ($diff) {
                    $counter->current + $diff < 0
                        ? $counter->update(['current' => 0])
                        : $counter->increment('current', $diff);
                });
        }

        $data = $request->all();
        unset($data['state_id']);

        // Update hours ratio automatically based on real hours entered
        if ($request->equipment_work_hours > 0 &&
            $request->work_ratio_chassis_equipment == $vehicle->work_ratio_chassis_equipment
        ) {
            $ratio = $request->chassis_can_work_hours / $request->equipment_work_hours;
            $data['work_ratio_chassis_equipment'] = $ratio;
        }

        if ($request->fleet_id && $request->fleet_id != $vehicle->fleet_id) {
            $vehicle->update(['assigned_customer_id' => null]);
            $vehicle->changeState(VehicleState::AVAILABLE);
        }

        $vehicle->update($data);

        if ($is_updating_counters && $request->kms && $request->equipment_work_hours && $request->chassis_can_work_hours) {
            VehicleCounterHistory::create([
                'vehicle_id' => $vehicle->id,
                'user_id' => Auth::id(),
                'kms' => $request->kms,
                'work_hours_equipment' => $request->equipment_work_hours,
                'work_hours_chassis' => $request->chassis_can_work_hours,
            ]);
        }

        return back()->with('success_message', 'Vehículo actualizado');
    }

    public function destroy(Vehicle $vehicle)
    {
        try {
            $vehicle->delete();
        } catch (\Exception $e) {
            return back()->with('error_message', 'Este vehículo tiene ordenes de reparación asociadas.');
        }

        return back()->with('success_message', 'Vehículo eliminado');
    }

    public function report(Vehicle $vehicle)
    {
        $orders = $vehicle->repairOrders()->with('operations')->whereNotNull('finished_at')->latest()->get();

        $html = view('fleet.vehicles.report', [
            'vehicle' => $vehicle,
            'orders' => $orders,
        ]);

        return $html;
    }
}
