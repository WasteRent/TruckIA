<?php

namespace App\Classes\Distromel;

use Illuminate\Support\Facades\Http;

class DistromelClient
{
    private $baseUrl;

    private $user;

    private $password;

    private $key;

    public function __construct(
        string $baseUrl,
        string $user,
        string $password,
        string $key
    ) {
        $this->baseUrl = $baseUrl;
        $this->user = $user;
        $this->password = $password;
        $this->key = $key;
    }

    public function getResourceTypes() {
        return $this->executeRequest('POST', '/GetResourceTypes', '0');
    }

    public function getResourceStats(string $id) {
        return $this->executeRequest('POST', '/GetEquipmentResourceSummary', $id);
    }

    public function getResources() {
        return $this->executeRequest('GET', '/GetEquipmentResources');
    }

    public function executeRequest(string $method, string $path, mixed $params = [])
    {
        $headers = [
            'IDENTITY_KEY' => $this->key,
            'Content-Type' => 'application/json'
        ];

        $response = Http::withBasicAuth($this->user, $this->password)
                    ->acceptJson()
                    ->withHeaders($headers);

        if ('GET' == strtoupper($method)) {
            $response = $response->get("{$this->baseUrl}{$path}", $params);
        } else if('POST' == strtoupper($method)) {
            $response = $response->post("{$this->baseUrl}{$path}", $params);
        } else {
            throw new \Exception('Invalid method');
        }

        if ($response->successful()) {
            $raw = preg_replace('/[[:^print:]]/', '', $response->body());
            return collect(json_decode($raw));
        }

        throw new \Exception($response->body());
    }
}
