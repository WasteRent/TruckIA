<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\AdditionalVehicleExpense;
use App\Models\RepairOrder;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class FleetKpiExpenseController extends Controller
{
    public function index(Request $request)
    {
        $to = $request->to ?? now();
        $from = $request->from ?? now()->subMonths(8);

        $data = $this->monthly($from, $to, $request->toArray());

        return view('fleet.dashboard.expense.index', [
            'source' => $data,
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
                        'amount' => $expense->amount
                    ];
                })
                ->groupBy('date')
                ->mapWithKeys(function ($a) {
                    return [$a[0]['date'] => $a->sum('amount')];
                });

        $expense_total = $expense_parts->mapWithKeys(function ($i, $key) use ($expense_mo, $expense_outsourced, $expense_displacement, $additional_expenses) {
            return [$key => $i + $expense_mo[$key] + $expense_outsourced[$key] + $expense_displacement[$key] + (isset($additional_expenses[$key]) ? $additional_expenses[$key]:0)];
        });

        return [
            $this->formatMonthly($orders, $from, $to),
            $this->formatMonthly($expense_parts, $from, $to),
            $this->formatMonthly($expense_mo, $from, $to),
            $this->formatMonthly($expense_outsourced, $from, $to),
            $this->formatMonthly($expense_displacement, $from, $to),
            $this->formatMonthly($expense_total, $from, $to),
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
