<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/clear-cache', function () {
    // Clear route cache
    Artisan::call('route:clear');

    // Optimize class loading
    Artisan::call('optimize');

    // Optimize configuration loading
    Artisan::call('config:cache');

    // Optimize views loading
    Artisan::call('view:cache');

    // Additional optimizations you may want to run

    return "Cache cleared and optimizations done successfully.";
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::namespace('App\Http\Controllers')->group(
    function () {
        Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
            Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

            Route::resource('/users', 'UserController');
            Route::resource('/card', 'CardsController');
            Route::resource('/package', 'PackagesController');
        });
    }
);
