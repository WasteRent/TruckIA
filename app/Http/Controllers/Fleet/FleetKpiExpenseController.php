<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
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

        $expense_operations = RepairOrder::filter($filters)
                ->where('fleet_id', auth()->user()->fleet->id)
                ->whereBetween('created_at', ["$from 00:00:00", "$to 23:59:59"])
                ->get()
                ->map(function ($order) {
                    return [
                        'date' => Carbon::parse($order->created_at)->format('F Y'),
                        'amount' => $order->operations->sum('amount'),
                    ];
                })
                ->groupBy('date')
                ->mapWithKeys(function ($a) {
                    return [$a[0]['date'] => $a->sum('amount')];
                });

        $expense_total = $expense_parts->mapWithKeys(function ($i, $key) use ($expense_operations) {
            return [$key => $i + $expense_operations[$key]];
        });

        return [
            $this->formatMonthly($orders, $from, $to),
            $this->formatMonthly($expense_parts, $from, $to),
            $this->formatMonthly($expense_operations, $from, $to),
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
