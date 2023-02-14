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

    /*
     |--------------------------------------------------------------------------
     | Default Country Code
     |--------------------------------------------------------------------------
     |
     | When making request such as forex exchange rates, you have to provide
     | the country code. The code are the abbreviations for the East Africa
     | countries where Equity Bank is operating.
     |
     | Supported: KE, TZ, UG and RW
     |
     */

    'country' => env(key: 'JENGA_COUNTRY_CODE', default: 'KE'),

    /*
     |--------------------------------------------------------------------------
     | Default Bank Account
     |--------------------------------------------------------------------------
     |
     | The Default bank account to use when making queries such as balance,
     | mini-statement, full statement,e.t.c. The default bank account
     | provided is for testing - you should add in your Jenga HQ.
     |
     | Learn more: https://support.jengahq.io/hc/en-us/articles/8662846933265-Making-your-First-Jenga-API-call
     |
     */

    'account' => env(key: 'JENGA_DEFAULT_ACC', default: 1450160649886),

    /*
     |--------------------------------------------------------------------------
     | Payment Gateway Checkout Url
     |--------------------------------------------------------------------------
     |
     | Jenga PGW provides you with a simple and secure way to collect online
     | payments. A checkout url is where the check out form is submitted
     | for payment processing. The url differ depending on environment.
     |
     */

    'checkout' => env(key: 'JENGA_LIVE_MODE', default: false) === true
        ? 'https://v3.jengapgw.io/processPayment'
        : 'https://checkout-ui-v3-uat.azurewebsites.net/processPayment',


    /*
     |--------------------------------------------------------------------------
     | Payment Gateway Default Wallet
     |--------------------------------------------------------------------------
     |
     | Jenga PGW requires you to provide a wallet to be used for the transaction.
     | Instead of provided the wallet every time, you can use this config to
     | set the default wallet to bes used depending on environment.
     |
    */

    'wallet' => env(key: 'JENGA_DEFAULT_WALLET'),
];
