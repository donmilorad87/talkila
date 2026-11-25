<?php

use App\Http\Controllers\Frontend\Api\BookingController;
use App\Http\Controllers\Frontend\Api\FavoriteTalks;
use App\Http\Controllers\Frontend\Api\JTCController;
use App\Http\Controllers\Frontend\Api\PaymentController;
use App\Http\Controllers\Frontend\Api\SettingsController;
use App\Http\Controllers\Frontend\Api\TalksController;
use App\Http\Controllers\Frontend\Api\UploadController;
use App\Http\Controllers\Frontend\Api\UserController;

/**
 * Frontend API Routes.
 */
Route::get('/frontend/api/edit-talks', [TalksController::class, 'editTalks'])->name('frontend_api_edit_token');
Route::post('/frontend/api/user-validate-username', [UserController::class, 'userValidateUsername'])->name('userValidateUsername');
Route::post('/frontend/api/edit-profile-name-and-username', [UserController::class, 'editProfileNameAndUsername'])->name('editProfileNameAndUsername');
Route::post('/frontend/api/remove-user-image', [UserController::class, 'removeUserImage'])->name('removeUserImage');
Route::post('/frontend/api/add-profile-verification', [UploadController::class, 'addProfileVerification'])->name('addProfileVerification');
Route::post('/frontend/api/edit-profile-photo', [UploadController::class, 'editProfilePhoto'])->name('editProfilePhoto');
Route::post('/frontend/api/join-the-club-availability', [UserController::class, 'joinTheClubAvailability'])->name('joinTheClubAvailability');
Route::get('/frontend/api/delete-availability/{id}', [UserController::class, 'deleteAvailability'])->name('deleteAvailability');
Route::post('/frontend/api/set-profile-payout-methods', [JTCController::class, 'setProfilPayoutMethods'])->name('setProfilPayoutMethods');
Route::post('/frontend/api/join-the-club-accounting', [JTCController::class, 'joinTheClubAccount'])->name('joinTheClubAccount');
Route::post('/frontend/api/edit-profile-name', [SettingsController::class, 'editProfileName'])->name('editProfileName');
Route::post('/frontend/api/edit-profile-biography', [SettingsController::class, 'editProfileBiography'])->name('editProfileBiography');

// SETTINGS
Route::post('/frontend/api/edit-profile-email', [SettingsController::class, 'editProfileEmail'])->name('editProfileEmail');
Route::post('/frontend/api/edit-profile-password', [SettingsController::class, 'editProfilePassword'])->name('editProfilePassword');
Route::post('/frontend/api/edit-profile-video', [SettingsController::class, 'editProfileVideo'])->name('editProfileVideo');
Route::post('/frontend/api/edit-profile-private-status', [SettingsController::class, 'editProfilePrivateStatus'])->name('editProfilePrivateStatus');
Route::get('/frontend/api/get-profession', [SettingsController::class, 'getProfession'])->name('getProfession');
Route::post('/frontend/api/user-update-profession', [SettingsController::class, 'userUpdateProfession'])->name('userUpdateProfession');
Route::post('/frontend/api/profile-cvs', [SettingsController::class, 'profilCvs'])->name('profilCvs');

Route::post('/frontend/api/unfollow-single-talk', [FavoriteTalks::class, 'unfallowSingeTalk'])->name('unfallowSingeTalk');
Route::post('/frontend/api/user-bookmarked-talks', [FavoriteTalks::class, 'userBookmarkedTalks'])->name('userBookmarkedTalks');
Route::post('/frontend/api/add-card', [PaymentController::class, 'addCards'])->name('addCards');
Route::post('/frontend/api/update-default-card', [PaymentController::class, 'updateDefaultCard'])->name('updateDefaultCard');
Route::post('/frontend/api/deposite-in-wallet', [PaymentController::class, 'depositeInWallet'])->name('depositeInWallet');

Route::post('/frontend/api/bookings', [PaymentController::class, 'bookingsPay']);
Route::post('/frontend/api/unfollow-user-request/{userId}', [UserController::class, 'removeFollow']);
Route::delete('/frontend/api/delete-talks/{courseId}', [TalksController::class, 'deleteTalk']);

Route::post('/frontend/api/pause-talk/{talkId}', [TalksController::class, 'pauseTalk'])->name('pause-talk');
Route::post('/frontend/api/unpause-talk/{talkId}', [TalksController::class, 'unPauseTalk'])->name('unpause-talk');
Route::post('/frontend/api/add-talk', [TalksController::class, 'addTalk']);

//Route::apiResource('/frontend/api/edit-talk', TalksApiController::class);

//add & edit talks
Route::put('/frontend/api/update-talk', [TalksController::class, 'updateTalk'])->name('update-talk');

//bookings
Route::get('/frontend/api/calls-cancellation-reasons', [BookingController::class, 'callsCancelationReasons'])->name('callsCancelationReasons');
Route::post('/frontend/api/feedback', [TalksController::class, 'storeFeedback']);
Route::post('/frontend/api/teacher-available-extensions', [BookingController::class, 'bookExtension']);
Route::post('/frontend/api/paypal-create-order', [PaymentController::class, 'payPallCreateOrder']);
Route::post('/frontend/api/paypal-authorize-order', [PaymentController::class, 'paypalAuthorizeOrder']);
Route::post('/frontend/api/paypal-capture-order', [PaymentController::class, 'paypalCaptureOrder']);
Route::post('/frontend/api/paypal-payment', [PaymentController::class, 'paypalPayment']);
Route::post('/frontend/api/book-extension', [PaymentController::class, 'bookExtendion']);
