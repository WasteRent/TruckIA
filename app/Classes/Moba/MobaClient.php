<?php

namespace App\Classes\Moba;

use Illuminate\Support\Facades\Http;

class MobaClient
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
        $body = <<<XML
        <soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:ExternasIntf-IExternas" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">
            <soapenv:Header/>
            <soapenv:Body>
                <urn:GetActividadVehiculos soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                    <login xsi:type="xsd:string">{$this->username}</login>
                    <password xsi:type="xsd:string">{$this->password}</password>
                    <fechaDesde xsi:type="xsd:string">18/07/2022 10:00:00</fechaDesde>
                    <fechaHasta xsi:type="xsd:string">18/07/2022 14:00:00</fechaHasta>
                    <listaMatriculas xsi:type="urn:TArrayCadenas" soapenc:arrayType="xsd:string[]" xmlns:urn="urn:uTiposRemotos">
                        <xsd:string>4467LVR</xsd:string>
                    </listaMatriculas>
                </urn:GetActividadVehiculos>
            </soapenv:Body>
        </soapenv:Envelope>
        XML;

        return Http::withBody($body, 'text/xml')
                ->post($this->baseUrl)
                ->body();
    }

}
