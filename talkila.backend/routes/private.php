<?php

use App\Http\Controllers\Frontend\AboutMeController;
use App\Http\Controllers\Frontend\AffiliateController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\FavoriteController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\Jtc2Controller;
use App\Http\Controllers\Frontend\NotificationController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\SettingsController;
use App\Http\Controllers\Frontend\TalkDetailsController;

use App\Http\Controllers\Frontend\TalksController;
use App\Http\Controllers\Frontend\UserController;

Route::group(['namespace' => 'Frontend'], function () {

    Route::get('/settings/profile', [SettingsController::class, 'settings_profile'])->name('settings_profile');
    Route::get('/settings/billing-informations', [SettingsController::class, 'billing_ingormations'])->name('billing_ingormations');

    Route::get('/settings/cv', [SettingsController::class, 'cv_function'])->name('cv');
    Route::get('/settings/following', [SettingsController::class, 'settings_following'])->name('settings_following');
    Route::get('/settings/blocked-profiles', [SettingsController::class, 'settings_blocked_profiles'])->name('settings_blocked_profiles');
    Route::get('/settings/reviews', [ReviewController::class, 'settingsReviews'])->name('settings_reviews');
    Route::get('/settings/reviews-partial', [ReviewController::class, 'settingsReviewsPartial'])->name('settings_reviews');
    Route::get('/settings/feedback/comments', [ReviewController::class, 'getFeedbackComments'])->name('get_feedback_comments');
    Route::get('/settings/payout', [SettingsController::class, 'settings_payouts_page'])->name('settings_payouts_page');
    Route::get('/settings/payout/{payout}', [SettingsController::class, 'payoutByDate'])->name('payout.by.date');
    Route::get('/settings/wallets', [SettingsController::class, 'settings_wallets'])->name('settings_wallets');
    Route::get('/add-stripe-card', [HomeController::class, 'addStripeCard'])->name('addStripeCard');

    Route::get('/settings/transaction-history', [SettingsController::class, 'settings_transaction_history'])->name('settings_transaction_history');
    Route::post('/settings/delete-profile', [SettingsController::class, 'deleteProfile'])->name('settings.delete.profile');

    //Notifications
    Route::get('/settings/notifications', [NotificationController::class, 'settingsNotifications'])->name('settings_notifications');
    Route::get('/notification-redirect', [NotificationController::class, 'redirectNotification'])->name('notification_redirect');



    //Favorites
    Route::get('/favorites/users', [FavoriteController::class, 'favoriteUsers'])->name('favorites_users');
    Route::get('/favorites/users/{offset}', [FavoriteController::class, 'showMoreFavoriteUsers'])->name('show_morefavorites_users');
    Route::get('/favorites/talks', [FavoriteController::class, 'favoriteTalks'])->name('favorites_talks');
    Route::post('/favorites/talks-form', [FavoriteController::class, 'favorites'])->name('favorites_talks_form');

    //search pages /talks, /talks/{category} , /talks/{category}/{subcategory}
    Route::get('/search-talks', [TalksController::class, 'talks'])->name('courses')->withoutMiddleware(['auth', 'role:Student|Teacher|Affiliate']);
    Route::get('/search-talks-all-categories', [TalksController::class, 'talks_all'])->name('courses_all')->withoutMiddleware(['auth', 'role:Student|Teacher|Affiliate']);
    Route::get('/search-talks/{category}', [TalksController::class, 'talkCategory'])->name('talkCategory')->withoutMiddleware(['auth', 'role:Student|Teacher|Affiliate']);
    Route::get('/search-talks/{category}/{subcategory}', [TalksController::class, 'talkCategorySubcategory'])->name('talkCategorySubcategory')->withoutMiddleware(['auth', 'role:Student|Teacher|Affiliate']);

    //jtc pages

    Route::get('/jtc/welcome', [HomeController::class, 'jtc_welcome'])->name('jtc_welcome')->middleware('validationJTC');
    Route::post('/jtc/start', [HomeController::class, 'jtc_start'])->name('jtc_start')->middleware('validationJTC');

    Route::get('/jtc/create-your-first-talk', [Jtc2Controller::class, 'add_your_first_talk'])->name('jtc2_add_your_first_talk')->middleware('validationJTC');
    Route::get('/jtc/set-availabilities', [Jtc2Controller::class, 'set_availabilities'])->name('jtc2_set_availabilities')->middleware('validationJTC');
    Route::get('/jtc/add/calendar/{from}', [HomeController::class, 'add_jtc_calendar'])->name('add_jtc_calendar');
    Route::get('/jtc/delete-availability/{id}', [HomeController::class, 'deleteAvailability'])->name('delete-availability');
    Route::get('/jtc/verify-account', [Jtc2Controller::class, 'verify_account'])->name('jtc2_verify_account');
    Route::get('/jtc/account-created', [Jtc2Controller::class, 'account_created'])->name('jtc2_account_created');


    //bookings
    Route::get('/bookings', [BookingController::class, 'booking'])->name('booking');
    Route::get('/get-booking/{date}', [BookingController::class, 'getBookingDetail'])->name('booking_get_by_date');
    Route::get('/booking/{id}', [BookingController::class, 'booking_details'])->name('booking_details');
    Route::get('/set-booking/notification', [BookingController::class, 'setBookingNotification'])->name('set_booking_notification');
    Route::get('/cancel-booking', [BookingController::class, 'cancelBooking'])->name('cancel_booking');
    Route::get('/booking-thank-you', [BookingController::class, 'bookingThankYou'])->name('booking_thank_you');
    Route::get('/booking-payment', [BookingController::class, 'bookSlotPayment'])->name('book_slot_payment');
    Route::get('/booking-postpone', [BookingController::class, 'bookingPostpone'])->name('booking_postpone');
    Route::post('/booking/transaction', [BookingController::class, 'bookingTransaction'])->name('booking_transaction');
    Route::post('/settings/deposit-coins', [BookingController::class, 'depositCoins'])->name('settings_deposit_coins');

    Route::get('/paypal', [HomeController::class, 'paypal'])->name('paypal');


    Route::get('/talk/incall', [HomeController::class, 'video_conference'])->name('video_conference');
    Route::get('/talk/join', [HomeController::class, 'joinVideoViaToken'])->withoutMiddleware(['auth', 'role:Student|Teacher|Affiliate']);
    Route::get('/account-verification', [HomeController::class, 'account_verification'])->name('account_verification');

    Route::get('/{user:username}/talk/{id}', [TalkDetailsController::class, 'talk_details'])->name('talk_details');
    Route::get('/about-me', [AboutMeController::class, 'about'])->name('about_me');
    Route::get('/about-me-partial', [AboutMeController::class, 'about_me_partial']);

    // User profile section

    Route::get('/my-tokens', [UserController::class, 'userToken'])->name('userToken');
    Route::get('/category-subcategories', [HomeController::class, 'categorySubcategories'])->name('category-subcategories');

    Route::get('/booking-summary/{talk}', [BookingController::class, 'bookSlot'])->name('book_slot');

});
Route::get('/affiliate-discount', [AffiliateController::class, 'index'])->name('affiliate_discounts');
