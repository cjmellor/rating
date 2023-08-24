<?php

namespace Cjmellor\Rating;

use Cjmellor\Rating\Livewire\Rating;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class RatingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/rating.php' => config_path('rating.php'),
        ], 'rating-config');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'rating');

        $this->publishes([
            __DIR__.'/../database/migrations/create_ratings_table.php' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_ratings_table.php'),
        ], 'rating-migrations');

        Livewire::component('rating', Rating::class);
    }
}
