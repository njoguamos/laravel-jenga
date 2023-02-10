<?php

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

test(description: 'it generate and replace private and public keys if they do not exists', closure: function () {
    expect(file_exists($this->privateKeyPath))->toBefalse()
        ->and(file_exists($this->publiKeyPath))->toBefalse();

    $this->artisan(command: 'jenga:keys')
        ->assertSuccessful()
        ->expectsOutput(output: trans(key: 'jenga::jenga.keys.generated'));

    expect(file_exists($this->privateKeyPath))->toBeTrue()
    ->and(file_exists($this->publiKeyPath))->toBeTrue();
});
