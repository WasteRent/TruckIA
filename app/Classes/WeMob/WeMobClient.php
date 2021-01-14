<?php

namespace App\Classes\WeMob;

use Illuminate\Support\Facades\Http;

class WeMobClient
{
    private $baseUrl;
    private $username;
    private $password;

    public function __construct(string $baseUrl, string $username, string $password)
    {
        $this->baseUrl = $baseUrl;
        $this->username = $username;
        $this->password = $password;
    }

    public function getData()
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?><S:Envelope xmlns:S="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
    <SOAP-ENV:Header/>
    <S:Body>
        <ns2:selMobileInfo xmlns:ns2="http://webservices.wemob.wm.es/">
            <idSession>{$this->generateSessionId()}</idSession>
            <lang>es</lang>
        </ns2:selMobileInfo>
    </S:Body>
</S:Envelope>
XML;

        $response = $this->sendRequest('/MobileWebService', $xml);

        $dom = new \DOMDocument();
        $dom->loadXML($response);

        $data = [];
        foreach ($dom->getElementsByTagName('mobilesInfo') as $value) {
            $data[] = (object)[
                'chassis_hours'     => $value->getElementsByTagName('totalChasisTime')[0]->nodeValue,
                'fuel_level'        => $value->getElementsByTagName('fuelLevel')[0]->nodeValue,
                'fuel_consumption'  => $value->getElementsByTagName('consum')[0]->nodeValue,
                'latitude'          => $value->getElementsByTagName('latitude')[0]->nodeValue,
                'longitude'         => $value->getElementsByTagName('longitude')[0]->nodeValue,
                'plate'             => $value->getElementsByTagName('mobilePlate')[0]->nodeValue,
                'kms'               => $value->getElementsByTagName('totalOdometer')[0]->nodeValue,
                'power_takeoff_hours' => $value->getElementsByTagName('totalPTOTime')[0]->nodeValue,
                'timestamp'         => $value->getElementsByTagName('timestamp')[0]->nodeValue,
            ];
        }

        return $data;
    }

    private function generateSessionId()
    {
        $hashed_password = md5($this->password);

        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?><S:Envelope xmlns:S="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
    <SOAP-ENV:Header/>
    <S:Body>
        <ns2:initSession xmlns:ns2="http://webservices.wemob.wm.es/">
            <login>{$this->username}</login>
            <password>{$hashed_password}</password>
            <idApp>4</idApp>
            <ip>188.166.35.94</ip>
            <close>true</close>
            <lang>es</lang>
        </ns2:initSession>
    </S:Body>
</S:Envelope>
XML;
    
        $response = $this->sendRequest('/AuthenticationService', $xml);

        $dom = new \DOMDocument();
        $dom->loadXML($response);
        $session = $dom->getElementsByTagName('return');

        if (isset($session[0]) && $session[0]->nodeValue) {
            return $session[0]->nodeValue;
        }
        
        throw new Exception('Error generating WeMob session');
    }

    private function sendRequest($service, $body)
    {
        return Http::withBody($body, 'text/xml')->post("{$this->baseUrl}{$service}")->body();
    }
}
