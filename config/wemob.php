<?php

return [

    /*
    |--------------------------------------------------------------------------
    | WeMob
    |--------------------------------------------------------------------------
    |
    */

    'svat' => [
        'username' => env('SVAT_WEMOB_USERNAME'),
        'password' => env('SVAT_WEMOB_PASSWORD'),
    ],
    'acciona' => [
        'username' => env('ACCIONA_WEMOB_USERNAME'),
        'password' => env('ACCIONA_WEMOB_PASSWORD'),
    ],

    'base_url' => env('WEMOB_BASE_URL'),
];
