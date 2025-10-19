<?php


return [

    'extract_data_from_ocr' => <<<'EOT'
        Puedes extraer toda la informacion sobre las operaciones realizadas y los recambios de un orden de reparación de un vehículo. Coloca el resultado en un JSON.

        Haz una distinción entre los recambios y las operaciones, los recambios suelen ser objetos fisicos usados en la reparación y las operaciones suelen ser servicios realizados..
        Los valores quantity, hours, unit_price y total_price de las operaciones y recambios deben ser números.
        El precio unitario de los recambios puede aparecer como "Precio unitario" o "Precio".
        El JSON debe tener la siguiente estructura:
        {
            "parts": [
                {
                    "manufacturer": "Marca del recambio",
                    "description": "Descripcion del recambio",
                    "quantity": "Cantidad del recambio",
                    "unit_price": "Precio unitario del recambio",
                }
            ],
            "operations": [
                {
                    "description": "Descripcion de la operación",
                    "quantity": "Cantidad de la operación",
                    "hours": "Horas de la operación",
                    "unit_price": "Total de la operación",
                }
            ]
        }

    EOT,

];
