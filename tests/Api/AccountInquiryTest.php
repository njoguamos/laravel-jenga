<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use NjoguAmos\Jenga\Api\AccountInquiry;
use NjoguAmos\Jenga\JengaSignature;
use NjoguAmos\Jenga\Models\JengaToken;

test(description: 'it can search account details successfully', closure: function () {
    $token = JengaToken::factory()->create();

    $url = config(key: 'jenga.host') . '/v3-apis/account-api/v3.0/accounts/search/KE/1450160649886';

    $response = [
        "status"  => true,
        "code"    => 0,
        "message" => "success",
        "data"    => [
            "account" => [
                "branchCode" => "145",
                "number"     => "1450160649886",
                "currency"   => "KES",
                "status"     => "Active"
            ],
            "customer" => [
                [
                    "name" => "CATHERINE MURANDITSI MUKABWA",
                    "id"   => "54307789658",
                    "type" => "Retail"
                ]
            ]
        ]
    ];

    $data = [
        "countryCode"   => 'KE',
        "accountNumber" => '1450160649886',
    ];

    $this->artisan(command: 'jenga:keys');

    $signature = (new JengaSignature(data: $data))->getSignature();

    Http::fake([
        $url => Http::response($response, 200),
    ]);

    Http::preventStrayRequests();

    $search = (new AccountInquiry())
        ->search(
            countryCode: $data['countryCode'],
            accountNumber: $data['accountNumber']
        );

    expect($search)->toBe(json_encode($response));

    Http::assertSent(function (Request $request) use ($url, $token, $signature) {
        return
            $request->hasHeader(key: 'Authorization', value: "Bearer $token->access_token")
                 && $request->hasHeader(key: 'Signature', value: $signature);
    });
});
