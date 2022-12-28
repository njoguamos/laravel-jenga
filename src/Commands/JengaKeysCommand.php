<?php

namespace NjoguAmos\Jenga\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Env;
use phpseclib3\Crypt\RSA;

class JengaKeysCommand extends Command
{
    protected $signature = 'jenga:keys
                                      {--force : Overwrite keys they already exist}
                                      {--length=4096 : The length of the private key}';

    protected $description = 'Create the encryption keys for Jenga API signature.';

    public function handle(): int
    {
        [$privateKey, $publicKey] = [
            config('jenga.public_key'),
            config('jenga.private_key'),
        ];


        if ((! empty($publicKey) || !empty($privateKey)) && ! $this->option('force')) {
            $this->error(trans('jenga::jenga.keys.exists'));

            return self::FAILURE;
        } else {
            $key = RSA::createKey($this->option('length') ? (int) $this->option('length') : 2048);

            Env::getRepository()->set('JENGA_PRIVATE_KEY', (string) $key);
            Env::getRepository()->set('JENGA_PUBLIC_KEY', (string) $key->getPublicKey());

            $this->info(trans('jenga::jenga.keys.generated'));

//            $this->info((string) $key->getPublicKey());

            return self::SUCCESS;
        }
    }
}
