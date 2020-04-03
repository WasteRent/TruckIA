<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use Illuminate\Support\Facades\Auth;

class AdminAlertController extends Controller
{

    public function index()
    {
        return view('admin.alerts.index', [
            'alerts' => Alert::where('user_id', Auth::user()->id)->latest()->get()
        ]);
    }
}
