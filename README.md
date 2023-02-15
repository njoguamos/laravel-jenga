> **Warning**
> This package is still in development and is not production ready. Use for testing and development.


![Cover](art/cover.png)

# Jenga API wrapper for Laravel
[![run-tests](https://github.com/njoguamos/laravel-jenga/actions/workflows/run-test.yml/badge.svg)](https://github.com/njoguamos/laravel-jenga/actions/workflows/run-test.yml)
[![License](https://img.shields.io/github/license/njoguamos/laravel-jenga.svg)](https://github.com/njoguamos/laravel-jenga)
[![Latest Stable Version](https://img.shields.io/packagist/v/njoguamos/laravel-jenga.svg)](https://packagist.org/packages/njoguamos/laravel-jenga)
![Issues](https://img.shields.io/github/issues/njoguamos/laravel-jenga)
[![Total Downloads](https://img.shields.io/packagist/dt/njoguamos/laravel-jenga.svg?style=flat-square)](https://packagist.org/packages/njoguamos/laravel-jenga)

## 1. Why use this package
1. To provide a way of generating jenga api `access_token` after a give period e.g every 15 minutes
2. To provide a fluent way of generating jenga api key pair of `private key` and `public key`
3. To automate generation of jenga api `Bearer Token`
4. Offer a seamless gateway to interacting with Jenga API

>**Info**
>Ready to get started? I have prepared a [playground which you can clone](https://github.com/njoguamos/laravel-jenga-playground) and get started. It will help you test your crendentials while showinf you how to integrate this package with your laravel application.

## 2. Documentation

### 2.1 Installation

Use the Composer package manager to install this package into your Laravel project

```bash
composer require njoguamos/laravel-jenga
```

### 2.2 Update your `.env` variables

This package assumes that you have a  JengaHQ account, and that you have `Api Key`, `Merchant Code` and `Consumer Secret` (from Jenga)(https://developer.jengaapi.io/docs/developer-quickstart).

Copy the respective keys and place them in the `.env` as show in the example below.

```dotenv
JENGA_MERCHANT_CODE=
JENGA_LIVE_MODE=false
JENGA_API_KEY=
JENGA_CONSUMER_SECRET=

# Optional
JENGA_DEFAULT_ACC=
JENGA_DEFAULT_WALLET=
```

> **Note**
> For `JENGA_LIVE_MODE` use `false` when testing and `true` when running live transactions

### 2.3 Initialising the Package

You must run install command that will publish the `jenga.php` config file and `create_jenga_tokens` migration

```bash
php artisan jenga:install
```

> **Note**
> For security reasons, `access_token` and `refresh_token` will be encrypted using you `application key`. You can learn more about encryption from [Laravel documentation](https://laravel.com/docs/9.x/encryption)


You can go ahead and migrate the database.

```bash
php artisan migrate
```

### 2.4 Generating `Bearer Token`

Once you have valid credentials, run the following command.

```bash
php artisan jenga:auth
```

This command will get an `access_token` token from Jenga API and add them into a new record on `jenga` table.

This command may fail:
- When you are not connected to the internet
- When `Api Key` or `Consumer Secret` or `Merchant` is/are invalid
- There is a problem with jenga api endpoint

### 2.5 Generate `Bearer Token` Frequently
The generated `access_token` expires after a particular period usually after `one hour`. To generate a new `access_token` automatically, schedule the `jenga:auth` command in the console kernel. The schedule time should be less than 15 minutes.

```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    # ...
    $schedule->command(command: 'jenga:auth')->everyThirtyMinutes();
}
```

### 2.6 Clearing Expired Token
To periodically deleted expired `Bearer Token`, schedule `model:prune` command in the console kernel.

```php
// app/Console/Kernel.php

use NjoguAmos\Jenga\Models\JengaToken;
 
protected function schedule(Schedule $schedule)
{
    # ...
     $schedule->command(command: 'model:prune', parameters: [
        '--model' => [JengaToken::class],
    ])->everyFiveMinutes();
}
```

### 2.7 Generate Private and Public Keys
To generate a key pair of private and public key, run the following command.

```bash
php artisan jenga:keys
```

This command will create a `jenga.key` and `jenga.pub.key` file in your laravel application storage folder. You can customise the directory using `JENGA_KEYS_PATH` variable. 

```text
# ./yourapplication/storage/jenga.key

-----BEGIN PRIVATE KEY-----
<private key here>
-----END RSA PRIVATE KEY-----
```

```text
# ./yourapplication/storage/jenga.pub.key

-----BEGIN PUBLIC KEY-----
<public key here>
-----END PUBLIC KEY-----
```

You may use `--force` flag to replace existing keys. The default key size is `4096`

>**Warning**
> The generated keys files **SHOULD NEVER** be kept in source control. Make sure you add them to you gitignore file.

> **Note**
> Extensions like `bcmath`, `gmp`, `libsodium` and `openssl` are required when generating they keys.

## 3. Usage

### 3.1 Generating signature
To generate a signature manually, call `getSignature` method in `JengaSignature` class using the data you want to sign.

>**Info**
> The data is signed in the order it is passed.

```php
use NjoguAmos\Jenga\JengaSignature;

$data = [
    "accountId"   => "0011547896523",
    "countryCode" => "KE",
    "date"        => "2022-01-01"
];

$signature = (new JengaSignature(data: $data))->getSignature();
// This will return signature for "0011547896523KE2022-01-01'
// "NCgbapJwPIt+203eyADfPSvPX6uWPPVwMbFdrW+3XoT7oQC2+IaS6srFIGGdMrwrTH ..." 
```

### 3.2 Payment Gateway Checkout

To use the payment gateway, prepare the data using the backend and pass to the browser form.

```php
<?php
use NjoguAmos\Jenga\Models\JengaToken;

return view(view: 'check-out', data: [
    'token' => JengaToken::query()->latest()->first()?->access_token, // Token generated via auth API
    'checkOutUrl' => config(key: 'jenga.checkout'), // Check our url. Don't modify
    'merchantCode' => config(key: 'jenga.merchant'), // The merchant code provided at registration.
    'wallet' => config(key: 'jenga.wallet'), // The wallet to be used for the transaction
    'orderAmount' => '', // The value of the transaction
    'orderReference' => '', // The merchant order reference. Min8 characters and It has to be alphanumeric
    'productType' => '', // Product category
    'productDescription' => '' // A brief summary of the product. Max 200 characters. Alphanumeric only., 
    'customerFirstName' => '', // The customer's First Name
    'customerLastName' => '', // The customer's Last Name
    'customerEmail' => '', // Customer email
    'customerPhone' => '', // Customer phone number e.g 700325008
    'countryCode' => config(key: 'jenga.country'), // Country code
    'customerPostalCodeZip' => '', // Customer’s postal code
    'customerAddress' => '', // Customer’s address
    'callbackUrl' => '' // Merchant callback url
    'extraData' => '', // This data will be echoed back during callback url
]);

```

Configure your frontend form.

```injectablephp
<form id="submitcheckout" action="{{ $checkOutUrl }}" method="POST">
    @csrf
    
    <input type="hidden" id="token" name="token" value="{{ $token }}">
    <input type="hidden" id="merchantCode" name="merchantCode" value="{{ $merchantCode }}">
    <input type="hidden" id="wallet" name="wallet" value="{{ $wallet }}">
    <input type="hidden" id="orderAmount" name="orderAmount" autofocus value="{{ $orderAmount }}">
    <input type="hidden" id="orderReference" name="orderReference" value="{{ $orderReference }}">
    <input type="hidden" id="productType" name="productType" value="{{ $productType }}">
    <input type="hidden" id="productDescription" name="productDescription" value="{{ $productDescription }}">
    <input type="hidden" id="customerFirstName" name="customerFirstName" value="{{ $customerFirstName }}">
    <input type="hidden" id="customerLastName" name="customerLastName" value="{{ $customerLastName }}">
    <input type="hidden" id="customerEmail" name="customerEmail" value="{{ $customerEmail }}">
    <input type="hidden" id="customerPhone" name="customerPhone" value="{{ $customerPhone }}">
    <input type="hidden" id="countryCode" name="countryCode" value="{{ $countryCode }}">
    <input type="hidden" id="customerPostalCodeZip" name="customerPostalCodeZip" value="{{ $customerPostalCodeZip }}">
    <input type="hidden" id="customerAddress" name="customerAddress" value="{{ $customerAddress }}">
    <input type="hidden" id="callbackUrl" name="callbackUrl" value="{{ $callbackUrl }}">
    <input type="hidden" id="extraData" name="extraData" value="{{ $extraData }}">

    <button type="submit">Subscribe</button>
</form>
```

A successful response should look like like this.

```json
{
    "responseStatus": "true",
    "transactionStatus": "SUCCESS",
    "orderReference": "226151",
    "extraData": "pmQgkBuepzSaiNdRh1rghq2ldPzdq0gQ",
    "transactionReference": "RBF2PJILMC",
    "transactionDate": "Wed Feb 15 2023",
    "transactionAmount": "1",
    "transactionCurrency": "KES",
    "message": "Transaction completed successfully",
    "paymentChannel": "MOBILE",
    "orderItems": "undefined",
    "secureResponse": "320396408033f540f6c9bcc426d6e3d1206d584984d72da4017cace6337e4e10d1729ed98ee326d5d0c403c298c789a9YhubIYK7B+WE0Bij2XWxn3iOL+MAyfWU3RruohGTfdB9t5j9lmNTqcmIeY8RL5M\/xenV+hIKvdweVIyzqX333PFgFGd4wV3+LwQpx9LGCxDsj0NFC+ouRdFZ0VADWbnCbZbHlBSO8kxIP8urAXuP1JM21DhTPqzbs8TB763IYmqVHCicmalkDdegDwo+BDQ0HJaf0ia3FektL2v\/Hj3nM9RkmNyA59VH0p5gUhRUhioMxNdFjai9TKZ3CwOZ6O75h5sc7L+Z8w3ucpvYOtuaTV5fxKIfSPkfi3mIvuGQEw7QDJeu3333BRDHt3XobtxZv9GW9\/eey1dRnNW9zplMBxQupJAn98fSKSC0VkSByqt5KKibQFAZxCOYjcvIJ0kea8MkBRwA\/z1YRdeQ+TmQmdLFoe3V3jWyE5SsN6EPU4k="
}
```

A customer should also receive an sms like this.

```text
Your transaction of Kshs.  1.00  has successfully been 
credited to Finserve Africa Limited-E Commerce Collection 
Account with Ref. Number  INVDRT and MPESA Tran Ref 
RBF2PJILMC. Thank you
```

### 3.3 Account services
- [ ] Account Balance
- [ ] Account MINI Statement
- [ ] Account Full Statement
- [ ] Opening and Closing Account Balance
- [ ] Account Inquiry - Bank Accounts

### 3.4 Send money
- [ ] Within Equity Bank
- [ ] To Mobile Wallets
- [ ] Real Time Gross Settlement (RTGS)
- [ ] Society for Worldwide Interbank Financial Telecommunication (SWIFT)
- [ ] Pesalink - To Bank Account
- [ ] Pesalink - To Mobile Number

### 3.5 Send money - IMT
- [ ] IMT Within Equity Bank
- [ ] IMT to Mobile Wallets
- [ ] IMT Pesalink - To Bank Account
- [ ] IMT Pesalink - To Bank Mobile

### 3.6 Receive money
- [ ] Receive Payments - Bill Payments
- [ ] Receive Payments - Merchant Payments
- [ ] Bill Validation

### 3.6 Receive money queries
- [ ] Get All EazzyPay Merchants
- [ ] Query Transaction Details
- [ ] Get All Billers

### 3.8 Airtime
- [ ] Purchase Airtime

### 3.9 Forex rates

<details>

<summary>Get the Equity Bank daily currency conversion rate for major currencies.</summary>

```php
use NjoguAmos\Jenga\Api\ForexExchangeRates;
use NjoguAmos\Jenga\Dto\ExchangeRatesDto;

// Convert 1042 USD into KES using Equity Bank Kenya rate.
$data = new ExchangeRatesDto(
    amount: 1042,
    currencyCode: "USD",
    toCurrency: "KES",
    accountNumber: '1450160649886',
    countryCode: 'KE'
);

$rates = (new ForexExchangeRates())->convert($data);
```

Example success response
```json
{
    "status": true,
    "code": 0,
    "message": "success",
    "data": {
      "convertedAmount": 127749.2,
      "rate": 122.6,
      "fromAmount": 1042,
      "rateCode": "TTB"
    }
  }
```

Refer to [Forex API Reference](https://developer.jengaapi.io/reference/get-forex-rates)

Supported currencies

| Code | Name                   |
|------|------------------------|
| KES  | Kenyan Shilling        | 
| YNG  | Korean Yang            | 
| SSP  | South Sudanese Pound   |
| RWF  | Rwandan Franc          |
| JPY  | Japanese Yen           |
| USD  | US Dollar              |
| GBP  | British Pound Sterling |
| EURO | European Union (EU)    |
| ZAR  | South African Rand     |
| RUP  | Russian Ruble          |

</details>

### 3.10 ID Search & Verification


<details>

<summary>Query the various registrar of persons in the various countries in East Africa.</summary>

```php
use NjoguAmos\Jenga\Api\IDVerification;
use NjoguAmos\Jenga\Dto\IDVerificationDto;

$data = new IDVerificationDto(
    documentNumber: '555555',
    firstName: 'John',
    lastName: 'Doe',
    dateOfBirth: '20 June 1985',
    documentType: 'ID',
    countryCode: 'KE',
);

$search = (new IDVerification())->search($data);
```

Example success response
```json
{
    "status": true,
    "code": 0,
    "message": "success",
    "data": {
        "identity": {
            "customer": {
                "firstName": "JOHN",
                "lastName": "DOE",
                "occupation": "",
                "gender": "M",
                "nationality": "Kenyan",
                "deathDate": "",
                "fullName": "JOHN JOHN DOE DOE",
                "middlename": "JOHN DOE",
                "ShortName": "JOHN",
                "birthCityName": "",
                "birthDate": "1985-06-20T12:00:00",
                "faceImage": ""
            },
            "documentType": "NATIONAL ID",
            "documentNumber": "555555",
            "documentSerialNumber": "55555555555",
            "documentIssueDate": "2011-12-08T12:00:00",
            "documentExpirationDate": "",
            "IssuedBy": "REPUBLIC OF KENYA",
            "additionalIdentityDetails": [
                {
                    "documentType": "",
                    "documentNumber": "",
                    "issuedBy": ""
                }
            ],
            "address": {
                "locationName": "",
                "districtName": "",
                "subLocationName": "",
                "provinceName": "",
                "villageName": ""
            }
        }
    }
}

```

Refer to [ID Search & Verification API Reference](https://developer.jengaapi.io/reference/identity-verification)


</details>


### 3.11 MPGS direct integration
- [ ] MPGS Validate Payment
- [ ] MPGS Authenticate Payment
- [ ] MPGS Authorize Payment
- [ ] MPGS Query Payment
- [ ] MPGS Refund Payment


## 4. Testing

``` bash
composer test
```

## 5. Changelog

Please see [RELEASES](https://github.com/njoguamos/laravel-jenga/releases) for more information what has changed recently.

## 6. Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## 7. Security

If you discover any security related issues, please email njoguamos@gmail.com instead of using the issue tracker.

## 8. Credits

- [Njogu Amos](https://github.com/njoguamos)
- [All Contributors](../../contributors)

## 9. License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
