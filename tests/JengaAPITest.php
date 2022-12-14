<?php

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use NjoguAmos\JengaAPI\Models\JengaAPI;

test('it encrypts access_token and refresh_token columns', function (string $column, string $value) {
    $api = JengaAPI::factory()
        ->create([$column => $value]);

    $apis = DB::table('jenga_api')->first();

    expect($owner->$column)->toBe($value);
    expect(Crypt::decryptString($apis->$column))->toBe($api > $column);
})->with([
    ['access_token', 'eyJhbGciOiJSUzUxMiJ9'],
    ['access_token', 'ctmB6GJq9Tqbf+Z5neWs'],
]);
