<?php

namespace NjoguAmos\JengaAPI\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use NjoguAmos\JengaAPI\Models\JengaAPI;

/** @extends Factory<JengaAPI> */
class JengaAPIFactory extends Factory
{
    protected $model = JengaAPI::class;

    public function definition()
    {
        return [
            'refresh_token' => Str::random(1000),
            'access_token'  => Str::random(40),
            'expires_in'    => now()->addMinutes(50),
            'issued_at'     => now(),
        ];
    }
}
