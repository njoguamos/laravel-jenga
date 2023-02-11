<?php

namespace NjoguAmos\Jenga;

use Spatie\Crypto\Rsa\PrivateKey;

class JengaSignature
{
    protected string $privateKey;

    public function __construct(
        public array $data
    ) {
        $this->privateKey = config(key: 'jenga.keys_path').'/jenga.key';
    }

    public function getSignature(): string
    {
        $dataString = collect(value: $this->data)
            ->flatten()
            ->join(glue: '');

        return PrivateKey::fromFile($this->privateKey)->sign($dataString);
    }
}
