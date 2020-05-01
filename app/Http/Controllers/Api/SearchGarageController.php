<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Garage;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class SearchGarageController extends Controller
{
    public function index(Request $request)
    {
        $garages = Garage::filter($request->all())
            ->with(
                'officialService1',
                'officialService2',
                'officialService3',
                'officialService4',
                'officialService5'
            )
            ->get();

        if ($request->vehicle_id) {
            $vehicle = Vehicle::find($request->vehicle_id);
            $makers = $vehicle->equipments->pluck('maker.id')->push($vehicle->chassis_maker_id);
        
            $garages = $garages->map(function ($garage) use ($vehicle, $makers) {
                $garage->featured = $makers->contains($garage->official_service1_manufacturer_id)
                    || $makers->contains($garage->official_service2_manufacturer_id)
                    || $makers->contains($garage->official_service3_manufacturer_id)
                    || $makers->contains($garage->official_service4_manufacturer_id)
                    || $makers->contains($garage->official_service5_manufacturer_id);
                return $garage;
            })->sortByDesc('featured')->values();
        }

        return $garages;
    }
}
