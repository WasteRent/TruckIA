<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Garage;
use Illuminate\Http\Request;

class SearchGarageController extends Controller
{
    public function index(Request $request)
    {
        return Garage::filter($request->all())
            ->with(
                'officialService1',
                'officialService2',
                'officialService3',
                'officialService4',
                'officialService5'
            )
            ->limit(20)
            ->get();
    }
}
