<?php

return [
    /*
     |--------------------------------------------------------------------------
     | API V3 Base Endpoint
     |--------------------------------------------------------------------------
     |
     | Base url for interacting with Jenga api. To avoid accidental data loss,
     | testing base url us set as the default endpoint.
     |
     | Testing:  https://uat.finserve.africa
     | Production: https://api-finserve-prod.azure-api.net
     |
     */
    'host'     => env('JENGA_BASE_ENDPOINT', 'https://uat.finserve.africa'),

    /*
     |--------------------------------------------------------------------------
     | Jenga API Key
     |--------------------------------------------------------------------------
     |
     | By default, all requests that are sent to Jenga Payment Gateway have to be
     | authenticated using your account's API keys. This key is associated to
     | your Jenga HQ account. When testing your application integraton, use
     | the testing API key and production key when application is live.
     |
     |
     */
    'key'      => env('JENGA_API_KEY'),

    /*
     |--------------------------------------------------------------------------
     | Jenga Merchant Code (Username)
     |--------------------------------------------------------------------------
     |
     | This an numeric code provided by JengaHQ.
     |
     |
     */
    'merchant' => env('JENGA_MERCHANT_CODE'),

    /*
     |--------------------------------------------------------------------------
     | Jenga Consumer Secret (Password)
     |--------------------------------------------------------------------------
     |
     | This an alphanumeric code provided by JengaHQ.
     |
     |
     */
    'secret'   => env('JENGA_CONSUMER_SECRET'),
];
