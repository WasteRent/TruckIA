<?php

namespace App\Http\Controllers;

use App\Models\RepairOrder;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class BoxController extends Controller
{
    public function auth(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->validate(['plate' => 'required', 'pin' => 'required']);

            $vehicle = Vehicle::where('plate', preg_replace("/[^A-Za-z0-9]/", '', $data['plate']))->firstOrFail();
            $order = $vehicle->repairOrders()->latest()->firstOrFail();

            return redirect()->route('box.show', $order);
        }
        else {
            return view('box.auth');
        }
    }

    public function show(RepairOrder $order)
    {
        return view('box.show', [
            'order' => $order,
            'vehicle' => $order->vehicle
        ]);
    }
}
