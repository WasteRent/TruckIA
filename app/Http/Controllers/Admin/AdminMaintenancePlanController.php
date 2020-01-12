<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MaintenancePlanRequest;
use App\Models\MaintenancePlan;
use App\Models\Manufacturer;
use App\Models\Model;
use Illuminate\Http\Request;

class AdminMaintenancePlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = MaintenancePlan::filters($request->all());
        $plans = MaintenancePlan::where($filters)->get();

        return view('admin.maintenance_plans.index', [
            'plans' => $plans,
            'manufacturers' => Manufacturer::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.maintenance_plans.create', [
            'manufacturers' => Manufacturer::all(),
            'models' => Model::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MaintenancePlanRequest $request)
    {
        $plan = new MaintenancePlan($request->all());
        $plan->save();
        return redirect()->route('admin.maintenance-plans.index')
                        ->with('success_message', 'Plan de mantenimiento creado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MaintenancePlan  $maintenancePlan
     * @return \Illuminate\Http\Response
     */
    public function edit(MaintenancePlan $maintenancePlan)
    {
        return view('admin.maintenance_plans.edit', [
            'plan' => $maintenancePlan,
            'manufacturers' => Manufacturer::all(),
            'models' => Model::all()
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MaintenancePlan  $maintenancePlan
     * @return \Illuminate\Http\Response
     */
    public function update(MaintenancePlanRequest $request, MaintenancePlan $maintenancePlan)
    {
        $maintenancePlan->update($request->all());
        return redirect()->route('admin.maintenance-plans.index', $maintenancePlan)
                        ->with('success_message', 'Plan de mantenimiento actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MaintenancePlan  $maintenancePlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaintenancePlan $maintenancePlan)
    {
        try {
            $maintenancePlan->delete();
        } catch (\Exception $e) {
            return back()->with('error_message', 'Este plan de mantenimiento tiene operaciones asociadas.');
        }

        return back()->with('success_message', 'Plan de mantenimiento eliminado');
    }
}
