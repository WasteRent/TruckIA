<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\RepairOrder;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetChartController extends Controller
{
    
    public function index(Request $request)
    {
        $to = $request->to ?? now();
        $type = $request->type == 'daily' ? 'daily' : 'monthly';

        if ($type == 'monthly') {
            $from = $request->from ?? now()->subMonths(6);
            $data = $this->monthly($from, $to);
        } else if ($type == 'daily') {
            $from = $request->from ?? now()->subDays(30);
            $data = $this->daily($from, $to);
        }
        
        return view('fleet.dashboard.chart', [
            'source' => $data
        ]);
    }

    public function monthly(string $from, string $to)
    {
        $orders = RepairOrder::selectRaw('YEAR(created_at) as year, MONTHNAME(created_at) as month, COUNT(*) as value')
                ->whereBetween('created_at', ["$from 00:00:00", "$to 23:59:59"])
                ->where('type', 'preventive')
                ->groupByRaw('year, month')
                ->get()
                ->mapWithKeys(function ($item) {
                    return ["{$item['month']} {$item['year']}" => $item['value']];
                });
        $expense_parts = RepairOrder::whereBetween('created_at', ["$from 00:00:00", "$to 23:59:59"])
                ->where('type', 'preventive')
                ->get()
                ->map(function($order) {
                    return [
                        'date' => Carbon::parse($order->created_at)->format('F Y'),
                        'amount' => $order->parts->sum('total_price')
                    ];
                })
                ->groupBy('date')
                ->mapWithKeys(function($a) {
                    return [$a[0]['date'] => $a->sum('amount')];
                });

        $expense_operations = RepairOrder::whereBetween('created_at', ["$from 00:00:00", "$to 23:59:59"])
                ->where('type', 'preventive')
                ->get()
                ->map(function($order) {
                    return [
                        'date' => Carbon::parse($order->created_at)->format('F Y'),
                        'amount' => $order->operations->sum('amount')
                    ];
                })
                ->groupBy('date')
                ->mapWithKeys(function($a) {
                    return [$a[0]['date'] => $a->sum('amount')];
                });

        $expense_total = $expense_parts->mapWithKeys(function($i, $key) use ($expense_operations) {
            return [$key => $i + $expense_operations[$key]];
        });

        return [
            $this->formatMonthly($orders, $from, $to),
            $this->formatMonthly($expense_parts, $from, $to),
            $this->formatMonthly($expense_operations, $from, $to),
            $this->formatMonthly($expense_total, $from, $to)
        ];
    }

    private function formatMonthly($input, $from, $to)
    {
        $from = Carbon::parse($from);
        $to = Carbon::parse($to);

        foreach (CarbonPeriod::create($from->format('Y-m-01'), '1 month', $to->format('Y-m-01')) as $value) {
            $key = $value->format('F') . ' ' . $value->format('Y');
            $data[] = ['label' => $key, 'value' => isset($input[$key]) ? $input[$key] : 0];
        }

        return $data;
    }


    private function formatDaily($input, $from, $to)
    {
        $data = [];
        foreach (CarbonPeriod::create($from, $to) as $value) {
            $key = (int)$value->format('d') .' '. $value->format('F');
            $data[] = ['label' => substr($key, 0, 6), 'value' => isset($input[$key]) ? $input[$key] : 0];
        }
        return $data;
    }

}
