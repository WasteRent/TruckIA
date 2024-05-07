<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;

class FleetQRController extends Controller
{
    public function index()
    {
        $hashids = new \Hashids\Hashids('What is dead, may never die!', 4, 'ABCDEFGHJKLMNPQRSTVWYXZ923456789');

        $ids = [];
        while (count($ids) < 30) {
            $id = $hashids->encode(rand(10, 9999));

            if (! Vehicle::where('qrid', $id)->exists()) {
                $ids[] = $id;
            }
        }

        return view('qr', ['ids' => $ids]);
    }
}
