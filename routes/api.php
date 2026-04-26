<?php

use App\Http\Controllers\Admin\StripePaymentController;
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
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\Admin\PayPalController;
use App\Http\Controllers\Api\SmartCardController;
use App\Http\Controllers\Api\ScheduleAreaController;
use App\Http\Controllers\Api\CardOrderController;

use App\Models\Subscription;
use App\Models\User;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return response()->json($request->user());
// });


/*
|--------------------------------------------------------------------------
| Authentication Routes (Sanctum SPA, cookie/session)
|--------------------------------------------------------------------------
| Single, secure auth pipeline used by the Next.js frontend.
| - HttpOnly + SameSite=Lax cookies (Secure in production)
| - CSRF protected via Sanctum's EnsureFrontendRequestsAreStateful
| - Rate-limited to mitigate brute-force
| - Email verification mandatory before login is allowed
*/

Route::middleware('throttle:10,1')->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('api.register');
    Route::post('/login',    [AuthenticatedSessionController::class, 'store'])->name('api.login');
    Route::post('/password/email', [PasswordResetLinkController::class, 'store'])->name('api.password.email');
    Route::post('/password/reset', [NewPasswordController::class, 'store'])->name('api.password.update');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        $user = $request->user();
        $subscription = Subscription::where('user_id', $user->id)->first();
        $isSubscribed = $subscription
            && ($subscription->end_date > now() || $subscription->status == 1);

        $userData = $user->toArray();
        $userData['subscribed'] = (bool) $isSubscribed;
        return response()->json($userData);
    })->name('api.user');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('api.logout');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('api.verification.send');
});

Route::post('/users/{id}', [UserController::class, 'update']);

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

// stripe
Route::post('/create-payment-intent', [StripePaymentController::class, 'createPaymentIntent']);
Route::post('/save-transaction', [StripePaymentController::class, 'store']);
// paypal
Route::post('/paypal/create-payment', [PayPalController::class, 'createPayment']);
Route::post('/paypal/capture-order', [PayPalController::class, 'captureOrder']);
Route::get('/paypal/payment/{paymentId}', [PayPalController::class, 'showPaymentDetails']);


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
Route::get('/appointment/show/{id}', [AppointmentController::class, 'show']);
Route::post('/appointment/approved/{id}', [AppointmentController::class, 'update']);
Route::post('/appointment/decline/{id}', [AppointmentController::class, 'decline']);
Route::delete('/appointment/{id}', [AppointmentController::class, 'destroy']);







// routes/api.php
Route::get('/get-available-slots/{user_id}/{date}', [AppointmentController::class, 'getAvailableSlots']);
// Route::get('/get-available-slots', [AppointmentController::class, 'getAvailableSlots']);
// contact us
Route::post('/message', [MessageController::class, 'create']);
//FAQ
Route::get('/faqs', [FAQController::class, 'index']);
// get all smard card design
Route::get('/get-card-design', SmartCardController::class);


// Schedule Area
Route::post('/schedule-area', [ScheduleAreaController::class, 'store']);
Route::get('/schedule-area/{id}', [ScheduleAreaController::class, 'edit']);
Route::post('/schedule-area/update/{id}', [ScheduleAreaController::class, 'update']);

Route::delete('/schedule-area/delete/{id}', [ScheduleAreaController::class, 'destroy']);
Route::get('/schedule/areas/{userId}', [ScheduleAreaController::class, 'index']);


Route::get('/card-details/{id}', [SmartCardController::class, 'getCardDetails']);
// NOTE: `/api/create-payment-intent` is reserved for subscription Stripe flow
// handled by `StripePaymentController::createPaymentIntent`.
// Keep SmartCard payment intent under a distinct path to avoid route override bugs.
Route::post('/smartcard/create-payment-intent', [SmartCardController::class, 'createPaymentIntent']);
Route::post('/create-checkout-session', [SmartCardController::class, 'createCheckoutSession']);
Route::post('/make-order', [SmartCardController::class, 'store']);
Route::get('/cards', SmartCardController::class);

// Health Card System Routes
Route::middleware('auth:sanctum')->prefix('healthcards')->group(function () {
    // Health Card CRUD
    Route::get('/', [App\Modules\HealthCard\Http\Controllers\HealthCardController::class, 'index']);
    Route::post('/', [App\Modules\HealthCard\Http\Controllers\HealthCardController::class, 'store']);
    Route::get('/{id}', [App\Modules\HealthCard\Http\Controllers\HealthCardController::class, 'show']);
    Route::put('/{id}', [App\Modules\HealthCard\Http\Controllers\HealthCardController::class, 'update']);
    Route::delete('/{id}', [App\Modules\HealthCard\Http\Controllers\HealthCardController::class, 'destroy']);

    // Health Card Medical Reports
    Route::get('/{healthCardId}/medical-reports', [App\Modules\HealthCard\Http\Controllers\MedicalReportController::class, 'index']);
    Route::post('/{healthCardId}/medical-reports', [App\Modules\HealthCard\Http\Controllers\MedicalReportController::class, 'store']);

    // Medical Report CRUD
    Route::get('/medical-reports/{id}', [App\Modules\HealthCard\Http\Controllers\MedicalReportController::class, 'show']);
    Route::match(['put', 'post'], '/medical-reports/{id}', [App\Modules\HealthCard\Http\Controllers\MedicalReportController::class, 'update']);
    Route::delete('/medical-reports/{id}', [App\Modules\HealthCard\Http\Controllers\MedicalReportController::class, 'destroy']);
});

// Public Health Card Routes (based on access_type)
Route::get('/healthcards/qr/{hash}', [App\Modules\HealthCard\Http\Controllers\HealthCardController::class, 'getByQrHash']);
Route::get('/healthcards/public/{slug}', [App\Modules\HealthCard\Http\Controllers\HealthCardController::class, 'getBySlug']);

