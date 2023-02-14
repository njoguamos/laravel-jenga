<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use NjoguAmos\Jenga\Api\IDVerification;
use NjoguAmos\Jenga\Dto\IDVerificationDto;
use NjoguAmos\Jenga\JengaSignature;
use NjoguAmos\Jenga\Models\JengaToken;

test(description: 'it can search ID details successfully', closure: function () {
    $token = JengaToken::factory()->create();

    $url = config(key: 'jenga.host') . '/v3-apis//v3.0/validate/identity';

    $response = [
        "status"  => true,
        "code"    => 0,
        "message" => "success",
        "data"    => [
            "identity" => [
                "customer" => [
                    "firstName"     => "JOHN",
                    "lastName"      => "DOE",
                    "occupation"    => "",
                    "gender"        => "M",
                    "nationality"   => "Kenyan",
                    "deathDate"     => "",
                    "fullName"      => "JOHN JOHN DOE DOE",
                    "middlename"    => "JOHN DOE",
                    "ShortName"     => "JOHN",
                    "birthCityName" => "",
                    "birthDate"     => "1985-06-20T12:00:00",
                    "faceImage"     => ""
                ],
                "documentType"              => "NATIONAL ID",
                "documentNumber"            => "555555",
                "documentSerialNumber"      => "55555555555",
                "documentIssueDate"         => "2011-12-08T12:00:00",
                "documentExpirationDate"    => "",
                "IssuedBy"                  => "REPUBLIC OF KENYA",
                "additionalIdentityDetails" => [
                    [
                        "documentType"   => "",
                        "documentNumber" => "",
                        "issuedBy"       => ""
                    ]
                ],
                "address" => [
                    "locationName"    => "",
                    "districtName"    => "",
                    "subLocationName" => "",
                    "provinceName"    => "",
                    "villageName"     => ""
                ]
            ]
        ]
    ];

    $signatureData = [
        "countryCode"    => 'KE',
        "documentNumber" => '555555',
    ];

    $this->artisan(command: 'jenga:keys');

    $signature = (new JengaSignature(data: $signatureData))->getSignature();

    Http::fake([
        $url => Http::response($response, 200),
    ]);

    Http::preventStrayRequests();

    $data = new IDVerificationDto(
        documentNumber: '555555',
        firstName: 'John',
        lastName: 'Doe',
        dateOfBirth: '20 June 1985',
    );


    $search = (new IDVerification())->search($data);

    expect($search)->toBe(json_encode($response));

    Http::assertSent(function (Request $request) use ($url, $token, $signature) {
        return
            $request->hasHeader('Authorization', "Bearer $token->access_token")
                 && $request->hasHeader('signature', $signature)
                && $request['documentNumber'] == '555555'
                && $request['firstName'] == 'John'
                && $request['lastName'] == 'Doe'
                && $request['dateOfBirth'] == '1985-06-20'
                && $request['documentType'] == 'ID'
                && $request['countryCode'] == 'KE';
    });
});
