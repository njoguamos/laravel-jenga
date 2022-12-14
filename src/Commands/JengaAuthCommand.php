<?php

namespace NjoguAmos\Jenga\Commands;

use Illuminate\Console\Command;

class JengaAuthCommand extends Command
{
    public $signature = 'jenga:auth';

    public $description = 'Generate your Bearer token and save to database';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
