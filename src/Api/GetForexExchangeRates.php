<?php

namespace NjoguAmos\Jenga\Api;

use Illuminate\Support\Facades\Http;
use NjoguAmos\Jenga\Dto\ExchangeRatesDto;

class GetForexExchangeRates extends DefaultJengaConnector
{
    public function getEndPoint(): string
    {
        return $this->getBaseUrl().'/v3-apis//transaction-api/v3.0/foreignExchangeRates';
    }

    public function convert(ExchangeRatesDto $data): string
    {
        return Http::asJson()
            ->withToken(token: $this->getToken())
            ->post(url: $this->getEndPoint(), data: [
                "amount"        => $data->amount,
                "currencyCode"  => $data->currencyCode,
                "toCurrency"    => $data->toCurrency,
                "countryCode"   => $data->countryCode ?: config(key: 'jenga.country'),
                'accountNumber' => $data->accountNumber ?: config(key: 'jenga.account')
            ])->body();
    }
}
