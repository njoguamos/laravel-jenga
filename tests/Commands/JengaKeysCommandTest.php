<?php

use phpseclib3\Crypt\Common\PrivateKey;
use phpseclib3\Crypt\Common\PublicKey;

beforeEach(function () {
    config()->set(key: 'jenga.keys_path', value: './tests/stubs');

    $this->privateKeyPath = config(key: 'jenga.keys_path').'/jenga.key';
    $this->publiKeyPath = config(key: 'jenga.keys_path').'/jenga.pub.key';

    if (file_exists($this->privateKeyPath)) {
        unlink($this->privateKeyPath);
    }

    if (file_exists($this->publiKeyPath)) {
        unlink($this->publiKeyPath);
    }
});

test(description: 'it generates and create private and public keys when they do not exists', closure: function () {
    expect(file_exists($this->privateKeyPath))->toBeFalse()
        ->and(file_exists($this->publiKeyPath))->toBeFalse();

    $this->artisan(command: 'jenga:keys')
        ->assertSuccessful()
        ->expectsOutput(output: trans(key: 'jenga::jenga.keys.generated'));

    expect(file_exists($this->privateKeyPath))->toBeTrue()
    ->and(file_exists($this->publiKeyPath))->toBeTrue();
});

test(description: 'it generates valid private key', closure: function () {
    $this->artisan(command: 'jenga:keys')
        ->assertSuccessful()
        ->expectsOutput(output: trans(key: 'jenga::jenga.keys.generated'));

    $privateKey = \phpseclib3\Crypt\RSA\PrivateKey::load(file_get_contents($this->privateKeyPath));

    expect(value: $privateKey instanceof PrivateKey)->toBeTrue()
        ->and(file_get_contents($this->privateKeyPath))->tobe($privateKey->toString('PKCS8'));
});


test(description: 'it generates valid public key', closure: function () {
    $this->artisan(command: 'jenga:keys')
        ->assertSuccessful()
        ->expectsOutput(output: trans(key: 'jenga::jenga.keys.generated'));

    $publicKey = \phpseclib3\Crypt\RSA\PublicKey::load(file_get_contents($this->publiKeyPath));

    expect(value: $publicKey instanceof PublicKey)->toBeTrue()
        ->and(file_get_contents($this->publiKeyPath))->tobe($publicKey->toString('PKCS8'));
});
