<?php

namespace NjoguAmos\Jenga\Api;

use NjoguAmos\Jenga\JengaSignature;
use NjoguAmos\Jenga\Models\JengaToken;

abstract class DefaultJengaConnector
{
    /** @var string */
    private mixed $token;

    /** @var string */
    protected string $baseUrl;

    public function __construct()
    {
        $this->setToken(token: JengaToken::query()->latest()->first()?->access_token ?: '');

        $this->setBaseUrl(url: config(key: 'jenga.host'));
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function setBaseUrl(string $url): void
    {
        $this->baseUrl = $url;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getSignatureHeader(array $data): array
    {
        return [
            'Signature' => (new JengaSignature(data: $data))->getSignature()
        ];
    }
}
