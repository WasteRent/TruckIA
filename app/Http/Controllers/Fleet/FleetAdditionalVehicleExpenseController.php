<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Imports\ImportAdditionalVehicleExpenses;
use App\Models\AdditionalVehicleExpense;
use App\Models\Customer;
use App\Services\ImportService;
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
        $allowed_customers = auth()->user()->allowedCustomers->isEmpty() ? Customer::where('fleet_id', auth()->user()->fleet->id)->orderBy('name')->get() : auth()->user()->allowedCustomers;

        return view('fleet.additional_expenses.create', [
            'allowed_customers' => $allowed_customers,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['file' => 'required', 'customer_id' => 'required', 'template_type' => 'required']);

        if ($data['file']->getClientOriginalExtension() != 'csv' && $data['file']->getClientOriginalExtension() != 'xlsx') {
            return back()->with('error_message', 'El archivo debe tener formato csv o xlsx.');
        }

        try {
            DB::beginTransaction();

            $importService = new ImportService(auth()->user()->fleet->id, $data['customer_id'], $data['template_type']);
            $importService->import($data['file']);
            
            DB::commit();

            return to_route('fleet.additional-vehicle-expenses.index')->with('success_message', 'Carga realizada');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error_message', "Ha ocurrido un error: {$e->getMessage()}");
        }
    }
}
