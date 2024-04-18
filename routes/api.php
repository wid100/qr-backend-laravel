<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrgenController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\PaymentController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user());
});

Route::post('qrcreate', [QrgenController::class, 'store']);
Route::get('information/{slug}', [QrgenController::class, 'show']);
Route::get('/getqr/{user}', [QrgenController::class, 'getGetqrByUser']);

Route::post('/updateqr/{id}', [QrgenController::class, 'update']);
Route::get('/editqr/{id}', [QrgenController::class, 'edit']);
Route::delete('/deleteqr/{id}', [QrgenController::class, 'destroy']);
Route::put('/qrgen/toggle-status/{id}', [QrgenController::class, 'toggleStatus']);
// routes/web.php

Route::get('/getActiveQr/{userId}', [QrgenController::class, 'getActiveQr']);
Route::get('/getpauseQr/{userId}', [QrgenController::class, 'getPauseeQr']);
Route::get('/qr-details/{id}', [QrgenController::class, 'getQrDetails']);
//country
Route::get('/country', [CountryController::class, 'allCountry']);
Route::get('/packages/filter', [PackageController::class, 'filterByCountry']);
Route::get('/packages/{id}', [PackageController::class, 'show']);



Route::post('/make-payment', [PaymentController::class, 'makePayment'])->middleware(\Fruitcake\Cors\HandleCors::class);

Route::post('/verify-payment', [PaymentController::class, 'verifyPayment']);
Route::post('success', [paymentController::class, 'success'])->name('success');
Route::post('fail', [paymentController::class, 'fail'])->name('fail');
Route::get('cancel', [paymentController::class, 'cancel'])->name('cancel');
