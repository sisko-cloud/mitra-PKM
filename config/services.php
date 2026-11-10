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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // Vercel Blob (penyimpanan permanen untuk deployment serverless).
    // Gunakan dua store karena mode akses ditentukan saat store dibuat:
    // - BLOB_READ_WRITE_TOKEN         -> store PUBLIC  (logo, hero, foto produk)
    // - BLOB_READ_WRITE_TOKEN_PRIVATE -> store PRIVATE (dokumen KTP/legalitas)
    'vercel_blob' => [
        'token' => env('BLOB_READ_WRITE_TOKEN'),
        'private_token' => env('BLOB_READ_WRITE_TOKEN_PRIVATE'),
        'api_url' => env('VERCEL_BLOB_API_URL', 'https://vercel.com/api/blob'),
    ],

];
