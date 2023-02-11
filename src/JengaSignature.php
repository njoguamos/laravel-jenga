<?php

namespace NjoguAmos\Jenga;

use phpseclib3\Crypt\RSA;

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
        $key = RSA::loadPrivateKey(
            key: (string) file_get_contents(filename: $this->privateKey)
        );

        $dataString = collect(value: $this->data)
            ->flatten()
            ->join(glue: '');


        return $key->sign(message: $dataString);
    }

    public function getBase64Signature(): string
    {
        return base64_encode(string: $this->getSignature());
    }
}
