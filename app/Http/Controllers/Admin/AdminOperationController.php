<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Operation;

class AdminOperationController extends Controller
{

    public function index()
    {
        return view('admin.operations.index', [
            'operations' => Operation::all()
        ]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }

    public function show(Operation $operation)
    {
        return view('admin.operations.show', [
            'operation' => $operation
        ]);
    }
}
