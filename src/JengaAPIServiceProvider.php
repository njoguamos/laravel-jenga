<?php

namespace NjoguAmos\JengaAPI;

use NjoguAmos\JengaAPI\Commands\JengaAPICommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
