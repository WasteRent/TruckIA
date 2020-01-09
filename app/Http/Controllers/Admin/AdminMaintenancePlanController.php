<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MaintenancePlanRequest;
use App\Models\MaintenancePlan;

class AdminMaintenancePlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.maintenance_plans.index', [
            'plans' => MaintenancePlan::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.maintenance_plans.create');
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
        return redirect()->route('admin.maintenance_plans-plans.show', $plan->fresh())
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
            'plan' => $maintenancePlan
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
        return back()->with('success_message', 'Plan de mantenimiento actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MaintenancePlan  $maintenancePlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaintenancePlan $maintenancePlan)
    {
        //
    }
}
