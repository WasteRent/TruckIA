<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;

class AdminUserController extends Controller
{

    public function index()
    {
        return view('admin.users.index', [
            'users' => User::paginate()
        ]);
    }
}
