<?php

namespace NjoguAmos\Jenga\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use NjoguAmos\Jenga\JengaServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'NjoguAmos\\Jenga\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            JengaServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'sqlite');

        config()->set('app.key', 'base64:lg1m/12MHBbBpiWTXjot98Q9MP/nSzPrvLEU2beD+2Y=');

        config()->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
        ]);

        $migration = include __DIR__.'/../database/migrations/create_jenga_table.php.stub';
        $migration->up();
    }
}
