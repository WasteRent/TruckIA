<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Imports\ImportAdditionalVehicleExpenses;
use App\Models\AdditionalVehicleExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class FleetAdditionalVehicleExpenseController extends Controller
{
    public function index(Request $request)
    {
        $expenses = AdditionalVehicleExpense::filter($request->toArray())
                            ->where('fleet_id', auth()->user()->fleet->id)
                            ->paginate();

        return view('fleet.additional_expenses.index', [
            'expenses' => $expenses,
        ]);
    }

    public function create()
    {
        return view('fleet.additional_expenses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['file' => 'required']);

        if ($data['file']->getClientOriginalExtension() != 'csv') {
            return back()->with('error_message', 'El archivo debe tener formato csv.');
        }

        try {
            DB::beginTransaction();

            Excel::import(new ImportAdditionalVehicleExpenses(auth()->user()->fleet->id), $data['file']);

            DB::commit();

            return to_route('fleet.additional-vehicle-expenses.index')->with('success_message', 'Carga realizada');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error_message', "Ha ocurrido un error: {$e->getMessage()}");
        }
    }
}
