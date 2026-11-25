<?php

use App\Http\Controllers\Affiliate\DashboardController;
use App\Http\Controllers\Affiliate\LoginController;
use App\Http\Controllers\Affiliate\RegisterController;
use App\Http\Controllers\Affiliate\ReportsController;
use App\Http\Controllers\Affiliate\SubaffiliateController;


/**
 * Affiliates Routes.
 */
Route::group(['prefix' => 'affiliate', 'as' => 'affiliate.'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('affiliate_profile');
    Route::get('/payout', [DashboardController::class, 'payout'])->name('payout');

    Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
    Route::get('/reports/{id}', [ReportsController::class, 'show'])->name('reports.show');

    Route::delete('/subaffiliate/{id}', [SubaffiliateController::class, 'destroy'])->name('subaffiliate.destroy');
    Route::get('/create-employee', [SubaffiliateController::class, 'createEmployee'])->name('create_employee');
    Route::post('/create-employee', [SubaffiliateController::class, 'storeEmployee'])->name('storeEmployee');
});

Route::get('affiliate/login', [LoginController::class, 'login'])->name('affiliate.login')->withoutMiddleware(['auth', 'role:Affiliate']);
Route::post('affiliate/login', [LoginController::class, 'store'])->withoutMiddleware(['auth', 'role:Affiliate']);
Route::post('affiliate/register', [RegisterController::class, 'store'])->name('affiliate.register');


