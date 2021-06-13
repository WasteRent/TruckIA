<?php

namespace App\Http\Controllers\Fleet;

use App\Classes\RapairOrderStateService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Fleet\RepairOrderRequest;
use App\Http\Requests\Fleet\UpdateRepairOrderRequest;
use App\Models\Garage;
use App\Models\RepairOrder;
use App\Models\RepairOrderOperation;
use App\Models\MaintenancePlan;
use App\Models\RepairOrderState;
use App\Models\RepairOrderPart;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetTestRepairOrdersController extends Controller
{

    public function index()
    {
        return view('fleet.test_repair_orders.index');
    }
    
    public function corrective()
    {
        return view('fleet.test_repair_orders.corrective.corrective');
    }

    public function preventive()
    {
        return view('fleet.test_repair_orders.preventive.preventive');
    }

    public function create()
    {
        return view('fleet.test_repair_orders.index');
    }

    public function update()
    {
        return view('fleet.test_repair_orders.index');
    }

    public function enTallerCo()
    {
        return view('fleet.test_repair_orders.corrective.in_garage_corrective');
    }
    
    public function enTallerPre()
    {
        return view('fleet.test_repair_orders.preventive.in_garage_preventive');
    }

    public function facturaPendiente()
    {
        return view('fleet.test_repair_orders.corrective.pending_invoice');
    }

    public function pendingJob()
    {
        return view('fleet.test_repair_orders.pending_job');
    }

    public function datosIncompletos()
    {
        return view('fleet.test_repair_orders.corrective.incomplete_data');
    }

    public function citaPrevTec()
    {
        return view('fleet.test_repair_orders.preventive.cita_preventivo_tecnico');
    }

    public function citaTaller()
    {
        return view('fleet.test_repair_orders.preventive.pendiente_cita_taller');
    }
}
