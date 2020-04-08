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

    public function executeAction(string $action)
    {
        return Http::get($this->generateEndpoint($action))->json();
    }

    private function generateEndpoint(string $action)
    {
        return "{$this->baseUrl}?lang=en&outputformat=json&account={$this->account}&username={$this->username}&password={$this->password}&apikey={$this->apiKey}&action={$action}";
    }
}
