<?php

namespace App\Modules\HealthCard\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class HealthCardServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register module config if needed
        // $this->mergeConfigFrom(
        //     __DIR__.'/../config/healthcard.php', 'healthcard'
        // );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Register routes
        $this->mapApiRoutes();

        // Register migrations - migrations are in database/migrations directory
        // They will be auto-discovered by Laravel
    }

    /**
     * Map API routes for the health card module
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api/healthcards')
            ->middleware(['api', 'auth:sanctum'])
            ->namespace('App\Modules\HealthCard\Http\Controllers')
            ->group(function () {
                Route::get('/', 'HealthCardController@index');
                Route::post('/', 'HealthCardController@store');
                Route::get('/{id}', 'HealthCardController@show');
                Route::put('/{id}', 'HealthCardController@update');
                Route::delete('/{id}', 'HealthCardController@destroy');
            });

        // Public QR endpoint (no auth required, but access controlled by access_type)
        Route::prefix('api/healthcards')
            ->middleware(['api'])
            ->namespace('App\Modules\HealthCard\Http\Controllers')
            ->group(function () {
                Route::get('/qr/{hash}', 'HealthCardController@getByQrHash');
            });
    }
}
