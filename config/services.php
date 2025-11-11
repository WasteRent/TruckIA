<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],


    'distromel' => [
        'acciona' => [
            'username' => env('ACCIONA_DISTROMEL_USERNAME'),
            'password' => env('ACCIONA_DISTROMEL_PASSWORD'),
            'base_url' => env('ACCIONA_DISTROMEL_BASE_URL'),
        ],
        'accion_torrevieja' => [
            'key' => env('ACCIONA_TORREVIEJA_DISTROMEL_KEY'),
        ],
        'acciona_calpe' => [
            'key' => env('ACCIONA_CALPE_DISTROMEL_KEY'),
        ],
        'acciona_la_eliana' => [
            'key' => env('ACCIONA_LAELIANA_DISTROMEL_KEY'),
        ],
    ],
    'moba' => [
        'tetma' => [
            'username' => env('MOBA_TETMA_USERNAME', 'wsjavea'),
            'password' => env('MOBA_TETMA_PASSWORD', '1234'),
            'base_url' => env('MOBA_TETMA_BASE_URL', 'https://moba-comm-05-v.mawisu2.com:443/Mawis2WS.dll/soap/IExternas'),
        ],
        'acciona_premia_de_mar' => [
            'username' => env('MOBA_ACCIONA_PREMIA_DE_MAR_USERNAME'),
            'password' => env('MOBA_ACCIONA_PREMIA_DE_MAR_PASSWORD'),
            'base_url' => env('MOBA_ACCIONA_PREMIA_DE_MAR_BASE_URL', 'http://moba-comm-04-v.mawisu2.com:8090/Mawis2WS.dll/soap/IExternas'),
        ],
        'acciona_martorell' => [
            'username' => env('MOBA_ACCIONA_MARTORELL_USERNAME'),
            'password' => env('MOBA_ACCIONA_MARTORELL_PASSWORD'),
            'base_url' => env('MOBA_ACCIONA_MARTORELL_BASE_URL', 'http://moba-comm-04-v.mawisu2.com:8090/Mawis2WS.dll/soap/IExternas'),
        ],
    ],
    'tomtom' => [
        'wasterent' => [
            'account' => env('WASTERENT_TOMTOM_ACCOUNT'),
            'username' => env('WASTERENT_TOMTOM_USERNAME'),
            'password' => env('WASTERENT_TOMTOM_PASSWORD'),
            'api_key' => env('WASTERENT_TOMTOM_API_KEY'),
            'base_url' => env('WASTERENT_TOMTOM_BASE_URL'),
        ]
    ],
    'wemob' => [
        'svat' => [
            'base_url' => env('SVAT_WEMOB_BASE_URL'),
            'username' => env('SVAT_WEMOB_USERNAME'),
            'password' => env('SVAT_WEMOB_PASSWORD'),
        ],
        'acciona_general' => [
            'base_url' => env('ACCIONA_WEMOB_BASE_URL'),
            'username' => env('ACCIONA_GENERAL_WEMOB_USERNAME'),
            'password' => env('ACCIONA_GENERAL_WEMOB_PASSWORD'),
        ],
        'acciona_eltoyo' => [
            'base_url' => env('ACCIONA_WEMOB_BASE_URL'),
            'username' => env('ACCIONA_ELTOYO_WEMOB_USERNAME'),
            'password' => env('ACCIONA_ELTOYO_WEMOB_PASSWORD'),
        ],
        'acciona_almeria' => [
            'base_url' => env('ACCIONA_WEMOB_BASE_URL'),
            'username' => env('ACCIONA_ALMERIA_WEMOB_USERNAME'),
            'password' => env('ACCIONA_ALMERIA_WEMOB_PASSWORD'),
        ],
        'acciona_cenes_de_la_vega' => [
            'base_url' => env('ACCIONA_WEMOB_BASE_URL'),
            'username' => env('ACCIONA_CENESDELAVEGA_WEMOB_USERNAME'),
            'password' => env('ACCIONA_CENESDELAVEGA_WEMOB_PASSWORD'),
        ],
        'acciona_el_cuervo' => [
            'base_url' => env('ACCIONA_WEMOB_BASE_URL'),
            'username' => env('ACCIONA_ELCUERVO_WEMOB_USERNAME'),
            'password' => env('ACCIONA_ELCUERVO_WEMOB_PASSWORD'),
        ],
    ],
    'movisat' => [
        'svat' => [
            'base_url' => env('SVAT_MOVISAT_BASE_URL'),
            'username' => env('SVAT_MOVISAT_USERNAME'),
            'password' => env('SVAT_MOVISAT_PASSWORD'),
            'client_id' => env('SVAT_MOVISAT_CLIENT_ID'),
            'client_secret' => env('SVAT_MOVISAT_CLIENT_SECRET'),
            'company_id' => env('SVAT_MOVISAT_COMPANY_ID'),
        ],
        'acciona_coslada' => [
            'base_url' => env('ACCIONA_MOVISAT_BASE_URL'),
            'username' => env('ACCIONA_MOVISAT_USERNAME'),
            'password' => env('ACCIONA_MOVISAT_PASSWORD'),
            'client_id' => env('ACCIONA_MOVISAT_CLIENT_ID'),
            'client_secret' => env('ACCIONA_MOVISAT_CLIENT_SECRET'),
            'company_id' => env('ACCIONA_MOVISAT_COMPANY_ID'),
        ],
        'acciona_vinaros' => [
            'base_url' => env('ACCIONA_VINAROS_BASE_URL'),
            'username' => env('ACCIONA_VINAROS_USERNAME'),
            'password' => env('ACCIONA_VINAROS_PASSWORD'),
            'client_id' => env('ACCIONA_VINAROS_CLIENT_ID'),
            'client_secret' => env('ACCIONA_VINAROS_CLIENT_SECRET'),
            'company_id' => env('ACCIONA_VINAROS_COMPANY_ID'),
        ],
        'acciona_colmenar_viejo' => [
            'base_url' => env('ACCIONA_COLMENAR_VIEJO_BASE_URL'),
            'username' => env('ACCIONA_COLMENAR_VIEJO_USERNAME'),
            'password' => env('ACCIONA_COLMENAR_VIEJO_PASSWORD'),
            'client_id' => env('ACCIONA_COLMENAR_VIEJO_CLIENT_ID'),
            'client_secret' => env('ACCIONA_COLMENAR_VIEJO_CLIENT_SECRET'),
            'company_id' => env('ACCIONA_COLMENAR_VIEJO_COMPANY_ID'),
        ],
    ],

    'whatsapp' => [
        'token' => env('WA_TOKEN'),
        'phone_id' => env('WA_PHONE_ID'),
    ],

    'openai' => [
        'key' => env('OPEN_AI_KEY'),
    ],

    'chip2chip' => [
        'acciona' => [
            'client_id' => env('CHIP2CHIP_CLIENT_ID'),
            'client_name' => env('CHIP2CHIP_CLIENT_NAME'),
            'client_secret' => env('CHIP2CHIP_CLIENT_SECRET'),
            'token_base_url' => env('CHIP2CHIP_TOKEN_BASE_URL'),
            'api_base_url' => env('CHIP2CHIP_API_BASE_URL'),
            'token_username' => env('CHIP2CHIP_TOKEN_USERNAME'),
            'token_password' => env('CHIP2CHIP_TOKEN_PASSWORD'),
        ],
    ],
    'lipasam_sap' => [
        'username' => env('LIPASAM_SAP_USERNAME'),
        'password' => env('LIPASAM_SAP_PASSWORD'),
        'endpoint' => env('LIPASAM_SAP_ENDPOINT', 'https://prewss.lipasam.es/z_pm_l_estado_vehiculo_manual'),
    'gemini' => [
        'api_key' => env('GEMINI_API_KEY'),
        'api_url' => env('GEMINI_API_URL'),
    ],
];
