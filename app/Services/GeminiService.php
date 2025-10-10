<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\File;

class GeminiService
{
    private $apiKey;
    private $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->apiUrl = config('services.gemini.api_url');
    }

    public function extractDataFromOCR(File $file)
    {
        $prompt = config('prompts.extract_data_from_ocr');
        try {
            $endpoint = $this->apiUrl . $this->apiKey;
            $payload = [
                'contents' => [
                    'parts' => [
                        [
                            'text' => $prompt,
                        ],
                    ]
                ]
            ];
            $payload['contents']['parts'][] = [
                'inlineData' => [
                    'mimeType' => $file->content_type,
                    'data' => $file->getBase64()
                ]
            ];

            $payload['generationConfig'] = ['response_mime_type' => 'application/json'];

            $response = Http::timeout(600)->withHeaders(['Content-Type' => 'application/json'])->post($endpoint, $payload);

            $result = json_decode($response->getBody(), true);
            
            // Verificar si hay error en la respuesta de Gemini
            if (isset($result['error'])) {
                return [
                    'error' => true,
                    'error_details' => $result['error']
                ];
            }
            
            $responseText = $result['candidates'][0]['content']['parts'][0]['text'];
            $decoded_result = json_decode($responseText, true);

            if (isset($decoded_result['0']) && is_array($decoded_result['0'])) {
                $decoded_result = $decoded_result['0'];
            }
            
            dd($decoded_result);
            return $decoded_result;

        } catch (\Exception $e) {
            return [
                'error' => true,
                'error_details' => [
                    'code' => 500,
                    'message' => $e->getMessage(),
                    'status' => 'INTERNAL_ERROR'
                ]
            ];
        }
    }
}
