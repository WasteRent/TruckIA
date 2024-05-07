<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\User;
use Illuminate\Http\Request;

//1. Obtener vehiculos
class SearchVehicleJsonController extends Controller
{
    public function index(Request $request)
    {
        $user = User::find(1031);
        $vehicles = Vehicle::whereHas('tracking')->where('fleet_id', $user->fleet->id)->get();

        if ($vehicles->isEmpty()) {
            return response()->json(['message' => 'No existen vehículos'], 404);
        }

        $data = $vehicles->map(function ($vehicle) {
            return [
                //donde saco todos estos campos?
                "id" => $vehicle->id, //IDActivo es id de vehiculo???
                "id_fleet" =>  $vehicle->fleet->id, // IDContrato  id de flota???
                "DescActivo" => "FURGON HIDROLIMPIADOR", //DescActivo ?? ni idea
                "contact_id" => $vehicle->deliveries->first()?->id, //IDContrato ?? no lo tengo claro
                "contact" => $vehicle->deliveries->first()?->contract_type, //Contrato no lo tengo claro
                "zone_id" => "UCOS", //IDZona no he consegiuido sacar esto de la zonas
                "zone" => "UTE COSLADA LV", //Zona ni idea
                "NGINSerie" => "", //NGINSerie ni idea
                "plate" => $vehicle->plate, //Matricula
                "maker" => $vehicle->maker, //IDMarca
                "DescMarca" => "IVECO", //DescMarca no se a que se refieren con Desc
                "Familia" => "FG", //Familia ni idea
                "DescFamilia" => $vehicle->type, //DescFamilia ni idea
                "SubFamilia" => "FH", //SubFamilia ni idea
                "DescSubFamilia" => "FURGON HIDROLIMPIADOR" //DescSubFamilia ni idea
            ];
        })->toArray();


        return response()->json(['data' => $data], 200);
    }
}
