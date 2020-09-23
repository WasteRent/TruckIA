<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MaintenancePlanRequest;
use App\Models\MaintenancePlan;
use App\Models\Manufacturer;
use App\Models\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminMaintenancePlanController extends Controller
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

        return view('admin.maintenance_plans.index', [
            'plans' => $plans,
            'manufacturers' => Manufacturer::orderBy('name')->get(),
            'models' => Model::orderBy('name')->get()
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
            'models' => collect([])
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
            'models' => $maintenancePlan->manufacturer ? $maintenancePlan->manufacturer->models : collect([])
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
            DB::beginTransaction();
            
            $maintenancePlan->operations->each->delete();
            $maintenancePlan->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error_message', 'Este plan de mantenimiento tiene operaciones asociadas.');
        }

        return back()->with('success_message', 'Plan de mantenimiento eliminado');
    }

    public function clone(int $plan_id)
    {
        $plan = MaintenancePlan::findOrFail($plan_id);
        
        $clone = $plan->replicate();
        $clone->name = "Duplicado de {$clone->name}";
        $clone->save();

        foreach ($plan->operations as $operation) {
            $operation->replicate()
                    ->fill(['maintenance_plan_id' => $clone->id])
                    ->save();
        }

        return back()->with('success_message', 'Plan de mantenimiento duplicado');
    }
}
