<?php

namespace Cjmellor\Rating\Tests;

use Cjmellor\Rating\RatingServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Cjmellor\\Rating\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            RatingServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $migration = include __DIR__.'/../database/migrations/create_rating_table.php';
        $fakeMigration = include __DIR__.'/../tests/database/migrations/create_fake_users_table.php';

        $migration->up();
        $fakeMigration->up();
    }
}
