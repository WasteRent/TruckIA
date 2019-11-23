<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceAlert;

class AdminAlertController extends Controller
{

    public function index()
    {
        return view('admin.alerts.index', [
            'alerts' => MaintenanceAlert::all()
        ]);
    }
}
