<?php

namespace App\Classes\TomTom;

use Illuminate\Support\Facades\Http;

class TomTomClient
{
    private $baseUrl;
    private $apiKey;
    private $account;
    private $username;
    private $password;

    public function __construct(
        string $baseUrl,
        string $apiKey,
        string $account,
        string $username,
        string $password
    ) {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
        $this->account = $account;
        $this->username = $username;
        $this->password = $password;
    }

    public function executeAction(string $action, array $params = [])
    {
        $query = array_merge($params, [
            'action'    => $action,
            'account'   => $this->account,
            'username'  => $this->username,
            'password'  => $this->password,
            'apikey'    => $this->apiKey,
            'lang'      => 'es',
            'outputformat' => 'json'
        ]);

        return Http::get($this->baseUrl, $query)->json();
    }
}
