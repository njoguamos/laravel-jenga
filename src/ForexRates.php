<?php

namespace NjoguAmos\Jenga;

use Illuminate\Support\Facades\Http;
use NjoguAmos\Jenga\Models\JengaToken;

class ForexRates
{
    /** @var string */
    protected mixed $token;

    /** @var string */
    protected string $endPoint;

    public function __construct()
    {
        $this->token = JengaToken::query()->latest()->first()?->access_token ?: '';

        $this->endPoint = config(key: 'jenga.host').'/v3-apis//transaction-api/v3.0/foreignExchangeRates';
    }

    public function convert(
        int $amount,
        string $currencyCode,
        string $toCurrency,
        ?string $accountNumber  = null,
        ?string $countryCode = null,
    ): mixed {
        return Http::asJson()
            ->withToken(token: $this->token)
            ->post(url: $this->endPoint, data: [
                "amount"        => $amount,
                "currencyCode"  => $currencyCode,
                "toCurrency"    => $toCurrency,
                "countryCode"   => $countryCode ?: config(key: 'jenga.country'),
                'accountNumber' => $accountNumber  ?: config(key: 'jenga.account')
            ])->body();
    }
}
