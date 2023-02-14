<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use NjoguAmos\Jenga\Api\ForexExchangeRates;
use NjoguAmos\Jenga\Dto\ExchangeRatesDto;
use NjoguAmos\Jenga\Models\JengaToken;

test(description: 'it can get forex rates successfully', closure: function () {
    $token = JengaToken::factory()->create();

    $url = config(key: 'jenga.host') . '/v3-apis//transaction-api/v3.0/foreignExchangeRates';

    $response = [
        "status"  => true,
        "code"    => 0,
        "message" => "success",
        "data"    => [
            "convertedAmount" => 127749.2,
            "rate"            => 122.6,
            "fromAmount"      => 1042,
            "rateCode"        => "TTB"
        ]
    ];

    Http::fake([
        $url => Http::response($response, 200),
    ]);

    Http::preventStrayRequests();

    $data = new ExchangeRatesDto(
        amount: 1042,
        currencyCode: "USD",
        toCurrency: "KES",
    );

    $rates = (new ForexExchangeRates())->convert($data);

    expect($rates)->toBe(json_encode($response));

    Http::assertSent(function (Request $request) use ($url, $token) {
        return $request->hasHeader('Authorization', "Bearer $token->access_token") &&
            $request->url() == $url &&
            $request['amount'] == 1042 &&
            $request['currencyCode'] == "USD" &&
            $request['toCurrency'] == "KES" &&
            $request['accountNumber'] == "1450160649886" &&
            $request['countryCode'] == "KE";
    });
});
