<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use NjoguAmos\Jenga\Models\JengaToken;

use function Spatie\PestPluginTestTime\testTime;

test(description: 'it can get and save authorization tokens to database on success response', closure: function () {
    testTime()->freeze();

    $response = [
        "accessToken"  => "eyJhbGciOiJSUzUxMiJ9.eyJ0b2tlblR5cGUiOiJNRVJDSEFOVCIsImVudiI6IlVBVCIsImV4cCI6MTYyNjE1OTc4MiwiaWF0IjoxNjI2MTU4ODgyLCJhY2NvdW50IjoiMzYxMzUyOTQ5MjNBQ0JBNTVGMTBEOUZDQkQ1NDczQjk3RkMxREY3RjhDQzZDNkM5MDkwQzU4NTExNUJEOTEzMEEzNkZBREQxRTE0MDRCQjJEN0JERTg0RjE3RENBODdCYkxzMGRFKzNGSG15Ty9CQ3preTRrTmRSNVVpckRvRks0UXNhU01EeDhicTFNcG01WklRWE5ob2Vza2tjOVBxNVZXTHdibWxTeUwxZnhnTGdIczE1QXpwam1DbHNsL0RKZTF2QzVsTTRaZ3UxYmo4ZVI0KzlFS2ZLeUd0ZHBrTkpJRVJrbHJCSGkyQ2xlOE9KTlhqcm9CUHd4Mjg3QzJFSDJXNExCb3NZMU5ZTUJQODYyMVRTVjZMcWJ0a0l4ZXNXclNKckpoOWZVSTFySERTWFNOdzNYMmZUV2JaWnJYYTVhQUNnUjhHZFR4TEk3TkxiM0hGc2o2enNFdVRuRmRhUS9VM1NVdjhzWUtWWkpralRuUUFzV3htTm4rKzVFZ2ZCUGp1VnZ3UVVRYTNwSU8vQzlJUjA2T0lWRDYxMmp2aTlhQlRyVDQ4aDZIbXlsTyt4RzJJWGlNcGdZVVpmL0lYczJmNlFnL1dPNTNFR0NHa0VFRHlzYy9CeCtXa2l4SUFjeHNTVTMvOFN5czN1UGthWCtzRXppbUgrY0kvdysxYWJUb28wYjA1dy9TVT0ifQ.Wf1ggbs5vS0wglvcajjtMziMNfxVZRg8kFcl9WvtsZfPHbpnpmkxWC_5bz9Sofegd3I82CQr1RAgnX68LpPCPJOXtZzrI5_8E8tOj-jR38phQqF8-4q7wpdDHOjxvp9-SQ_PWAfOt7z7Qu4kc1tOaSVXY_6XtCqvyMnkgF_yAGZ8BZaItMssqyeuOpZWkTstj474Ni2uTC9elyo6pw3TdYCV39u7JZ4NIrt8RS3lk8w6gUEsEmhi10BgmgdPwQWiPKBijyjIs2p9clY7RHxTHhCJ-0-mSAYNPo039n1DmgtXiYL6IN9sa6V6lYHMCJ7hUcQLnn839kdKbvvv7PcRCA",
        "refreshToken" => "ctmB6GJq9Tqbf+Z5neWs/7WGA3S6nHs+VToc0J9eXdLTSVD63BrhDRSCIXunmdIZzjfnM4YiRr88HZdq90dLXw==",
        "expiresIn"    => "2021-07-13T07:03:02Z",
        "issuedAt"     => "2021-07-13T06:48:02Z",
        "tokenType"    => "Bearer"
    ];

    $url = config(key: 'jenga.host') . "/authentication/api/v3/authenticate/merchant";

    Http::preventStrayRequests();

    Http::fake(callback: [$url => Http::response($response)]);

    $this->artisan(command: 'jenga:auth')
        ->assertSuccessful()
        ->expectsOutput(output: trans(key: 'jenga::jenga.token.saved'));

    Http::assertSent(function (Request $request) use ($url) {
        return $request->url() == $url &&
            $request->hasHeader(key: 'Api-Key', value: config(key: 'jenga.key')) &&
            $request['merchantCode'] == config(key: 'jenga.merchant') &&
            $request['consumerSecret'] == config(key: 'jenga.secret');
    });

    $jenga = JengaToken::query()->latest()->first();

    expect(value: $jenga->token_type)->toBe(expected: $response['tokenType'])
        ->and(value: $jenga->access_token)->toBe(expected: $response['accessToken'])
        ->and(value: $jenga->refresh_token)->toBe(expected: $response['refreshToken'])
        ->and(value:now()->toIso8601String())->toBe($jenga->issued_at->toIso8601String())
        ->and(value:now()->addMinutes(value: 15)->toIso8601String())->toBe($jenga->expires_in->toIso8601String());
});
