<?php

namespace NjoguAmos\JengaAPI;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use NjoguAmos\JengaAPI\Commands\JengaAPICommand;

class JengaAPIServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-jenga-api')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-jenga-api_table')
            ->hasCommand(JengaAPICommand::class);
    }
}
