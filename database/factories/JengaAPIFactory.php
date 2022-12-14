<?php

namespace NjoguAmos\JengaAPI\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<JengaAPI> */
class JengaAPIFactory extends Factory
{
    public function definition()
    {
        return [
            'refresh_token' => Str::random(1000),
            'access_token'  => Str::random(40),
            'expires_in'    => now()->addMinutes(50),
        ];
    }
}
