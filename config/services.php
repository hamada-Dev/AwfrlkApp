<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
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

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'google' => [
        'client_id' => '976395952147-3si052e4je0brqgtjksrkj2ktdpq0pks.apps.googleusercontent.com',
        'client_secret' => '40AmMKki9vuFjOXNIS3paUYp',
        'redirect' => 'http://localhost/auth/google/callback',
        ],

    'facebook' => [
        'client_id' => '988563988149773',
        'client_secret' => 'cad36faf2f4d39369d86a6112a37d2bf',
        'redirect' => 'http://localhost/auth/facebook/callback',
        ],

    'twitter' => [
        'client_id' => 'hAGyEYy6hcIgsg9GqN3M7WUSC',
        'client_secret' => '9xqJsGxx8zs1CjkIYZgpgt3u79cHEhcAHBha4xoFgBDIiuDj2I',
        'redirect' => 'http://localhost/auth/twitter/callback',
    ],
];
