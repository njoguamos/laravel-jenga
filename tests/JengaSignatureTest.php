<?php

use NjoguAmos\Jenga\JengaSignature;
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
