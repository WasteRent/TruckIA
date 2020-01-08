<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Operation;

class AdminOperationController extends Controller
{
    public function index()
    {
        return view('admin.operations.index', [
            'operations' => Operation::all()
        ]);
    }
}
