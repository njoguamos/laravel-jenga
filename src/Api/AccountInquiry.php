<?php

namespace NjoguAmos\Jenga\Api;

use Illuminate\Support\Facades\Http;

class AccountInquiry extends DefaultJengaConnector
{
    public function search(?string $countryCode = null, ?string $accountNumber = null): string
    {
        $data = [
            "countryCode"   => $countryCode ?: config(key: 'jenga.country'),
            "accountNumber" => $accountNumber ?: config(key: 'jenga.account'),
        ];

        return Http::withToken(token: $this->getToken())
            ->withUrlParameters(parameters: [
                'endpoint'      => $this->getBaseUrl(),
                'countryCode'   => $data['countryCode'],
                'accountNumber' => $data['accountNumber'],
            ])->withHeaders(headers: $this->getSignatureHeader(data: $data))
            ->get(url: '{+endpoint}/v3-apis/account-api/v3.0/accounts/search/{countryCode}/{accountNumber}')
            ->body();
    }
}
