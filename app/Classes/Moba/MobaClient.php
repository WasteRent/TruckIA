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

    public function getData(string $plate, string $date_from, string $date_to)
    {
        $body = <<<XML
        <soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:ExternasIntf-IExternas" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">
            <soapenv:Header/>
            <soapenv:Body>
                <urn:GetActividadVehiculos soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                    <login xsi:type="xsd:string">{$this->username}</login>
                    <password xsi:type="xsd:string">{$this->password}</password>
                    <fechaDesde xsi:type="xsd:string">{$date_from}</fechaDesde>
                    <fechaHasta xsi:type="xsd:string">{$date_to}</fechaHasta>
                    <listaMatriculas xsi:type="urn:TArrayCadenas" soapenc:arrayType="xsd:string[]" xmlns:urn="urn:uTiposRemotos">
                        <xsd:string>{$plate}</xsd:string>
                    </listaMatriculas>
                </urn:GetActividadVehiculos>
            </soapenv:Body>
        </soapenv:Envelope>
        XML;

        return Http::withBody($body, 'text/xml')
                ->post($this->baseUrl)
                ->body();
    }


    public function getKms(string $plate, string $date_from, string $date_to) {
        $body = <<<XML
        <soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:ExternasIntf-IExternas" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">
        <soapenv:Header/>
        <soapenv:Body>
            <urn:GetPerifericoVehiculos soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                <login xsi:type="xsd:string">{$this->username}</login>
                <password xsi:type="xsd:string">{$this->password}</password>
                <tipoPeriferico xsi:type="xsd:string">KM</tipoPeriferico>
                <fechaDesde xsi:type="xsd:string">{$date_from}</fechaDesde>
                <fechaHasta xsi:type="xsd:string">{$date_to}</fechaHasta>
                <listaMatriculas xsi:type="urn:TArrayCadenas" soapenc:arrayType="xsd:string[1]">
                    <item xsi:type="xsd:string">{$plate}</item>
                </listaMatriculas>
            </urn:GetPerifericoVehiculos>
        </soapenv:Body>
        </soapenv:Envelope>
        XML;

        $response = Http::withBody($body, 'text/xml')
                ->post($this->baseUrl)
                ->body();

        return $this->parsePerifericoResponse($response);
    }

    public function getHours(string $plate, string $date_from, string $date_to) {
        $body = <<<XML
        <soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:ExternasIntf-IExternas" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">
        <soapenv:Header/>
        <soapenv:Body>
            <urn:GetPerifericoVehiculos soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                <login xsi:type="xsd:string">{$this->username}</login>
                <password xsi:type="xsd:string">{$this->password}</password>
                <tipoPeriferico xsi:type="xsd:string">fms.OH</tipoPeriferico>
                <fechaDesde xsi:type="xsd:string">{$date_from}</fechaDesde>
                <fechaHasta xsi:type="xsd:string">{$date_to}</fechaHasta>
                <listaMatriculas xsi:type="urn:TArrayCadenas" soapenc:arrayType="xsd:string[1]">
                    <item xsi:type="xsd:string">{$plate}</item>
                </listaMatriculas>
            </urn:GetPerifericoVehiculos>
        </soapenv:Body>
        </soapenv:Envelope>
        XML;

        $response = Http::withBody($body, 'text/xml')
                ->post($this->baseUrl)
                ->body();

        return $this->parsePerifericoResponse($response);
    }

    protected function parsePerifericoResponse(string $response): ?array
{
        $xml = simplexml_load_string($response);

        $xml->registerXPathNamespace('SOAP-ENV', 'http://schemas.xmlsoap.org/soap/envelope/');
        $xml->registerXPathNamespace('NS1', 'urn:ExternasIntf-IExternas');

        $return_content = (string)$xml->xpath('//return')[0];

        // Decode the HTML entities to get clean XML
        $decoded_xml = html_entity_decode($return_content);

        // If you want to parse the inner XML content into an object
        $registros = simplexml_load_string($decoded_xml);

        $result = [];
        foreach ($registros->registro as $registro) {
            $result[] = [
                'matricula' => (string)$registro->matricula,
                'calca' => (string)$registro->calca,
                'codigo' => (string)$registro->codigo,
                'fechaHora' => (string)$registro->fechaHora,
                'valor' => (float)$registro->valor
            ];
        }

        // Parse 'fechaHora' to Y-m-d H:i:s for sorting, since original is DD/MM/YYYY H:i:s
        $sorted = collect($result)->sortByDesc(function($item) {
            $dt = \DateTime::createFromFormat('d/m/Y H:i:s', $item['fechaHora']);
            return $dt ? $dt->format('Y-m-d H:i:s') : $item['fechaHora'];
        })->values();

        return $sorted->first();
    }
}

