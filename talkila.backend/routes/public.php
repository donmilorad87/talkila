<?php

use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\Jtc2Controller;

Route::group(['namespace' => 'Frontend'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/lp/{affiliateRefereeHash}', [HomeController::class, 'affiliateRefereeHash'])->name('affiliateRefereeHash');
    Route::get('/faq', [HomeController::class, 'faq'])->name('faq');

    //get rating on booking slot
    Route::get('/get-rating/{talk_id}', [BookingController::class, 'getRating'])->name('getRating');

    //jtc 2

    Route::get('/jtc/create-profile/', [Jtc2Controller::class, 'create_profile'])->name('jtc2_create_profile');

});

Route::group(['namespace' => 'Frontend'], function () {

    Route::get('/f/{partner?}', [Jtc2Controller::class, 'partner_start'])->name('partner_start');
    Route::get('/create-partner-prepare/{partner:slug}', [Jtc2Controller::class, 'partner_create_profile'])->name('partner_create_profile');

});
