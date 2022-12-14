<?php

return [
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
    'api-key' => env('JENGA_API_KEY'),

    /*
     |--------------------------------------------------------------------------
     | Jenga Merchant Code (Username)
     |--------------------------------------------------------------------------
     |
     | This an numeric code provided by JengaHQ.
     |
     |
     */
    'merchant-code' => env('JENGA_MERCHANT_CODE'),

    /*
     |--------------------------------------------------------------------------
     | Jenga Consumer Secret (Password)
     |--------------------------------------------------------------------------
     |
     | This an alphanumeric code provided by JengaHQ.
     |
     |
     */
    'consumer_secret' => env('JENGA_CONSUMER_SECRET'),

    /*
     |--------------------------------------------------------------------------
     | Base API V3 Endpoint
     |--------------------------------------------------------------------------
     |
     | Base url for interacting with Jenga api. To avoid accidental data loss,
     | testing base url us set as the default endpoint.
     |
     | Testing:  https://uat.finserve.africa
     | Production: https://api-finserve-prod.azure-api.net
     |
     */
    'base_endpoint' => env('JENGA_BASE_ENDPOINT', 'https://uat.finserve.africa'),
];
