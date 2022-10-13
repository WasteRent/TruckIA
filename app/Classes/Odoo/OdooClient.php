<?php

namespace App\Classes\Odoo;

use Illuminate\Support\Facades\Http;

class OdooClient
{
    private $baseUrl;

    private $account;

    private $username;

    private $password;

    public function __construct(
        string $baseUrl,
        string $account,
        string $username,
        string $password
    ) {
        $this->baseUrl = $baseUrl;
        $this->account = $account;
        $this->username = $username;
        $this->password = $password;
    }

    public function executeAction(string $model, string $action, array $params = [])
    {
        $body = [
            'params' => [
                'service' => 'object',
                'method' => 'execute',
                'args' => [
                    $this->account,
                    $this->username,
                    $this->password,
                    $model,
                    $action,
                    [],
                    (object) $params,
                ],
            ],
        ];

        ini_set("memory_limit", "-1");

        $response = Http::withOptions([
            'expect' => true,
            'read_timeout' => 30,
            'curl' => [
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
                CURLOPT_RETURNTRANSFER => false,
            ]
        ])->withHeaders([
            'accept-encoding' => 'gzip, deflate',
            'Connection' => 'Keep-Alive',
            'Keep-Alive' => '30'
        ])->post($this->baseUrl, $body);

        if ($response->successful() && empty($response['error']['message'])) {
            return collect($response->json());
        }

        throw new \Exception($response->body());
    }
}
