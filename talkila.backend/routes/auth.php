<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Frontend\AuthController;

/**
 * Auth Routes.
 */
Auth::routes();
Route::view('/callback', 'callback');
Route::get('/account/logout', [\App\Http\Controllers\Frontend\HomeController::class, 'logout'])->name('logout');
Route::get('/account/signup', [\App\Http\Controllers\Frontend\HomeController::class, 'signup'])->name('signup');
Route::get('/account/forgot-password', [\App\Http\Controllers\Frontend\HomeController::class, 'forgot_password'])->name('forgot_password')->middleware('guest');
Route::post('/user-register', [\App\Http\Controllers\Frontend\HomeController::class, 'guzzleRegister'])->name('user-register');
Route::post('/forgot-password', [\App\Http\Controllers\Frontend\HomeController::class, 'forgotPassword'])->name('forgot-password');
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('redirect_to_google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('handle_google_callback');
Route::get('/auth/facebook', [AuthController::class, 'redirectToFacebook'])->name('redirect_to_facebook');
Route::get('/auth/facebook/callback', [AuthController::class, 'handleFacebookCallback'])->name('handle_facebook_callback');
Route::get('/auth/google/calendar', [AuthController::class, 'handleGoogleCalendarCallback']);
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login-admin');
Route::post('/account/login', [LoginController::class, 'login'])->name('login-user');
Route::get('login/{driver}', [LoginController::class, 'redirectToSocial']);
Route::get('login/{driver}/callback', [LoginController::class, 'handleSocialCallback']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout-admin');
Route::post('socialite-register/{user}', [RegisterController::class, 'socialiteRegister'])->name('socialite-register');
Route::get('/account/login', [\App\Http\Controllers\Frontend\HomeController::class, 'login'])->name('login');


/**
 * Verify user account ownership routes.
 */

Route::get('/verify/socials', [AuthController::class, 'socials'])->name('vsocials');

Route::post('/add/social/verification', [AuthController::class, 'addSocialVerification'])->name('addSocialVerification');
Route::post('/delete/social/verification', [AuthController::class, 'deleteSocialVerification'])->name('deleteSocialVerification');
Route::get('/get/social/verifications', [AuthController::class, 'getSocialVerifications'])->name('getSocialVerifications');

Route::get('/verify/linkedin', [AuthController::class, 'verifyLinkedin'])->name('verifyLinkedin');
Route::get('/verify/instagram', [AuthController::class, 'verifyInstagram'])->name('verifyInstagram');
Route::get('/verify/facebook', [AuthController::class, 'verifyFacebook'])->name('verifyFacebook');
