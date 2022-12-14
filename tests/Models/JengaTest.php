<?php

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use NjoguAmos\Jenga\Models\Jenga;

test('it encrypts access_token and refresh_token columns', function (string $column, string $value) {
    $api = Jenga::factory()
        ->create([$column => $value]);

    $apis = DB::table('jenga')->first();

    expect($api->$column)->toBe($value);
    expect(Crypt::decryptString($apis->$column))->toBe($api->$column);
})->with([
    ['access_token', 'eyJhbGciOiJSUzUxMiJ9.eyJ0b2tlblR5cGUiOiJNRVJDSEFOVCIsImVud'],
    ['access_token', 'ctmB6GJq9Tqbf+Z5neWs/7WGA3S6nHs+VToc0J9eXdLTSVD63BrhDRSCIXunmdIZzjfnM4YiRr88HZdq90dLXw=='],
]);
