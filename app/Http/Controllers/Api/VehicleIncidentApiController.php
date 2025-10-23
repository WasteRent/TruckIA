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
                try {
                    $file_url = $this->processBase64File($data['file']);
                    if ($file_url) {
                        $incident_url_content = '<br><a href="'.$file_url.'">Ver imagen</a>';
                    }
                } catch (\Exception $e) {
                    \Log::error('Error al procesar archivo en incidente: ' . $e->getMessage());
                    // Continuar sin el archivo si hay error
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
            \Log::info('Iniciando procesamiento de archivo base64', [
                'filename' => $fileData['filename'] ?? 'no-filename',
                'mimetype' => $fileData['mimetype'] ?? 'no-mimetype',
                'base64_length' => isset($fileData['base64']) ? strlen($fileData['base64']) : 0
            ]);
            
            // Extraer el base64 del data URL
            $base64Data = $fileData['base64'];
            if (strpos($base64Data, 'data:') === 0) {
                $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
            }
            
            // Decodificar el base64
            $fileContent = base64_decode($base64Data, true);
            if ($fileContent === false) {
                throw new \Exception('Error al decodificar el archivo base64');
            }
            
            \Log::info('Archivo decodificado correctamente', ['size' => strlen($fileContent)]);
            
            // Obtener la extensión del archivo
            $extension = pathinfo($fileData['filename'], PATHINFO_EXTENSION);
            $filename = pathinfo($fileData['filename'], PATHINFO_FILENAME);
            
            // Crear un archivo temporal con la extensión correcta
            $tempPath = sys_get_temp_dir() . '/' . uniqid('upload_') . '.' . $extension;
            file_put_contents($tempPath, $fileContent);
            
            \Log::info('Archivo temporal creado', ['path' => $tempPath]);
            
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
            
            \Log::info('Archivo guardado correctamente', ['url' => $url]);
            
            // Limpiar el archivo temporal
            if (file_exists($tempPath)) {
                unlink($tempPath);
            }
            
            return $url;
        } catch (\Exception $e) {
            \Log::error('Error en processBase64File: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            throw new \Exception('Error al procesar el archivo: ' . $e->getMessage());
        }
    }
}
