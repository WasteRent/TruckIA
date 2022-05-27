<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\MaintenancePlan;
use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\Version;
use Illuminate\Http\Request;

class FleetMaintenancePlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->all()) {
            session(['filters' => $request->all()]);
        }

        $filters = MaintenancePlan::filters(session('filters') ?? []);
        $plans = MaintenancePlan::where($filters)->paginate();

        return view('fleet.maintenance_plans.index', [
            'plans' => $plans,
            'manufacturers' => Manufacturer::orderBy('name')->get(),
            'models' => Model::where('manufacturer_id', $request->manufacturer_id)->orderBy('name')->get(),
            'versions' => Version::where('model_id', $request->model_id)->orderBy('name')->get()
        ]);
    }

}
