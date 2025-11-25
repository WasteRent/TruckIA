<?php

namespace App\Http\Controllers\Api;

use App\Events\IncidentOpened;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TrixController;
use App\Models\Customer;
use App\Models\Fleet;
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
            $vehicle = Vehicle::where('plate', $data['plate'])->where('fleet_id', Fleet::ACCIONA)->first();

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
                    $fileInfo = $this->processBase64File($data['file']);
                    if ($fileInfo) {
                        $incident_url_content = $this->generateTrixAttachment($fileInfo);
                    }
                } catch (\Exception $e) {
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
        // Extraer el base64 del data URL
        $base64Data = $fileData['base64'];
        if (strpos($base64Data, 'data:') === 0) {
            $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
        }
        
        // Decodificar el base64
        $fileContent = base64_decode($base64Data, true);
        if ($fileContent === false || empty($fileContent)) {
            throw new \Exception('Error al decodificar el archivo base64');
        }
        
        // Obtener la extensión del archivo
        $extension = pathinfo($fileData['filename'], PATHINFO_EXTENSION);
        $filesize = strlen($fileContent);
        
        // Obtener dimensiones si es imagen
        $width = null;
        $height = null;
        
        // Crear un archivo temporal con la extensión correcta
        $tempPath = sys_get_temp_dir() . '/' . uniqid('upload_') . '.' . $extension;
        file_put_contents($tempPath, $fileContent);
        
        // Si es imagen, obtener dimensiones
        if (strpos($fileData['mimetype'], 'image/') === 0) {
            $imageInfo = @getimagesize($tempPath);
            if ($imageInfo) {
                $width = $imageInfo[0];
                $height = $imageInfo[1];
            }
        }
        
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
        
        return [
            'url' => $url,
            'filename' => $fileData['filename'],
            'mimetype' => $fileData['mimetype'],
            'filesize' => $filesize,
            'width' => $width,
            'height' => $height,
        ];
    }

    private function generateTrixAttachment($fileInfo)
    {
        $url = $fileInfo['url'];
        $filename = $fileInfo['filename'];
        $mimetype = $fileInfo['mimetype'];
        $filesize = $fileInfo['filesize'];
        $width = $fileInfo['width'];
        $height = $fileInfo['height'];
        
        // URL para descarga
        $href = $url . '?content-disposition=attachment';
        
        // Formatear tamaño del archivo
        $filesizeFormatted = $this->formatBytes($filesize);
        
        // Crear el objeto JSON para data-trix-attachment
        $attachmentData = [
            'contentType' => $mimetype,
            'filename' => $filename,
            'filesize' => $filesize,
            'href' => $href,
            'url' => $url,
        ];
        
        // Si es imagen, añadir dimensiones
        if ($width && $height) {
            $attachmentData['width'] = $width;
            $attachmentData['height'] = $height;
        }
        
        $attachmentJson = json_encode($attachmentData);
        $attachmentJsonEscaped = htmlspecialchars($attachmentJson, ENT_QUOTES, 'UTF-8');
        
        // Obtener extensión para la clase
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        
        // Generar HTML de Trix
        if (strpos($mimetype, 'image/') === 0 && $width && $height) {
            // Es una imagen, usar el formato con figure e img
            $html = '<br><figure data-trix-attachment="' . $attachmentJsonEscaped . '" ';
            $html .= 'data-trix-content-type="' . $mimetype . '" ';
            $html .= 'data-trix-attributes="{&quot;presentation&quot;:&quot;gallery&quot;}" ';
            $html .= 'class="attachment attachment--preview attachment--' . $extension . '">';
            $html .= '<a href="' . $href . '">';
            $html .= '<img src="' . $url . '" width="' . $width . '" height="' . $height . '">';
            $html .= '<figcaption class="attachment__caption">';
            $html .= '<span class="attachment__name">' . htmlspecialchars($filename) . '</span> ';
            $html .= '<span class="attachment__size">' . $filesizeFormatted . '</span>';
            $html .= '</figcaption>';
            $html .= '</a></figure>';
        } else {
            // No es imagen o no tiene dimensiones, usar formato simple
            $html = '<br><a href="' . $href . '">' . htmlspecialchars($filename) . ' (' . $filesizeFormatted . ')</a>';
        }
        
        return $html;
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
