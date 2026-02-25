<?php

namespace App\Classes\WasteId;

use Exception;
use Illuminate\Support\Facades\Http;

class WasteIdClient
{
    private $api_base_url;
    private $login_url;
    private $api_key;
    private $api_secret;

    public function __construct(
        string $api_base_url,
        string $login_url,
        string $api_key,
        string $api_secret
    ) {
        $this->api_base_url = $api_base_url;
        $this->login_url = rtrim($login_url, '/') . '/';
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
    }

    public function getDevices(): array
    {
        return $this->request('GET', 'devices/', []);
    }

    public function getDeviceTypes(): array
    {
        return $this->request('GET', 'devices/types', []);
    }

    public function getDeviceRoute(int $device_id, string $start_date, string $end_date): array
    {
        $params = [
            'StartDate' => $start_date,
            'EndDate' => $end_date,
        ];

        $endpoint = "device/{$device_id}/coordinates";

        return $this->request('GET', $endpoint, $params);
    }

    public function getToken(): string
    {
        $timestamp = (string) time();
        $raw_signature = $this->api_key . $this->api_secret . $timestamp . 'GET' . $this->login_url;
        $signature = base64_encode(hash('sha256', $raw_signature));

        $response = Http::withHeaders([
            'x-apikey' => $this->api_key,
            'x-timestamp' => $timestamp,
            'x-signature' => $signature,
        ])->get($this->login_url);

        $data = $response->json();
        $token = is_array($data) ? ($data['token'] ?? null) : null;
        $result = is_array($data) ? ($data['result'] ?? null) : null;
        $error_message = is_array($data) ? ($data['error'] ?? null) : 'Respuesta no válida';

        if (! $token || $result !== 'OK') {
            $error_text = is_string($error_message) ? $error_message : json_encode($error_message);
            throw new Exception("Error en la respuesta de autenticación de WasteId: " . $error_text);
        }

        return $token;
    }

    private function request(string $method, string $endpoint, array $params = []): array
    {
        $token = $this->getToken();

        $request = Http::withHeaders([
            'x-token' => $token,
            'Accept' => 'application/json',
        ])->baseUrl($this->api_base_url);

        $response = match (strtoupper($method)) {
            'GET' => $request->get($endpoint, $params),
            'POST' => $request->post($endpoint, $params),
            default => throw new \InvalidArgumentException("Método HTTP no soportado: {$method}")
        };

        if (! $response->successful()) {
            throw new Exception("Error HTTP en la llamada a WasteId: " . $response->status() . " - " . $response->body());
        }

        $data = $response->json();

        if (! is_array($data)) {
            return [];
        }

        if (array_key_exists('result', $data)) {
            $result = $data['result'] ?? null;
            $payload = $data['data'] ?? [];

            if ($result !== 'OK') {
                return [];
            }

            return is_array($payload) ? $payload : [];
        }

        return $data;
    }
}

