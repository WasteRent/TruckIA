<?php

namespace App\Classes\Movisat;

use Illuminate\Support\Facades\Http;

class MovisatClient
{
    private $token;

    public function __construct(
        private string $base_url,
        private string $username,
        private string $password,
        private string $client_id,
        private string $client_secret,
        private string $company_id,
    ) {
        $this->token = $this->getToken();
    }

    public function getDevices() {
        $response = Http::withToken($this->token)->get("{$this->base_url}/moviles/{$this->company_id}")->json();
        return collect($response)->map(function($item) {
            return ['movil' => $item['Codigo'], 'plate' => $item['Matricula']];
        });
    }

    public function getPosition(int $movil) {
        $result = Http::withToken($this->token)->post("{$this->base_url}/api/posiciones", [
            "movil" => $movil,
            "desde" => date('Y-m-d H:i:s', strtotime("-24 hours")),
            "hasta" => date('Y-m-d H:i:s'),
        ])->json();

        if (count($result)) {
            return collect($result)->sortByDesc('Fecha')->first();
        }

        return null;
    }

    public function getHours(int $movil) {
        $result = Http::withToken($this->token)->post("{$this->base_url}/api/sensores/horometro", [
            "movil" => $movil,
            "desde" => date('Y-m-d H:i:s', strtotime("-30 days")),
            "hasta" => date('Y-m-d H:i:s'),
        ])->json();

        if (count($result)) {
            return collect($result)->sortByDesc('Fecha')->first()['Lectura'];
        }

        return null;
    }

    public function getKms(int $movil) {
        $result = Http::withToken($this->token)->post("{$this->base_url}/api/sensores/kms", [
            "movil" => $movil,
            "desde" => date('Y-m-d H:i:s', strtotime("-24 hours")),
            "hasta" => date('Y-m-d H:i:s'),
        ])->json();

        if (count($result)) {
            return collect($result)->sortByDesc('Fecha')->first()['Lectura'];
        }

        return null;
    }

    private function getToken() {
        return Http::asForm()->post("{$this->base_url}/token", [
            'grant_type' => 'password',
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'username' => $this->username,
            'password' => $this->password,
        ])->json('access_token');
    }
}
