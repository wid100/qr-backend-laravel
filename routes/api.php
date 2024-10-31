<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrgenController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\InstaController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ResumeController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\TemplateCategory;
use App\Http\Controllers\Api\TemplateController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\FAQController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\InstagramController;
use App\Http\Controllers\Auth\CustomAuthenticatedSessionController;
use App\Http\Controllers\WebsiteController;

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
// User

Route::post('/users/{id}', [UserController::class, 'update']);

// Route::post('/login', [CustomAuthenticatedSessionController::class, 'store']);

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


// Chaker Payment
Route::post('/check-subscription', [SubscriptionController::class, 'checkSubscription'])->name('checkSubscription');

// QR Instagram

Route::post('create-instagram', [InstagramController::class, 'store']);
Route::get('/get-instagram/{user}', [InstagramController::class, 'getInstagram']);
Route::post('/update-instagram/{id}', [InstagramController::class, 'update']);
Route::delete('/delete_instagram/{id}', [InstagramController::class, 'destroy']);
Route::get('/edit_instagram/{id}', [InstagramController::class, 'edit']);
// Route::get('/getActiveInstagram/{userId}', [InstagramController::class, 'getActiveInstagram']);
// Route::get('/getpauseInstagram/{userId}', [InstagramController::class, 'getPauseeInstagram']);
// Route::put('/instagram/toggle-status/{id}', [InstagramController::class, 'toggleStatusInstagram']);

// Route::get('/edit-instagram/{id}', [InstagramController::class, 'edit']);


// QR Website

Route::post('create-website', [WebsiteController::class, 'store']);
Route::get('/get-website/{user}', [WebsiteController::class, 'getWebsite']);

Route::post('/update_website/{id}', [WebsiteController::class, 'update']);
Route::get('/edit_website/{id}', [WebsiteController::class, 'edit']);
Route::delete('/delete_website/{id}', [WebsiteController::class, 'destroy']);


// ==============insta systems============
Route::get('category', [InstaController::class, 'allCategory']);
Route::get('template', [InstaController::class, 'allTemplate']);

//Resume
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/resume', [ResumeController::class, 'index']);
// });

//get all resume
// Route::get('/resume', [ResumeController::class, 'index']);
Route::get('/user/{user}/resumes', [ResumeController::class, 'index']);
Route::get('/resume/{slug}', [ResumeController::class, 'show']);
Route::post('/resume', [ResumeController::class, 'store']);
Route::get('/resume/edit/{slug}', [ResumeController::class, 'edit']);
Route::post('/resume/{resume}', [ResumeController::class, 'update']); // resume mens id
Route::delete('/resume/{resume}', [ResumeController::class, 'destroy']);

Route::get('category', [InstaController::class, 'allCategory']);
Route::get('/template-category', TemplateCategory::class);
Route::get('/templates/{id}', [TemplateController::class, 'getTemplates']);
Route::get('/template/{id}', [TemplateController::class, 'getTemplate']);

//schedule
Route::post('/schedules', [ScheduleController::class, 'store']);
Route::get('/schedules/{id}', [ScheduleController::class, 'edit']);
Route::put('/schedules/{id}', [ScheduleController::class, 'update']);
Route::delete('/schedules/{id}', [ScheduleController::class, 'destroy']);
Route::get('/schedule/{id}', [ScheduleController::class, 'index']);



//appointments
Route::post('/create-appointment', [AppointmentController::class, 'store']);
Route::get('/all-appointment/{id}', [AppointmentController::class, 'index']);
// routes/api.php
Route::get('/get-available-slots/{user_id}/{date}', [AppointmentController::class, 'getAvailableSlots']);
// Route::get('/get-available-slots', [AppointmentController::class, 'getAvailableSlots']);
// contact us
Route::post('/message', [MessageController::class, 'create']);
//FAQ
Route::get('/faqs', [FAQController::class, 'index']);
