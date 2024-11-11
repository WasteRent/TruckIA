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
            'key' => env('ACCIONA_DISTROMEL_KEY'),
        ]
    ],
    'moba' => [
        'tetma' => [
            'username' => env('MOBA_TETMA_USERNAME', 'wsjavea'),
            'password' => env('MOBA_TETMA_PASSWORD', '1234'),
            'base_url' => env('MOBA_TETMA_BASE_URL', 'https://moba-comm-05-v.mawisu2.com:443/Mawis2WS.dll/soap/IExternas'),
        ],
        'acciona' => [
            'username' => env('MOBA_ACCIONA_USERNAME'),
            'password' => env('MOBA_ACCIONA_PASSWORD'),
            'base_url' => env('MOBA_ACCIONA_BASE_URL', 'https://moba-comm-05-v.mawisu2.com:443/Mawis2WS.dll/soap/IExternas'),
        ]
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
        'acciona' => [
            'base_url' => env('ACCIONA_MOVISAT_BASE_URL'),
            'username' => env('ACCIONA_MOVISAT_USERNAME'),
            'password' => env('ACCIONA_MOVISAT_PASSWORD'),
            'client_id' => env('ACCIONA_MOVISAT_CLIENT_ID'),
            'client_secret' => env('ACCIONA_MOVISAT_CLIENT_SECRET'),
            'company_id' => env('ACCIONA_MOVISAT_COMPANY_ID'),
        ],
    ],

    'whatsapp' => [
        'token' => env('WA_TOKEN'),
        'phone_id' => env('WA_PHONE_ID'),
    ],

    'openai' => [
        'key' => env('OPEN_AI_KEY'),
    ],

];
