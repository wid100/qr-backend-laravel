<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\Admin\InstaCardController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\InstaCategoryController;
use App\Http\Controllers\Admin\InstaTemplateController;
use App\Http\Controllers\Admin\TemplateCategoryController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\colorController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Models\Admin\Resume;
use App\Models\Admin\Template;

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


Route::get('/verify-email/{id}/{hash}', [App\Http\Controllers\Auth\VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->name('verification.send');

// Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
//     ->middleware('guest')
//     ->name('password.email');


Route::get('verify-email/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = \App\Models\User::findOrFail($id);

    if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        throw new \Illuminate\Auth\Access\AuthorizationException;
    }

    if ($user->hasVerifiedEmail()) {
        return redirect(config('app.frontend_url') . '/email-already-verified');
    }

    if ($user->markEmailAsVerified()) {
        event(new \Illuminate\Auth\Events\Verified($user));
    }

    return redirect(config('app.frontend_url') . '/email-verified');
})->name('verification.verify');




Auth::routes();



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::namespace('App\Http\Controllers')->group(
    function () {
        Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
            Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

            Route::resource('/users', 'UserController');
            Route::get('/block', 'UserController@block')->name('block');
            Route::resource('/card', 'CardsController');
            Route::resource('/package', 'PackagesController');
            Route::resource('/payment', 'PaymentController');
            Route::resource('/subscription', 'SubscriptionsController');

            Route::resource('/website', 'WebsiteCardController');
            Route::resource('/instagram', 'InstaCardController');
            Route::resource('/instacategory', 'InstaCategoryController');
            Route::resource('/instatemplate', 'InstaTemplateController');
            Route::resource('/tempcategory', 'TemplateCategoryController');
            Route::resource('/template', 'TemplateController');
            Route::resource('/product_category', 'ProductCategoryController');
            Route::resource('/product',"productController");
            Route::resource('/color',"colorController");

        });
    }
);

Route::get('/cv', function () {
    $template = Template::findOrFail(9);
    $resume = Resume::findOrFail(3);
    $experience = json_decode($resume->experience);
    // dd($experience);

    // foreach ($experience as $item) {
    //     var_dump($item->location);
    // }
    // dd($resume->title);

    // return view('resume.resume', compact('template', 'experience'));

    $htmlContent = $template->code;
    $htmlContent = str_replace('{resume.fname}', $resume->fname, $htmlContent);
    $htmlContent = str_replace('{resume.lname}', $resume->lname, $htmlContent);
    $htmlContent = str_replace('{resume.email}', $resume->email, $htmlContent);
    $htmlContent = str_replace('{resume.description}', $resume->description, $htmlContent);
    $htmlContent = str_replace('{resume.title}', $resume->title, $htmlContent);

    $data = gettype($experience);
    dd($data);
    return view('resume.resume', [
        'htmlContent' => $htmlContent,
        'template' => $template,
        'experience' => $experience,
    ]);
});
