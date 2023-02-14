<?php

namespace NjoguAmos\Jenga\Api;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use NjoguAmos\Jenga\Concerns\JengaConnector;
use NjoguAmos\Jenga\Dto\IDVerificationDto;

class IDVerification extends DefaultJengaConnector implements JengaConnector
{
    public function getEndPoint(): string
    {
        return $this->getBaseUrl() . '/v3-apis//v3.0/validate/identity';
    }

    public function search(IDVerificationDto $data): string
    {
        $signatureData = [
            "countryCode"    => $data->countryCode ?: config(key: 'jenga.country'),
            "documentNumber" => $data->documentNumber,
        ];

        $postData = [
            "documentNumber" => $data->documentNumber,
            "firstName"      => $data->firstName,
            "lastName"       => $data->lastName,
            "dateOfBirth"    => Carbon::parse($data->dateOfBirth)->format(format: 'Y-m-d'),
            "documentType"   => $data->documentType ?: config(key: 'jenga.country'),
            "countryCode"    => $data->countryCode ?: 'ID'
        ];

        return Http::asJson()
            ->withToken(token: $this->getToken())
            ->withHeaders($this->getSignatureHeader($signatureData))
            ->post(url: $this->getEndPoint(), data: $postData)
            ->body();
    }
}
