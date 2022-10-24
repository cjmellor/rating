<?php

namespace Cjmellor\Rating;

use Cjmellor\Rating\View\Components\Rating;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class RatingServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/rating.php' => config_path('rating.php'),
        ], 'rating-config');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'rating');

        $this->publishes([
            __DIR__.'/../database/migrations/create_ratings_table.php' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_ratings_table.php'),
        ], 'rating-migrations');

        $this->loadViewComponentsAs('show-rating', [
            Rating::class,
        ]);

        $this->publishes([
            __DIR__.'/../src/View/Components' => app_path('View/Components'),
            __DIR__.'/../resources/views/components' => resource_path('views/components'),
        ], 'rating-component');

        Blade::component('show-rating', Rating::class);
    }
}
