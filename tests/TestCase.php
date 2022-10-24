<?php

namespace Cjmellor\Rating\Tests;

use Cjmellor\Rating\RatingServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;
use Schema;

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

        $migration = include __DIR__.'/../database/migrations/create_ratings_table.php';

        $migration->up();

        Schema::create(table: 'fake_users', callback: function (Blueprint $table) {
            $table->id();
            $table->string(column: 'username');
            $table->string(column: 'password');
        });
    }
}
