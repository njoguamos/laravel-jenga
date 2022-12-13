<?php

namespace NjoguAmos\JengaAPI\Commands;

use Illuminate\Console\Command;

class JengaAPICommand extends Command
{
    public $signature = 'laravel-jenga-api';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
