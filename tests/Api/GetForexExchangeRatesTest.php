<?php

use NjoguAmos\Jenga\Api\GetForexExchangeRates;
use NjoguAmos\Jenga\Models\JengaToken;
use Sammyjo20\Saloon\Clients\MockClient;
use Sammyjo20\Saloon\Http\MockResponse;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Http\SaloonResponse;

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

    $mockClient = new MockClient([
        $url => MockResponse::make($response, ),
    ]);

    $rates = (new GetForexExchangeRates(
        amount: 1042,
        currencyCode: "USD",
        toCurrency: "KES"
    ))
        ->send($mockClient);

    expect($rates->body())->toBe(json_encode($response));

    $mockClient->assertSent(value: GetForexExchangeRates::class);

    $mockClient->assertSent(value: $url);

    $mockClient->assertSent(function (SaloonRequest $request, SaloonResponse $response) {
        return $request->amount === 1042
            && $request->currencyCode === "USD"
            && $request->toCurrency === "KES"
            && $request->accountNumber === "1450160649886"
            && $request->countryCode === "KE";
    });
});
