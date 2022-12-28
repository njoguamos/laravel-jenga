<?php

namespace NjoguAmos\Jenga;

use NjoguAmos\Jenga\Commands\JengaAuthCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class JengaServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-jenga')
            ->hasConfigFile('jenga')
            ->hasMigration('create_jenga_tokens_table')
            ->hasCommand(JengaAuthCommand::class);
    }
}
