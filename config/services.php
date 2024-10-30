<?php

return [
    'zoho' => [
        'client_id' => env('ZOHO_CLIENT_ID'),
        'client_secret' => env('ZOHO_CLIENT_SECRET'),
        'accounts_domain' => env('ZOHO_DEFAULT_ACCOUNTS_DOMAIN', 'https://accounts.zoho.eu'),
        'api_domain' => env('ZOHO_DEFAULT_API_DOMAIN', 'https://www.zohoapis.eu'),
        'refresh_token' => env('ZOHO_REFRESH_TOKEN'),
    ],
];
