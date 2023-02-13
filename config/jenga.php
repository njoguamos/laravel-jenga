<?php

return [
    /*
     |--------------------------------------------------------------------------
     | API V3 Base Endpoint
     |--------------------------------------------------------------------------
     |
     | Base url for interacting with Jenga api. This url predefined and is based
     | on whether the application is in testing or live (production). To avoid
     | accidental data loss, testing base url us set as the default endpoint.
     |
     | Testing:  https://uat.finserve.africa
     | Production: https://api.finserve.africa
     |
     */
    'host' => env(key: 'JENGA_LIVE_MODE', default: false) === true
        ? 'https://api.finserve.africa'
        : 'https://uat.finserve.africa',

    /*
     |--------------------------------------------------------------------------
     | Jenga API Key
     |--------------------------------------------------------------------------
     |
     | By default, all requests that are sent to Jenga Payment Gateway have to be
     | authenticated using your account's API keys. This key is associated to
     | your Jenga HQ account. When testing your application integration, use
     | the testing API key and production key when application is live.
     |
     */
    'key' => env(key: 'JENGA_API_KEY'),

    /*
     |--------------------------------------------------------------------------
     | Jenga Credentials
     |--------------------------------------------------------------------------
     |
     | Merchant code refer to a unique numeric code identifying an organisation.
     | On the other hand, consumer secrete is an alphanumeric code. Both them
     | are provided by JengaHQ and are referred to as credentials.
     |
     */

    'merchant' => env(key: 'JENGA_MERCHANT_CODE'),

    'secret' => env(key: 'JENGA_CONSUMER_SECRET'),


    /*
     |--------------------------------------------------------------------------
     | Encryption Keys Folder Path
     |--------------------------------------------------------------------------
     |
     | Jenga uses encryption keys to secure transaction and request from your
     | application to jenga api endpoint. For convenience, these keys are
     | store in the environment variables as opposed to storage file.
     |
     | Warning: The generated keys are not typically kept in source control.
     |
     */

    'keys_path' => env(key: 'JENGA_KEYS_PATH', default: storage_path('')),
];
