<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manufacturer;

class AdminMaintenancePlanStatsController extends Controller
{
    public function index()
    {
        return view('admin.maintenance_plans.stats', [
            'manufacturers' => Manufacturer::orderBy('name')->get()
        ]);
    }
}
