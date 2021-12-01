<?php

/**
 * ServiceProvider for our Kiyoh Package
 *
 * PHP version 7.4
 *
 * @category Reviews
 * @package  Kiyoh
 * @author   Stef van Esch <stef@marshmallow.dev>
 * @license  MIT Licence
 * @link     https://marshmallow.dev
 */

namespace Marshmallow\Reviews\Kiyoh;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Marshmallow\Reviews\Kiyoh\Console\Commands\StoreReviewsInDatabase;

/**
 * ServiceProvider for our Kiyoh Package
 *
 * @category Reviews
 * @package  Kiyoh
 * @author   Stef van Esch <stef@marshmallow.dev>
 * @license  MIT Licence
 * @link     https://marshmallow.dev
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/kiyoh.php',
            'kiyoh'
        );

        $this->commands([
            StoreReviewsInDatabase::class,
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . '/../config/kiyoh.php' => config_path('kiyoh.php'),
        ]);
    }
}
