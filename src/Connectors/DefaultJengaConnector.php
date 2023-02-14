<?php

namespace NjoguAmos\Jenga\Connectors;

use NjoguAmos\Jenga\Models\JengaToken;
use Sammyjo20\Saloon\Http\Auth\TokenAuthenticator;
use Sammyjo20\Saloon\Http\SaloonConnector;
use Sammyjo20\Saloon\Interfaces\AuthenticatorInterface;
use Sammyjo20\Saloon\Traits\Plugins\AcceptsJson;

class DefaultJengaConnector extends SaloonConnector
{
    use AcceptsJson;

    protected string $token;

    public function __construct()
    {
        $this->token = JengaToken::query()
            ->latest()
            ->first()?->access_token ?: '';
    }

    public function defineBaseUrl(): string
    {
        return config(key: 'jenga.host');
    }

    public function defaultAuth(): ?AuthenticatorInterface
    {
        return new TokenAuthenticator(token: $this->token);
    }

    public function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
        ];
    }
}
