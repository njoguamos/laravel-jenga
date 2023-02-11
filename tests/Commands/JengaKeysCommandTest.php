<?php

use phpseclib3\Crypt\Common\PrivateKey;
use phpseclib3\Crypt\Common\PublicKey;
use phpseclib3\Crypt\RSA\PrivateKey as PrivateKeyLoader;
use phpseclib3\Crypt\RSA\PublicKey as PublicKeyLoader;

beforeEach(function () {
    $this->privateKey = config(key: 'jenga.keys_path').'/jenga.key';
    $this->publiKey = config(key: 'jenga.keys_path').'/jenga.pub.key';

    if (file_exists($this->privateKey)) {
        unlink($this->privateKey);
    }

    if (file_exists($this->publiKey)) {
        unlink($this->publiKey);
    }
});

test(description: 'it generates and create private and public keys when they do not exists', closure: function () {
    expect(file_exists($this->privateKey))->toBeFalse()
        ->and(file_exists($this->publiKey))->toBeFalse();

    $this->artisan(command: 'jenga:keys')
        ->assertSuccessful()
        ->expectsOutput(output: trans(key: 'jenga::jenga.keys.generated'));

    expect(file_exists($this->privateKey))->toBeTrue()
    ->and(file_exists($this->publiKey))->toBeTrue();
});

test(description: 'it generates valid private key', closure: function () {
    $this->artisan(command: 'jenga:keys')
        ->assertSuccessful()
        ->expectsOutput(output: trans(key: 'jenga::jenga.keys.generated'));

    $privateKey = PrivateKeyLoader::load(file_get_contents($this->privateKey));

    expect(value: $privateKey instanceof PrivateKey)->toBeTrue()
        ->and(file_get_contents($this->privateKey))->tobe($privateKey->toString('PKCS8'));
});

test(description: 'it generates valid public key', closure: function () {
    $this->artisan(command: 'jenga:keys')
        ->assertSuccessful()
        ->expectsOutput(output: trans(key: 'jenga::jenga.keys.generated'));

    $publicKey = PublicKeyLoader::load(file_get_contents($this->publiKey));

    expect(value: $publicKey instanceof PublicKey)->toBeTrue()
        ->and(file_get_contents($this->publiKey))->tobe($publicKey->toString('PKCS8'));
});
