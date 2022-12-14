<?php

namespace NjoguAmos\JengaAPI\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use NjoguAmos\JengaAPI\JengaAPIServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'NjoguAmos\\JengaAPI\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            JengaAPIServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'sqlite');

        config()->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
        ]);

        $migration = include __DIR__.'/../database/migrations/create_jenga_api_table.php.stub';
        $migration->up();
    }
}
