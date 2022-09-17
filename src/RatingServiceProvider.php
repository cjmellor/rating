<?php

namespace Cjmellor\Rating;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class RatingServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('rating')
            ->hasConfigFile()
//            ->hasViews()
            ->hasMigration(migrationFileName: 'create_rating_table');
    }
}
