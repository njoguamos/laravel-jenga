<?php

namespace NjoguAmos\Jenga\Commands;

use Illuminate\Console\Command;
use phpseclib3\Crypt\RSA;

class JengaKeysCommand extends Command
{
    protected $signature = 'jenga:keys
                                      {--force : Overwrite keys they already exist}
                                      {--length=4096 : The length of the private key}';

    protected $description = 'Create the encryption keys for Jenga API signature.';

    public function handle(): int
    {
        $key = RSA::createKey(bits: $this->option(key: 'length') ? (int) $this->option(key: 'length') : 2048);

        file_put_contents(
            filename: config(key: 'jenga.keys_path').'/jenga.key',
            data: (string) $key
        );

        file_put_contents(
            filename: config(key:'jenga.keys_path').'/jenga.pub.key',
            data: (string) $key->getPublicKey()
        );

        $this->info(string: trans(key: 'jenga::jenga.keys.generated', replace: ['dir' => config(key:'jenga.keys_path')]));


        return self::SUCCESS;
    }
}
