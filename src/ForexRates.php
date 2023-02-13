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
        string $accountNumber,
        string $countryCode,
    ): mixed {
        return Http::asJson()
            ->withToken(token: $this->token)
            ->post(url: $this->endPoint, data: [
                "countryCode"   => $countryCode,
                "currencyCode"  => $currencyCode,
                "toCurrency"    => $toCurrency,
                "amount"        => $amount,
                'accountNumber' => $accountNumber
            ])->body();
    }
}
