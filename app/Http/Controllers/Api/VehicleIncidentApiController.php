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
            'incidence' => 'required|string',
            'phone' => 'required',
            'date' => 'nullable|date',
            'file' => 'nullable|array',
            'file.base64' => 'required_with:file|string',
            'file.mimetype' => 'required_with:file|string',
            'file.filename' => 'required_with:file|string',
        ]);

        try {
            $vehicle = Vehicle::where('plate', $data['plate'])->first();

            if (!$vehicle) {
                throw new \Exception('Vehículo no encontrado');
            }

            $formatted_phone = (string)$data['phone'];
            $normalized_phone = preg_replace('/[^0-9]/', '', $formatted_phone);
            
            $user = User::where(function($query) use ($normalized_phone) {
                $query->whereRaw('REGEXP_REPLACE(phone, "[^0-9]", "") = ?', [$normalized_phone])
                      ->whereNotNull('phone');
            })->first();

            if (!$user) {
                throw new \Exception('El teléfono no está asociado a ningún usuario');
            }

            $incident_url_content = '';
            
            // Procesar archivo si se proporciona
            if (isset($data['file'])) {
                $file_url = $this->processBase64File($data['file']);
                if ($file_url) {
                    $incident_url_content = '<a href="'.$file_url.'"> Ver documento</a>';
                }
            }

            $incident = VehicleIncident::create([
                'vehicle_id' => $vehicle->id,
                'user_id' => $user->id,
                'incidence' => $data['incidence'] . $incident_url_content,
                'created_at' => $data['date'] ?? now(),
            ]);

            event(new IncidentOpened($incident));

            return response()->json(['message' => 'Incidente creado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'No se pudo crear el incidente: ' . $e->getMessage()], 500);
        }
    }

    private function processBase64File($fileData)
    {
        try {
            // Extraer el base64 del data URL
            $base64Data = $fileData['base64'];
            if (strpos($base64Data, 'data:') === 0) {
                $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
            }
            
            // Decodificar el base64
            $fileContent = base64_decode($base64Data);
            if ($fileContent === false) {
                throw new \Exception('Error al decodificar el archivo base64');
            }
            
            // Obtener la extensión del archivo
            $extension = pathinfo($fileData['filename'], PATHINFO_EXTENSION);
            $filename = pathinfo($fileData['filename'], PATHINFO_FILENAME);
            
            // Crear un archivo temporal con la extensión correcta
            $tempPath = sys_get_temp_dir() . '/' . uniqid('upload_') . '.' . $extension;
            file_put_contents($tempPath, $fileContent);
            
            // Crear un UploadedFile simulado
            $uploadedFile = new \Illuminate\Http\UploadedFile(
                $tempPath,
                $fileData['filename'],
                $fileData['mimetype'],
                null,
                true
            );
            
            // Usar TrixController para guardar el archivo
            $trixController = new TrixController();
            $fileRequest = new Request();
            $fileRequest->files->set('file', $uploadedFile);
            
            $url = $trixController->store($fileRequest);
            
            // Limpiar el archivo temporal
            if (file_exists($tempPath)) {
                unlink($tempPath);
            }
            
            return $url;
        } catch (\Exception $e) {
            throw new \Exception('Error al procesar el archivo: ' . $e->getMessage());
        }
    }
}
