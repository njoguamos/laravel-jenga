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
        $url = config('jenga.host') . "/authentication/api/v3/authenticate/merchant";
        $apiKey = config('jenga.key');
        $merchantCode = config('jenga.merchant');
        $consumerSecret = config('jenga.secret');

        $response = Http::acceptJson()
            ->withHeaders(['Api-Key' => $apiKey])
            ->post($url, [
                'merchantCode'   => $merchantCode,
                'consumerSecret' => $consumerSecret
            ]);

        if (! $response->successful()) {
            $this->error('There was an error getting jenga credentials.');

            return self::FAILURE;
        }

        $data = $response->json();
        JengaToken::query()
            ->create([
                'access_token'  => $data['accessToken'],
                'refresh_token' => $data['refreshToken'],
                'expires_in'    => Carbon::parse($data['expiresIn']),
                'issued_at'     => Carbon::parse($data['issuedAt']),
                'token_type'    => $data['tokenType'],
            ]);

        $this->info(trans('jenga::jenga.token.saved'));

        return self::SUCCESS;
    }
}
