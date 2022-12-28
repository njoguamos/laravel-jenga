<?php

namespace NjoguAmos\Jenga\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use NjoguAmos\Jenga\Models\JengaToken;

/** @extends Factory<JengaToken> */
class JengaTokenFactory extends Factory
{
    protected $model = JengaToken::class;

    public function definition(): array
    {
        return [
            'refresh_token' => Str::random(1000),
            'access_token'  => Str::random(40),
            'expires_in'    => now()->addMinutes(50),
            'issued_at'     => now(),
        ];
    }
}
