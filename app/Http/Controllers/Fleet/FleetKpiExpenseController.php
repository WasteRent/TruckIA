<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\AdditionalVehicleExpense;
use App\Models\Customer;
use App\Models\RepairOrder;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class FleetKpiExpenseController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->from ?? now()->subMonths(8)->format('Y-m-d 00:00:00');
        $to = $request->to ?? now()->format('Y-m-d 23:59:59');

        $data = cache()->remember("monthly_expense_data_{$from}_{$to}_" . auth()->user()->fleet->id . '_' . md5(serialize($request->toArray())), now()->addHours(1), function () use ($from, $to, $request) {
            return $this->monthly($from, $to, $request->toArray());
        });

        $allowed_customers = auth()->user()->allowedCustomers->isEmpty() ? Customer::where('fleet_id', auth()->user()->fleet->id)->orderBy('name')->get() : auth()->user()->allowedCustomers;

        return view('fleet.dashboard.expense.index', [
            'source' => $data,
            'allowed_customers' => $allowed_customers,
        ]);
    }

    public function monthly(string $from, string $to, array $filters = [])
    {
        $orders = RepairOrder::filter($filters)
                ->where('fleet_id', auth()->user()->fleet->id)
                ->selectRaw('YEAR(created_at) as year, MONTHNAME(created_at) as month, COUNT(*) as value')
                ->whereBetween('created_at', ["$from 00:00:00", "$to 23:59:59"])
                ->groupByRaw('year, month')
                ->get()
                ->mapWithKeys(function ($item) {
                    return ["{$item['month']} {$item['year']}" => $item['value']];
                });
        $expense_parts = RepairOrder::filter($filters)
                ->where('fleet_id', auth()->user()->fleet->id)
                ->whereBetween('created_at', ["$from 00:00:00", "$to 23:59:59"])
                ->get()
                ->map(function ($order) {
                    return [
                        'date' => Carbon::parse($order->created_at)->format('F Y'),
                        'amount' => $order->parts->sum('total_price'),
                    ];
                })
                ->groupBy('date')
                ->mapWithKeys(function ($a) {
                    return [$a[0]['date'] => $a->sum('amount')];
                });

        $expense_mo = RepairOrder::filter($filters)
                ->where('fleet_id', auth()->user()->fleet->id)
                ->whereBetween('created_at', ["$from 00:00:00", "$to 23:59:59"])
                ->get()
                ->map(function ($order) {
                    return [
                        'date' => Carbon::parse($order->created_at)->format('F Y'),
                        'amount' => $order->operations->whereIn('operation_code', ['MO', null])->sum('amount'),
                    ];
                })
                ->groupBy('date')
                ->mapWithKeys(function ($a) {
                    return [$a[0]['date'] => $a->sum('amount')];
                });
        $expense_outsourced = RepairOrder::filter($filters)
                ->where('fleet_id', auth()->user()->fleet->id)
                ->whereBetween('created_at', ["$from 00:00:00", "$to 23:59:59"])
                ->get()
                ->map(function ($order) {
                    return [
                        'date' => Carbon::parse($order->created_at)->format('F Y'),
                        'amount' => $order->operations->whereIn('operation_code', ['SUB'])->sum('amount'),
                    ];
                })
                ->groupBy('date')
                ->mapWithKeys(function ($a) {
                    return [$a[0]['date'] => $a->sum('amount')];
                });
        $expense_displacement = RepairOrder::filter($filters)
                ->where('fleet_id', auth()->user()->fleet->id)
                ->whereBetween('created_at', ["$from 00:00:00", "$to 23:59:59"])
                ->get()
                ->map(function ($order) {
                    return [
                        'date' => Carbon::parse($order->created_at)->format('F Y'),
                        'amount' => $order->operations->whereIn('operation_code', ['DES'])->sum('amount'),
                    ];
                })
                ->groupBy('date')
                ->mapWithKeys(function ($a) {
                    return [$a[0]['date'] => $a->sum('amount')];
                });

        $additional_expenses = AdditionalVehicleExpense::query()
                ->where('fleet_id', auth()->user()->fleet->id)
                ->whereBetween('date', ["$from 00:00:00", "$to 23:59:59"])
                ->get()
                ->map(function ($expense) {
                    return [
                        'date' => Carbon::parse($expense->date)->format('F Y'),
                        'amount' => $expense->amount,
                    ];
                })
                ->groupBy('date')
                ->mapWithKeys(function ($a) {
                    return [$a[0]['date'] => $a->sum('amount')];
                });

        $additional_expenses_null_vehicle = AdditionalVehicleExpense::filter($filters)
                ->where('fleet_id', auth()->user()->fleet->id)
                ->whereNull('vehicle_id')
                ->whereBetween('date', ["$from 00:00:00", "$to 23:59:59"])
                ->get()
                ->map(function ($expense) {
                    return [
                        'date' => Carbon::parse($expense->date)->format('F Y'),
                        'amount' => $expense->amount,
                    ];
                })
                ->groupBy('date')
                ->mapWithKeys(function ($a) {
                    return [$a[0]['date'] => $a->sum('amount')];
                });

        $expense_total = $expense_parts->mapWithKeys(function ($i, $key) use ($expense_mo, $expense_outsourced, $expense_displacement, $additional_expenses) {
            return [$key => $i + $expense_mo[$key] + $expense_outsourced[$key] + $expense_displacement[$key] + (isset($additional_expenses[$key]) ? $additional_expenses[$key] : 0)];
        });

        return [
            $this->formatMonthly($orders, $from, $to),
            $this->formatMonthly($expense_parts, $from, $to),
            $this->formatMonthly($expense_mo, $from, $to),
            $this->formatMonthly($expense_outsourced, $from, $to),
            $this->formatMonthly($expense_displacement, $from, $to),
            $this->formatMonthly($expense_total, $from, $to),
            $this->formatMonthly($additional_expenses_null_vehicle, $from, $to),
        ];
    }

    private function formatMonthly($input, $from, $to)
    {
        $from = Carbon::parse($from);
        $to = Carbon::parse($to);

        foreach (CarbonPeriod::create($from->format('Y-m-01'), '1 month', $to->format('Y-m-01')) as $value) {
            $key = $value->format('F').' '.$value->format('Y');
            $data[] = ['label' => $key, 'value' => isset($input[$key]) ? $input[$key] : 0];
        }

        return $data;
    }
}
