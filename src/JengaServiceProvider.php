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
            ->name(name: 'jenga')
            ->hasConfigFile(configFileName: 'jenga')
            ->hasMigration(migrationFileName: 'create_jenga_tokens_table')
            ->hasCommands([
                JengaAuthCommand::class,
                JengaKeysCommand::class
            ])
            ->hasTranslations()
            ->hasInstallCommand(callable: function (InstallCommand $command) {
                $command
                    ->startWith(callable: function (InstallCommand $command) {
                        $command->info(string: 'Welcome! We are going to publish migrations and config files.');
                    })
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToStarRepoOnGitHub(vendorSlashRepoName: 'njoguamos/laravel-jenga')
                    ->endWith(callable: function (InstallCommand $command) {
                        $command->info(string: 'Congratulation! You can migrate your database. Happy coding!');
                    });
            });
    }
}
