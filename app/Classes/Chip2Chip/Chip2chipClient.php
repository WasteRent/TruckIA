<?php

namespace App\Classes\Chip2Chip;

use Exception;
use Illuminate\Support\Facades\Http;
use Jumbojett\OpenIDConnectClient;

class Chip2chipClient
{
    public const ASSET_GROUP_ID = 1625688632072515584;

    private $api_base_url;
    private $id_base_url;
    private $client_id;
    private $client_secret;
    private $client_name;
    private $token_username;
    private $token_password;


    public function __construct(string $api_base_url, string $id_base_url, string $client_id, string $client_secret, string $client_name, string $token_username, string $token_password)
    {
        $this->api_base_url = $api_base_url;
        $this->id_base_url = $id_base_url;
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->client_name = $client_name;
        $this->token_username = $token_username;
        $this->token_password = $token_password;
    }

    public function getAssets(): array
    {
        return $this->request('GET', "/api/assets/group/" . self::ASSET_GROUP_ID, []);
    }


    public function getLatestTrips(array $asset_ids, int $quantity = 1): array
    {
        return $this->request('POST', '/api/trips/assets/latest/' . $quantity, $asset_ids);
    }

    private function getToken(): string
    {
        try {
            $oidc = new OpenIDConnectClient($this->id_base_url, $this->client_id, $this->client_secret);
            $oidc->providerConfigParam(['token_endpoint' => $this->id_base_url."/connect/token"]);
            $oidc->addScope(["offline_access", "MiX.Integrate"]);
            $oidc->setClientName($this->client_name);
            $oidc->addAuthParam(['username' => $this->token_username]);
            $oidc->addAuthParam(['password' => $this->token_password]);
            $token = $oidc->requestResourceOwnerToken(true);
            return $token->access_token;
        } catch (Exception $e) {
            throw new Exception("Error al generar el token: " . $e->getMessage() . "\n");
        }
    }

    private function request(string $method, string $endpoint, array $params = []): array
    {
        $request = Http::withHeaders([
            'Authorization' => "Bearer {$this->getToken()}",
            'Accept' => 'application/json',
        ])
            ->withToken($this->getToken())
            ->baseUrl($this->api_base_url);

        $response = match (strtoupper($method)) {
            'GET' => $request->get($endpoint, $params),
            'POST' => $request->post($endpoint, $params),
            default => throw new \InvalidArgumentException("Método HTTP no soportado: {$method}")
        };

        if ($response->successful()) {
            $data = $response->json();
            return is_array($data) ? $data : [];
        }
        
        throw new Exception("Error en la respuesta de la API: " . $response->status() . " - " . $response->body());
    }
}
