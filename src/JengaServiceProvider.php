<?php

namespace NjoguAmos\Jenga;

use NjoguAmos\Jenga\Commands\JengaAuthCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Commands\InstallCommand;

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
            ->name('jenga')
            ->hasConfigFile('jenga')
            ->hasMigration('create_jenga_tokens_table')
            ->hasCommand(JengaAuthCommand::class)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->startWith(function (InstallCommand $command) {
                        $command->info('Hello, and welcome to laravel jenga setup!');
                    })
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('njoguamos/laravel-jenga')
                    ->endWith(function (InstallCommand $command) {
                        $command->info('Happy coding!');
                    });
            });
        ;
    }
}
