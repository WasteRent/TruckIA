<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MaintenancePlanRequest;
use App\Models\MaintenancePlan;
use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FleetMaintenancePlanController extends Controller
{
    public function index(Request $request)
    {
        $filters = MaintenancePlan::filters($request->all() ?? []);

        $plans = MaintenancePlan::where($filters)
                ->where(function ($q) {
                    $q->where('original', auth()->user()->allowOriginalPlans() ? 1 : 0)
                        ->orWhereHas('fleet', function ($q2) {
                            $q2->where('fleet_id', auth()->user()->fleet->id);
                        });
                })
                ->latest()
                ->paginate(40);

        return view('fleet.maintenance_plans.index', [
            'plans' => $plans,
            'manufacturers' => Manufacturer::orderBy('name')->get(),
            'models' => Model::where('manufacturer_id', $request->manufacturer_id)->orderBy('name')->get(),
            'versions' => Version::where('model_id', $request->model_id)->orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fleet.maintenance_plans.create', [
            'manufacturers' => Manufacturer::all(),
            'models' => collect([]),
            'versions' => collect([]),
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
        $plan->name = '['.auth()->user()->fleet->name."] {$request->name}";
        $plan->original = 0;
        $plan->save();

        auth()->user()->fleet->customPlans()->attach($plan);

        return redirect()->route('fleet.maintenance-plans.operations.index', $plan)
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
        return view('fleet.maintenance_plans.edit', [
            'plan' => $maintenancePlan,
            'manufacturers' => Manufacturer::all(),
            'models' => $maintenancePlan->manufacturer ? $maintenancePlan->manufacturer->models : collect([]),
            'versions' => $maintenancePlan->model ? $maintenancePlan->model->versions : collect([]),
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

        return redirect()->route('fleet.maintenance-plans.index')
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
            DB::beginTransaction();

            $maintenancePlan->operations->each->delete();
            $maintenancePlan->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error_message', 'Este plan de mantenimiento tiene operaciones asociadas. '.$e->getMessage());
        }

        return back()->with('success_message', 'Plan de mantenimiento eliminado');
    }

    public function pdf(Request $request)
    {
        $plans = MaintenancePlan::find(explode(',', $request->plan_ids));

        return view('fleet.maintenance_plans.pdf', [
            'plans' => $plans,
        ]);
    }
}
