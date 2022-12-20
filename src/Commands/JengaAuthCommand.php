<?php

namespace NjoguAmos\Jenga\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class JengaAuthCommand extends Command
{
    public $signature = 'jenga:auth';

    public $description = 'Generate jenga api Bearer token and save to database';

    public function handle(): int
    {
        $baseUrl = config('jenga.host');
        $endpoint = '/authentication/api/v3/authenticate/merchant';
        $url = "$baseUrl.$endpoint";

        $apiKey = config('jenga.key');
        $merchantCode = config('jenga.merchant');
        $consumerSecret = config('jenga.secret');

            $response = Http::withHeaders([
                'Api-Key' => $apiKey,
            ])->post($url, [
                'merchantCode'   => $merchantCode,
                'consumerSecret' => $consumerSecret
            ]);

            if (! $response->successful()) {
                $this->error('There was an error getting jenga credentials: '.$response->json()['message']);
                return self::FAILURE;
            }

            /// Save to database

            $this->info(trans('jenga::jenga.token.saved'));

        return self::SUCCESS;
    }
}
