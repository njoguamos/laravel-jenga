> **Warning**
> This package is still in development and is not production ready. Use for testing and development.


![Cover](art/cover.png)

# Jenga API wrapper for Laravel
[![run-tests](https://github.com/njoguamos/laravel-jenga/actions/workflows/run-test.yml/badge.svg)](https://github.com/njoguamos/laravel-jenga/actions/workflows/run-test.yml)
[![License](https://img.shields.io/github/license/njoguamos/laravel-jenga.svg)](https://github.com/njoguamos/laravel-jenga)
[![Latest Stable Version](https://img.shields.io/packagist/v/njoguamos/laravel-jenga.svg)](https://packagist.org/packages/njoguamos/laravel-jenga)
![Issues](https://img.shields.io/github/issues/njoguamos/laravel-jenga)

## Why use this package
1. To provide a way of generating jenga api `access_token` after a give period e.g every 30 minutes
2. To provide a fluent way of generating jenga api key pair of `private key` and `public key`
3. To automate generation of jenga api `Bearer Token`
4. Offer a seamless gateway to interacting with Jenga API

## Documentation

### Installation

Use the Composer package manager to install this package into your Laravel project

```bash
composer require njoguamos/laravel-jenga
```

### Update your `.env` variables

This package assumes that you have a  JengaHQ account, and that you have `Api Key`, `Merchant Code` and `Consumer Secret` (from Jenga)(https://developer.jengaapi.io/docs/developer-quickstart).

Copy the respective keys and place them in the `.env` as show in the example below.

```dotenv
JENGA_LIVE_MODE=false
JENGA_API_KEY=
JENGA_CONSUMER_SECRET=
JENGA_MERCHANT_CODE=
```

> **Note**
> For `JENGA_LIVE_MODE` use `false` when testing and `true` when running live transactions

### Initialising the Package

You must run install command that will publish the `jenga.php` config file and `create_jenga_tokens` migration

```bash
php artisan jenga:install
```

> **Note**
> For security reasons, `access_token` and `refresh_token` will be encrypted using you `application key`. You can learn more about encryption from [Laravel documentation](https://laravel.com/docs/9.x/encryption)

### Generating `Bearer Token`

Once you have valid credentials, run the following command.

```bash
php artisan jenga:auth
```

This command will get an `access_token` token from Jenga API and add them into a new record on `jenga` table.

This command may fail:
- When you are not connected to the internet
- When `Api Key` or `Consumer Secret` or `Merchant` is/are invalid
- There is a problem with jenga api endpoint

### Generate `Bearer Token` Frequently
The generated `access_token` expires after a particular period usually after `one hour`. To generate a new `access_token` automatically, schedule the `jenga:auth` command in the console kernel. The schedule time should be less than one hour.

```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    # ...
    $schedule->command(command: 'jenga:auth')->everyThirtyMinutes();
}
```

### Clearing Expired Token
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

### Generate Signature
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

You may use `--force` flag to replace existing keys. You can specify key size using `--length` flag e.g `1024, 2048, 4096`. The default size is `4096`

>**Warning**
> The generated keys files **SHOULD NEVER** be kept in source control. Make sure you add them to you gitignore file.

> **Note**
> Extensions like `bcmath`, `gmp`, `libsodium` and `openssl` are not required when generating they keys. However, they speed up the process if they are available.

## 2. Usage
### 2.1 Account services
- [ ] Account Balance
- [ ] Account MINI Statement
- [ ] Account Full Statement
- [ ] Opening and Closing Account Balance
- [ ] Account Inquiry - Bank Accounts

### 2.1 Send money
- [ ] Within Equity Bank
- [ ] To Mobile Wallets
- [ ] Real Time Gross Settlement (RTGS)
- [ ] Society for Worldwide Interbank Financial Telecommunication (SWIFT)
- [ ] Pesalink - To Bank Account
- [ ] Pesalink - To Mobile Number

### 2.1 Send money - IMT
- [ ] IMT Within Equity Bank
- [ ] IMT to Mobile Wallets
- [ ] IMT Pesalink - To Bank Account
- [ ] IMT Pesalink - To Bank Mobile

### 2.1 Receive money
- [ ] Receive Payments - Bill Payments
- [ ] Receive Payments - Merchant Payments
- [ ] Bill Validation

### 2.1 Receive money queries
- [ ] Get All EazzyPay Merchants
- [ ] Query Transaction Details
- [ ] Get All Billers

### 2.1 Airtime
- [ ] Purchase Airtime

### 2.1 Forex rates
- [ ] Get Forex Rates

### 2.1 Know your customer
- [ ] ID Search & Verification

### 2.1 MPGS direct integration
- [ ] MPGS Validate Payment
- [ ] MPGS Authenticate Payment
- [ ] MPGS Authorize Payment
- [ ] MPGS Query Payment
- [ ] MPGS Refund Payment


## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email njoguamos@gmail.com instead of using the issue tracker.

## Credits

- [Njogu Amos](https://github.com/njoguamos)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
