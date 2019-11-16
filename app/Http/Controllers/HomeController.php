<?php

namespace App\Http\Controllers;

use App\Models\MaintenancePlan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('maintenance.index', [
            'plans' => MaintenancePlan::with('operations.type')->get()
        ]);
    }
}
