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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
'razorpay' => [
    'key'    => env('RAZORPAY_KEY'),
    'secret' => env('RAZORPAY_SECRET'),
],
    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => env('GOOGLE_REDIRECT_URI', (env('APP_URL') ? rtrim(env('APP_URL'), '/') : 'https://schoolmapr.com') . '/auth/google/callback'),
    ],

    'recaptcha' => [
        'enabled'    => env('RECAPTCHA_ENABLED', false),
        'site_key'   => env('RECAPTCHA_SITE_KEY', ''),
        'secret_key' => env('RECAPTCHA_SECRET_KEY', ''),
    ],
    'vextro' => [
        'api_key'      => env('VEXTRO_API_KEY', 'vx_e3cb9718f7ec91f50b8e3b18004e67da35e9fe393b1f202a7b65bf7f1513729c'),
        'whatsapp_id'  => env('VEXTRO_WHATSAPP_ID', '01a0b8c7-f10c-77e1-b8d6-499ea6f80a85'),
        'wa_number_id' => env('VEXTRO_WA_NUMBER_ID', '1438181896034122'),
        'waba_id'      => env('VEXTRO_WABA_ID', '2159680121246973'),
    ],
];
