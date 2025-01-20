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
        <soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:ExternasXMLIntf-IExternasXML">
            <soapenv:Header/>
            <soapenv:Body>
                <urn:GetInfoTrabajoVehiculos soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                    <login xsi:type="xsd:string">{$this->username}</login>
                    <password xsi:type="xsd:string">{$this->password}</password>
                    <datos xsi:type="xsd:string">
                        <PARAMS>
                            <FECHA_DESDE>{$date_from}</FECHA_DESDE>
                            <FECHA_HASTA>{$date_to}</FECHA_HASTA>
                            <MATs>
                                <MAT>{$plate}</MAT>
                            </MATs>
                        </PARAMS>
                    </datos>
                </urn:GetInfoTrabajoVehiculos>
            </soapenv:Body>
            </soapenv:Envelope>
        XML;
    
        $response = Http::withBody($body, 'text/xml')
                ->post($this->baseUrl . 'XML')
                ->body();
        
        // Extract the XML content from the SOAP response
        if (preg_match('/<return[^>]*>(.*?)<\/return>/', $response, $matches)) {
            $xmlContent = html_entity_decode($matches[1]);
            
            // Load and parse the XML
            $xml = simplexml_load_string($xmlContent);
            if ($xml === false) {
                throw new \Exception('Failed to parse XML response');
            }

            // Convert to array and get KM_TOTAL
            $veh = $xml->VEH;
            if (!isset($veh->KM_TOTAL)) {
                throw new \Exception('KM_TOTAL not found in response: ' . $response);
            }

            // Convert comma decimal separator to period and cast to float
            $kmTotal = (float) str_replace(',', '.', (string)$veh->KM_TOTAL);
            
            return $kmTotal;
        }

        throw new \Exception('Could not extract return value from SOAP response');
    }
}
