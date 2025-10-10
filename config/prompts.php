<?php


return [

    'extract_data_from_ocr' => <<<'EOT'
        Extrae los datos de la imagen adjunta. Pasalo a formato JSON y en ingles las keys.

        El formato de salida debe ser:
        {
            "invoiceNumber" => "1234567890",
            "client" => "WASTERENT"
            "address" => null
            "cif" => null
            "repairLocation" => null
            "tel" => "of"
            "repairDateMonth" => null
            "repairDateYear" => "25"
            "day" => "30"
            "normalHours" => "6"
            "departureTime" => null
            "arrivalTime" => null
            "serviceRequestedBy" => "PABLO BAYONA"
            "servicePerformedBy" => "TECMA"
            "outsideWorkshopHours" => null
            "extraordinaryHours" => null
            "nightHolidayHours" => null
            "travelHours" => null
            "extraordinaryTravelHours" => null
            "transport" => null
            "licensePlate" => null
            "kms" => null
            "machineData" => array:5 [▶]
            "workRequested" => null
            "takenMeasurements" => "Equipo Fayur Rotopres en Carpa. Realizar manteniento de equipo requn fabrica se sustituye aceite hidiaulico, filtiMidraulico aceita del playetaretario se eugdra ▶"
            "usedMaterials" => """
                98 litros aceite HLP46x3-10% = 2,64,60
                2,5 litres Ep 220 x 4 = 10€
                """
            "observations" => null
            "technicianSignature" => null
            "clientSignature" => null
            "finished" => "SIX"
            "date" => "1110125"
            "netTotal" => "574,60"
            "iva" => "120,66"
            "total" => "695,26"
        }
    EOT,

];
