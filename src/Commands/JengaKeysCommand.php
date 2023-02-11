<?php

namespace NjoguAmos\Jenga\Commands;

use Illuminate\Console\Command;
use phpseclib3\Crypt\RSA;
use Spatie\Crypto\Rsa\KeyPair;

class JengaKeysCommand extends Command
{
    protected $signature = 'jenga:keys {--force : Overwrite keys they already exist}';

    protected $description = 'Create the encryption keys for Jenga API signature.';

    public function handle(): int
    {
        (new KeyPair())
            ->generate(
                privateKeyPath: config(key: 'jenga.keys_path').'/jenga.key',
                publicKeyPath:  config(key:'jenga.keys_path').'/jenga.pub.key'
            );

        $this->info(
            string: trans(
                key: 'jenga::jenga.keys.generated',
                replace: ['dir' => config(key:'jenga.keys_path')]
            )
        );


        return self::SUCCESS;
    }
}
