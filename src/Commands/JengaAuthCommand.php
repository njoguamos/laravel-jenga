<?php

namespace NjoguAmos\Jenga\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use NjoguAmos\Jenga\Models\JengaToken;

class JengaAuthCommand extends Command
{
    public $signature = 'jenga:auth';

    public $description = 'Generate jenga api Bearer token and save to database';

    public function handle(): int
    {
        $url = config(key: 'jenga.host') . "/authentication/api/v3/authenticate/merchant";
        $apiKey = config(key: 'jenga.key');
        $merchantCode = config(key: 'jenga.merchant');
        $consumerSecret = config(key: 'jenga.secret');

        $response = Http::acceptJson()
            ->withHeaders(headers: ['Api-Key' => $apiKey])
            ->retry(times: 3, sleepMilliseconds: 100)
            ->post(url: $url, data: [
                'merchantCode'   => $merchantCode,
                'consumerSecret' => $consumerSecret
            ]);

        if (! $response->successful()) {
            // @TODO: Refactor error
            $this->error(string: trans(key: 'jenga::jenga.token.error'));

            return self::FAILURE;
        }

        $data = $response->json();
        JengaToken::query()
            ->create(attributes: [
                'access_token'  => $data['accessToken'],
                'refresh_token' => $data['refreshToken'],
                'expires_in'    => now()->addMinutes(value: 15),
                'issued_at'     => now(),
                'token_type'    => $data['tokenType'],
            ]);

        $this->info(string: trans(key: 'jenga::jenga.token.saved'));

        return self::SUCCESS;
    }
}
