<?php

namespace NjoguAmos\Jenga;

use NjoguAmos\Jenga\Commands\JengaAuthCommand;
use NjoguAmos\Jenga\Commands\JengaKeysCommand;
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
            ->hasCommands([
                JengaAuthCommand::class,
                JengaKeysCommand::class
            ])
            ->hasTranslations()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->startWith(function (InstallCommand $command) {
                        $command->info('Welcome! We are going to publish migrations and config files.');
                    })
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToStarRepoOnGitHub('njoguamos/laravel-jenga')
                    ->endWith(function (InstallCommand $command) {
                        $command->info('Congratulation! You can migrate your database. Happy coding!');
                    });
            });
    }
}
