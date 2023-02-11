<?php

use NjoguAmos\Jenga\JengaSignature;
use phpseclib3\Crypt\RSA;
use Spatie\Crypto\Rsa\PublicKey;

beforeEach(closure: function () {
    $this->artisan(command: 'jenga:keys');

    $this->publicKey = config(key: 'jenga.keys_path').'/jenga.pub.key';
});

test(description: 'it can generate a valid signature using a private key', closure: function () {
    $data = [
        "accountId"   => "0011547896523",
        "countryCode" => "KE",
        "date"        => "2022-01-01"
    ];

    $signature = (new JengaSignature(data: $data))->getSignature();

    $publicKey = PublicKey::fromFile(pathToPublicKey: $this->publicKey);

    expect(value: $publicKey->verify(data: '0011547896523KE2022-01-01', signature: $signature))->toBeTrue()
        ->and(value: $publicKey->verify(data: 'KE2022-01-010011547896523', signature: $signature))->toBeFalse();
});

test(description: 'it can generate and convert signature to base_64', closure: function () {
    $data = [
        "accountId"   => "0011547896523",
        "countryCode" => "KE",
        "date"        => "2022-01-01"
    ];

    $base64Signature = (new JengaSignature(data: $data))->getBase64Signature();

    expect(value: (bool) preg_match(
        pattern: '/^[a-zA-Z0-9\/\r\n+]*={0,2}$/',
        subject: $base64Signature
    ))->toBeTrue();
});
