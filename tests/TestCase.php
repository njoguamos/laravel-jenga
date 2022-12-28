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

    protected function getPackageProviders($app): array
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

        config()->set('jenga.key', 'i+FQANDLI7siJluilq/zZzlcicZQiFnUxHuSAuQFBykTXpz6HyqB+PGtyWr1nmrw4VTT3V/dB+tqP3UQik5+0w==');
        config()->set('jenga.merchant', 1234567);
        config()->set('jenga.secret', '9aU1Z4wRKa9qoLQTwsaX405kRb51C8');

        $migration = include __DIR__.'/../database/migrations/create_jenga_table.php.stub';
        $migration->up();
    }
}
