<?php


use Spatie\Crypto\Rsa\PrivateKey;
use Spatie\Crypto\Rsa\PublicKey;

beforeEach(closure: function () {
    $this->privateKey = config(key: 'jenga.keys_path').'/jenga.key';
    $this->publiKey = config(key: 'jenga.keys_path').'/jenga.pub.key';

    if (file_exists(filename: $this->privateKey)) {
        unlink(filename: $this->privateKey);
    }

    if (file_exists(filename: $this->publiKey)) {
        unlink(filename: $this->publiKey);
    }
});

test(description: 'it generates and create private and public keys when they do not exists', closure: function () {
    expect(value: file_exists(filename: $this->privateKey))->toBeFalse()
        ->and(value: file_exists(filename: $this->publiKey))->toBeFalse();

    $this->artisan(command: 'jenga:keys')
        ->assertSuccessful()
        ->expectsOutput(output: trans(
            key: 'jenga::jenga.keys.generated',
            replace: ['dir' => config(key:'jenga.keys_path')]
        ));

    expect(value: file_exists(filename: $this->privateKey))->toBeTrue()
    ->and(value: file_exists(filename: $this->publiKey))->toBeTrue();
});

test(description: 'it generates valid private and public key', closure: function () {
    $this->artisan(command: 'jenga:keys');

    $signature = PrivateKey::fromFile(pathToPrivateKey: $this->privateKey)
        ->sign(data: 'my message');

    $publicKey = PublicKey::fromFile(pathToPublicKey: $this->publiKey);

    expect(value: $publicKey->verify(data: 'my message', signature: $signature))->toBeTrue()
        ->and(value: $publicKey->verify(data: 'my modified message', signature: $signature))->toBeFalse();
});
