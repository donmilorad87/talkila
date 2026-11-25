<?php

use App\Http\Controllers\Admin\BookingsController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\UsersController as AdminUsersController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\Api\UserController as ApiUserController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\HomeController as FrontendHomeController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\UserVerificationController;


Route::webhooks('webhook-receiving-url', 'adyen');
Route::webhooks('websocket-webhook-receiving-url', 'websocket');

Route::get('paymentMethods', [LoginController::class, 'logout']);
Route::get('userVerification/{token}', [UserVerificationController::class, 'approve'])->name('userVerification');
Route::get('users/user-registration-verify', [AdminUsersController::class, 'registrationVerification'])->name('users.user-registration-verify');
Route::get('users/user-email-verify', [AdminUsersController::class, 'verification'])->name('users.user-email-verify');

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => ['auth']], function () {
// Change password
    if (ChangePasswordController::class) {
        Route::get('password', [ChangePasswordController::class, 'edit'])->name('password.edit');
        Route::post('password', [ChangePasswordController::class, 'update'])->name('password.update');
    }
});

// File manager removed (unisharp/laravel-filemanager package dropped)

Route::group(['namespace' => 'Admin'], function () {
    Route::get('/teacher-available-extensions/{id}', [BookingsController::class, 'getAvailableExtensions']);
    Route::get('/call-extension/{id}/{time}', [BookingsController::class, 'makeCallExtension']);
});

// Used to retrieve the media files
Route::get('media/{folder}/{filename}', function ($folder, $filename) {
    $path = storage_path('app') . '/tracks/' . $folder . '/' . $filename;

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::group(['namespace' => 'Frontend'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/lp/{affiliateRefereeHash}', [HomeController::class, 'affiliateRefereeHash'])->name('affiliateRefereeHash');
    Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
    //get rating on booking slot
    Route::get('/get-rating/{talk_id}', [BookingController::class, 'getRating'])->name('getRating');
});

Route::post('/frontend/api/joinTheClubAvailability', [ApiUserController::class, 'talks'])->name('joinTheClubAvailability');

// Twilio room test tool (migrated from twiliobackend)
Route::get('/twilio-test', function () { return view('twilio-test'); });
Route::get('/twilio-test-ali', function () { return view('twilio-test'); });

// User profile
Route::group(['namespace' => 'Frontend'], function () {
    Route::get('/verification-account', [FrontendHomeController::class, 'verificationEmail'])->name('verificationEmail');
    Route::get('/teacher-talks', [FrontendHomeController::class, 'teacherTalks'])->name('teacher_talks');
    Route::get('/teacher-date-functionality', [FrontendHomeController::class, 'teacherDateFuncionality'])->name('teacher_date_functionality');
    Route::get('/profile/{id}', [ProfileController::class, 'userProfile'])->name('profile');
    Route::get('{user:username}', [ProfileController::class, 'userProfile'])->name('profile');
});

// Dynamic created pages (need to be last in file)
Route::group(['namespace' => 'Admin'], function () {

    Route::get('display-wallet', [BookingsController::class, 'wallet']);
    Route::get('display-wallets-ledger', [BookingsController::class, 'walletLedgers']);
    Route::get('static/{slug}', [PageController::class, 'dynamic_page']);
});

// Dynamic created pages (need to be last in file)
Route::group(['namespace' => 'Frontend'], function () {
    Route::get('legal/{slug}', [FrontendHomeController::class, 'legal'])->name('legal_pages');
});
