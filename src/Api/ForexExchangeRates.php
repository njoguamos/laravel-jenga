<?php

namespace NjoguAmos\Jenga\Api;

use Illuminate\Support\Facades\Http;
use NjoguAmos\Jenga\Concerns\JengaConnector;
use NjoguAmos\Jenga\Dto\ExchangeRatesDto;

class ForexExchangeRates extends DefaultJengaConnector implements JengaConnector
{
    public function getEndPoint(): string
    {
        return $this->getBaseUrl().'/v3-apis/transaction-api/v3.0/foreignExchangeRates';
    }

    public function convert(ExchangeRatesDto $data): string
    {
        $postData = [
            "amount"        => $data->amount,
            "currencyCode"  => $data->currencyCode,
            "toCurrency"    => $data->toCurrency,
            "countryCode"   => $data->countryCode ?: config(key: 'jenga.country'),
            'accountNumber' => $data->accountNumber ?: config(key: 'jenga.account')
        ];

        return Http::asJson()
            ->withToken(token: $this->getToken())
            ->post(url: $this->getEndPoint(), data: $postData)->body();
    }
}
