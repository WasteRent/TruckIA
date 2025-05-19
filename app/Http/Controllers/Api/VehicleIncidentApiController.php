<?php

namespace App\Http\Controllers\Api;

use App\Events\IncidentOpened;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TrixController;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\VehicleIncident;
use App\User;
use Illuminate\Http\Request;

class VehicleIncidentApiController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'plate' => 'required|string',
            'incident' => 'required|string',
            'phone' => 'required|integer',
            'files' => 'nullable|array',
        ]);

        try {
            $vehicle = Vehicle::where('plate', $data['plate'])->first();

            if (!$vehicle) {
                throw new \Exception('Vehículo no encontrado');
            }

            $customer = Customer::where('phone1', $data['phone'])
                                ->orWhere('phone2', $data['phone'])
                                ->orWhere('phone3', $data['phone'])
                                ->orWhere('phone4', $data['phone'])
                                ->first();

            if (!$customer) {
                throw new \Exception('El teléfono no está asociado a ningún cliente');
            }

            $user = User::find($customer->user_id);

            if (!$user) {
                throw new \Exception('El cliente no tiene usuario asociado');
            }

            if (!isset($data['files'])){
                throw new \Exception('No se han proporcionado archivos');
            }

            $trix_controller = new TrixController();
            $urls = [];

            foreach ($data['files'] as $file) {
                $file_request = new Request();
                $file_request->files->set('file', $file);
                $url = $trix_controller->store($file_request);

                if (!$url) {
                    throw new \Exception('Error al procesar el archivo');
                }

                $urls[] = $url;
            }

            $incident_url_content = '';
            foreach ($urls as $url) {
                $incident_url_content .= '<a href="'.$url.'"> Ver documento</a>';
            }

            $incident = VehicleIncident::create([
                'vehicle_id' => $vehicle->id,
                'user_id' => $user->id,
                'incident' => $data['incident'].' '.$incident_url_content,
            ]);

            event(new IncidentOpened($incident));

            return response()->json(['message' => 'Incidente creado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'No se pudo crear el incidente: ' . $e->getMessage()], 500);
        }
    }
}
