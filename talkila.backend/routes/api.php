<?php

use App\Http\Controllers\Admin\AdyenPaymentController;
use App\Http\Controllers\Api\V1\Admin\AppFeedbackApiController;
use App\Http\Controllers\Api\V1\Admin\AvailabilityApiController;
use App\Http\Controllers\Api\V1\Admin\BillingAddressApiController;
use App\Http\Controllers\Api\V1\Admin\BookingsApiController;
use App\Http\Controllers\Api\V1\Admin\CalendarController;
use App\Http\Controllers\Api\V1\Admin\CallsCancellationReasonApiController;
use App\Http\Controllers\Api\V1\Admin\CountriesApiController;
use App\Http\Controllers\Api\V1\Admin\CreditCardController;
use App\Http\Controllers\Api\V1\Admin\FeedbackApiController;
use App\Http\Controllers\Api\V1\Admin\JoinTheClubApiController;
use App\Http\Controllers\Api\V1\Admin\LanguagesApiController;
use App\Http\Controllers\Api\V1\Admin\NotificationsApiController;
use App\Http\Controllers\Api\V1\Admin\NotificationSettingsController;
use App\Http\Controllers\Api\V1\Admin\PageApiController;
use App\Http\Controllers\Api\V1\Admin\PaymentMethodController;
use App\Http\Controllers\Api\V1\Admin\PayoutsApiController;
use App\Http\Controllers\Api\V1\Admin\PayoutsMethodsApiController;
use App\Http\Controllers\Api\V1\Admin\PayPalController;
use App\Http\Controllers\Api\V1\Admin\ProfilCvApiController;
use App\Http\Controllers\Api\V1\Admin\ProfileVerificationApiController;
use App\Http\Controllers\Api\V1\Admin\SearchesApiController;
use App\Http\Controllers\Api\V1\Admin\StaticProfessionsApiController;
use App\Http\Controllers\Api\V1\Admin\TalkCategoriesApiController;
use App\Http\Controllers\Api\V1\Admin\TalkReportedApiController;
use App\Http\Controllers\Api\V1\Admin\TalksApiController;
use App\Http\Controllers\Api\V1\Admin\UserAdditionalInfoAPIController;
use App\Http\Controllers\Api\V1\Admin\UserApiController;
use App\Http\Controllers\Api\V1\Admin\UserBlockedApiController;
use App\Http\Controllers\Api\V1\Admin\UserBookmarkedTalksApiController;
use App\Http\Controllers\Api\V1\Admin\UserFollowedApiController;
use App\Http\Controllers\Api\V1\Admin\UserReportedApiController;
use App\Http\Controllers\Api\V1\Admin\UserReportedTypeApiController;
use App\Http\Controllers\Api\V1\Admin\UsersApiController;
use App\Http\Controllers\Api\V1\Admin\VATController;
use App\Http\Controllers\Api\V1\Admin\WalletController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\PartnerController;
use App\Http\Controllers\Api\V1\FrontendApiCalls\UserProfileApiController;

Route::group(['prefix' => 'v1', 'as' => 'api.'], function () {
    // Register
    Route::post('/register', [AuthController::class, 'register']);

    // Login
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/login-with-google', [AuthController::class, 'loginWithGoogle']);
    Route::post('/login-with-facebook', [AuthController::class, 'loginWithFacebook']);
    Route::post('/login-with-apple', [AuthController::class, 'loginWithApple']);
    // NOTE: only needed for login with apple on android
    Route::get('/callbacks/login-with-apple', [AuthController::class, 'loginWithAppleCallback']);

    // Reset password
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail']);
    Route::post('/reset-password', [AuthController::class, 'resetLink']);

    // Authenticated user
    Route::post('/user', [AuthController::class, 'user'])->middleware(['auth:api']);

    // Logout authenticated user
    Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:api']);

    Route::post('/profile-picture', [AuthController::class, 'storeProfilePicture'])->middleware(['auth:api']);

    // User Payment
//    Route::post('/payment', 'PaymentController@payment')->name('payment');

    Route::prefix('{partner:slug}')->group(function () {
        Route::post('account/save', [PartnerController::class, 'save']);
        Route::post('account/create', [PartnerController::class, 'create']);
    });

    Route::prefix('partners')->group(function () {
        Route::post('login', [PartnerController::class, 'login']);
        Route::post('logout', [PartnerController::class, 'logout']);
        Route::get('dashboard', [PartnerController::class, 'dashboard']);
        Route::get('{partner}', [PartnerController::class, 'show']);
    });
});

Route::group(['prefix' => 'v1', 'as' => 'api.'], function () {
    // User Api global section
    Route::post('/user-validate-username', [UserApiController::class, 'checkUsernameUnique']);
    Route::post('/user-validate-email', [UserApiController::class, 'checkEmailUnique']);

    // NOTE: need to be called/available from both, public and logged-in sections
    Route::get('/user-email-verify', [UserApiController::class, 'verification'])->name('email.verify');
    Route::post('/new-account-verify', [UserApiController::class, 'newAccountVerification']);
    Route::post('/resend-verification-email', [UserApiController::class, 'resendVerificationEmail']);
});

Route::group(['prefix' => 'v1/frontend', 'as' => 'frontend-api.'], function () {
    // User Api global section
    Route::get('/users/{id}', [UserProfileApiController::class, 'show']);
    Route::get('/profile-user-cvs', [UserProfileApiController::class, 'userCv']);
    Route::post('/profile-user-cvs', [UserProfileApiController::class, 'userCv']);
    Route::post('/teacher-feedback', [UserProfileApiController::class, 'getTeacherRating']);
    Route::post('/teacher-talks/{teacherId}', [UserProfileApiController::class, 'teacherTalks']);
    Route::get('/join-the-club-availabilities', [UserProfileApiController::class, 'getUserAvailability']);
    Route::post('/join-the-club-availabilities', [UserProfileApiController::class, 'getUserAvailability']);
    Route::get('teacher-availability/{id}', [UserProfileApiController::class, 'getTeacherAvailability']);
    Route::get('get-talk-user/{talkId}', [UserProfileApiController::class, 'getTalkUserData']);
    Route::get('/user-bookings', [UserProfileApiController::class, 'getLoggedUserBookings'])->name('user-bookings');
    Route::get('calls-cancellation-reasons', [UserProfileApiController::class, 'cancellationReason']);
    Route::get('search-talks', [UserProfileApiController::class, 'searchTalks']);
    Route::get('/talks/{category}/{subcategory}', [UserProfileApiController::class, 'searchTalksByCategory'])->name('talks.category-subcategory');
    Route::get('/talks-search/{category}/{subcategory?}', [UserProfileApiController::class, 'getTalkSearch'])->name('talks-search.category-subcategory');
});

Route::group(['namespace' => 'Admin', 'middleware' => ['auth:api']], function () {
    // Adyen
    Route::any('payment/adyen-payment-methods', [AdyenPaymentController::class, 'adyenPaymentMethods'])->name('adyen-payment-methods');
    Route::post('payment/payments/', [AdyenPaymentController::class, 'adyenMakePayment']);
    Route::post('payment/payments/details/', [AdyenPaymentController::class, 'adyenAdditionalDetails']);
});

Route::group(['prefix' => 'v1', 'as' => 'api.', 'middleware' => ['auth:api']], function () {
    // Users
    Route::apiResource('users', UsersApiController::class);

    // User Followeds
    Route::post('/user-favorites', [UserFollowedApiController::class, 'userTalkFollowers']);
    Route::get('/following-user', [UserFollowedApiController::class, 'followingUser']);
    Route::get('/user-follow-request', [UserFollowedApiController::class, 'userFollowRequests']);
    Route::post('/follow-user-request/{id}', [UserFollowedApiController::class, 'followRequest']);
    Route::post('/unfollow-user-request/{id}', [UserFollowedApiController::class, 'removeFollow']);
    Route::post('/unfollow-favorites', [UserFollowedApiController::class, 'unfollowFavorites']);
    Route::get('/number-of-followers', [UserFollowedApiController::class, 'numberOfFollowers']);
    //
    Route::get('/follow-requests', [UserFollowedApiController::class, 'followRequests']);
    Route::get('/following-requests', [UserFollowedApiController::class, 'followingRequests']);
    Route::post('/accept-follow-request/{id}', [UserFollowedApiController::class, 'acceptFollowRequest']);
    Route::post('/reject-follow-request/{id}', [UserFollowedApiController::class, 'rejectFollowRequest']);
    Route::post('/cancel-follow-request/{id}', [UserFollowedApiController::class, 'cancelFollow']);
    Route::post('/remove-follow-requests/{id}', [UserFollowedApiController::class, 'removeFollow']);

    // User Blocked
    Route::get('/blocked-users', [UserBlockedApiController::class, 'usersBlocked']);
    Route::post('/user-block', [UserBlockedApiController::class, 'blockRequest']);
    Route::post('/user-unblock', [UserBlockedApiController::class, 'removeBlock']);

    // User Reports
    Route::get('/users-reported', [UserReportedApiController::class, 'usersReported']);
    Route::post('/user-report', [UserReportedApiController::class, 'reportUser']);

    // User Report Reasons
    Route::get('/report-reasons/{type}', [UserReportedTypeApiController::class, 'index']);

    // Talk Report
    Route::post('/talk-report', [TalkReportedApiController::class, 'reportTalk']);

    // Static Professions
    Route::apiResource('static-professions', StaticProfessionsApiController::class);
    Route::get('get-profession', [StaticProfessionsApiController::class, 'getProfession']);

    // Searches
    Route::get('search-talks', [SearchesApiController::class, 'searchTalks']);
    Route::get('get-talk/{talk}', [SearchesApiController::class, 'getTalk']);
    Route::get('search-users', [SearchesApiController::class, 'searchUsers']);

    // Profil Payout Methods
    Route::apiResource('profile-payout-methods', PayoutsMethodsApiController::class);
    Route::get('user-payout-methods', [PayoutsMethodsApiController::class, 'userPayoutMethods']);
    Route::post('set-profile-payout-methods', [PayoutsMethodsApiController::class, 'setPayoutMethodToUser']);

    // Profil Cvs
    Route::apiResource('profile-cvs', ProfilCvApiController::class);
    Route::get('/profile-cvs/edit/{id}', [ProfilCvApiController::class, 'editProfileCv']);
    Route::get('/profile-user-cvs', [ProfilCvApiController::class, 'userCv']);
    Route::post('/profile-user-cvs', [ProfilCvApiController::class, 'userCv']);
    Route::post('/profile-cvs-title', [ProfilCvApiController::class, 'editProfileCsvTitle']);
    Route::post('/profile-cvs-company', [ProfilCvApiController::class, 'editProfileCsvCompany']);
    Route::post('/profile-cvs-location', [ProfilCvApiController::class, 'editProfileCsvLocation']);
    Route::post('/profile-cvs-start-date', [ProfilCvApiController::class, 'editProfileCsvStartDate']);
    Route::post('/profile-cvs-end-date', [ProfilCvApiController::class, 'editProfileCsvEndDate']);
    Route::post('/profile-cvs-work-here', [ProfilCvApiController::class, 'editProfileCsvWorkHere']);

    // Languages
    Route::get('languages', [LanguagesApiController::class, 'index']);
    Route::get('language', [LanguagesApiController::class, 'show']);
    Route::post('language', [LanguagesApiController::class, 'update']);

    // Countries
    Route::post('countries', [CountriesApiController::class, 'index']);
    Route::get('countries', [VATController::class, 'index']);

    // Payout Invoices
    Route::apiResource('payouts', PayoutsApiController::class)->except('show');
    Route::get('payouts/current-earnings', [PayoutsApiController::class, 'currentEarnings'])->name('payouts.current.earnings');
    Route::get('payouts/{payout:id}', [PayoutsApiController::class, 'show'])->name('payouts.show');
    Route::post('payouts/{payout}/send-payout-summary', [PayoutsApiController::class, 'sendPayoutsMail'])->name('payouts.email.summary');
    Route::get('user-payouts', [PayoutsApiController::class, 'userPayoutData']);

    // Availabilities
    Route::get('teacher-availability/{id}', [AvailabilityApiController::class, 'getTeacherAvailability']);
    Route::get('supplier-availabilities/{id}', [AvailabilityApiController::class, 'getSupplierAvailability']);
    Route::post('talk-availability/{id}', [AvailabilityApiController::class, 'getTalkAvailability']);

    // Billing Addresses
    Route::get('/user-accounting', [BillingAddressApiController::class, 'userAccounting']);

    // Bookings
    Route::get('/user-bookings', [BookingsApiController::class, 'getLoggedUserBookings'])->name('user-bookings');
    Route::get('/user-bookings-data/{date}', [BookingsApiController::class, 'getBookings'])->name('user-bookings-data');
    Route::post('/user-last-booking-data', [BookingsApiController::class, 'getUserLastBooking'])->name('user-last-booking-data');
    Route::post('/user-first-upcoming-booking', [BookingsApiController::class, 'getUserFirstUpcomingBooking'])->name('user-first-upcoming-booking');
    Route::get('/booking-data/{id}', [BookingsApiController::class, 'getBookingData'])->name('user-bookings-data');
    Route::post('/future-bookings/{id}', [BookingsApiController::class, 'getFutureBookings'])->name('future-bookings');
    Route::post('/cancel-booking/{id}', [BookingsApiController::class, 'cancelBooking'])->name('cancel-booking');
    Route::post('/postpone-booking/{id}', [BookingsApiController::class, 'postponeBooking'])->name('postpone-booking');
    Route::post('/set-booking-notification', [BookingsApiController::class, 'setBookingNotification'])->name('set-booking-notification');
    Route::post('/set-booking-message', [BookingsApiController::class, 'setBookingMessage'])->name('set-booking-message');
    Route::post('/teacher-available-extensions', [BookingsApiController::class, 'getAvailableExtensions']);
    Route::get('/call-extension/{id}/{time}', [BookingsApiController::class, 'makeCallExtension']);
    Route::post('/book-extension', [BookingsApiController::class, 'bookExtension']);
    Route::apiResource('bookings', BookingsApiController::class);

    // Calls Cancellation Reasons
    Route::get('calls-cancellation-reasons', [CallsCancellationReasonApiController::class, 'index']);

    // Talks
    Route::post('/talks/media', [TalksApiController::class, 'storeMedia'])->name('talks.storeMedia');
    Route::post('/talk-details-feedback/{talkId}', [TalksApiController::class, 'talkDetailsWithFeedback'])->name('talk-details-feedback');
    Route::post('/teacher-talks/{teacherId}', [TalksApiController::class, 'teacherTalks'])->name('teacher-talks');
    Route::post('/pause-talk/{talkId}', [TalksApiController::class, 'pauseTalk'])->name('pause-talk');
    Route::post('/unpause-talk/{talkId}', [TalksApiController::class, 'unpauseTalk'])->name('unpause-talk');
    Route::get('/talks/{category}/{subcategory}', [TalksApiController::class, 'searchTalksByCategory'])->name('talks.category-subcategory');
    Route::get('/talks-search/{category}/{subcategory?}', [TalksApiController::class, 'getTalkSearch'])->name('talks-search.category-subcategory');
    Route::get('/check-active-filters/{category?}/{subcategory?}/{favorites?}', [TalksApiController::class, 'checkActiveFilters'])->name('check-active-filters');
    Route::apiResource('talks', TalksApiController::class);

    // Feedback
    Route::post('feedback/media', [FeedbackApiController::class, 'storeMedia'])->name('feedback.storeMedia');
    Route::get('user-feedback-rating', [FeedbackApiController::class, 'getRating'])->name('feedback.user-feedback-rating');
    Route::post('teacher-feedback', [FeedbackApiController::class, 'getTeacherRating'])->name('feedback.teacher-feedback');
    Route::post('talk-feedback', [FeedbackApiController::class, 'getTalkRating'])->name('feedback.talk-feedback');
    Route::apiResource('feedback', FeedbackApiController::class);
    Route::get('get-talk-reviews/{talk:id}', [TalksApiController::class, 'getTalkReviews']);

    // Application Feedback
    Route::get('app-feedback', [AppFeedbackApiController::class, 'appFeedback'])->name('app-feedback');
    Route::post('send-feedback', [AppFeedbackApiController::class, 'sendFeedback'])->name('app-feedback.send-feedback');

    // User Api section
    Route::get('/user-booking-amount', [UserApiController::class, 'getTotalBookingAmount']);
    Route::get('/user-booking-amount-monthly', [UserApiController::class, 'getTotalBookingAmountMonthly']);
    Route::get('/user-booking-amount-current-month', [UserApiController::class, 'getCurrentMonthPayout']);
    Route::post('/user-bookings-requested-month', [UserApiController::class, 'getRequestedMonthPayout']);
    Route::post('/user-payout-email', [UserApiController::class, 'monthlyPayoutEmailInvoice']);
    Route::post('/user-suggestions', [UserApiController::class, 'getSuggestions']);
    Route::post('/user-update-cv', [UserApiController::class, 'editProfileCV']);
    Route::post('/user-update-language', [UserApiController::class, 'editProfileLanguage']);
    Route::post('/user-update-profession', [UserApiController::class, 'editProfileProfession']);

    Route::post('/remove-suggestion/{id}', [UserApiController::class, 'dontShowAgainUser']);
    Route::post('/test-profile-photo', [UserApiController::class, 'detect_safe_search']);
    Route::post('/edit-profile-photo', [UserApiController::class, 'editProfilePhoto']);
    Route::post('/edit-profile-name', [UserApiController::class, 'editProfileName']);
    Route::post('/edit-profile-username', [UserApiController::class, 'editProfileUsername']);
    Route::post('/edit-profile-name-and-username', [UserApiController::class, 'editProfileNameAndUsername']);
    Route::post('/edit-profile-website', [UserApiController::class, 'editProfileWebsite']);
    Route::post('/edit-profile-biography', [UserApiController::class, 'editProfileBiography']);
    Route::post('/edit-profile-video', [UserApiController::class, 'editProfileVideo']);
    Route::post('/edit-profile-private', [UserApiController::class, 'editProfilePrivateStatus']);
    Route::post('/edit-profile-email', [UserApiController::class, 'editProfileEmail']);
    Route::post('/edit-profile-password', [UserApiController::class, 'editProfilePassword']);
    Route::post('/remove-user-image', [UserApiController::class, 'removeUserProfilePicture']);
    Route::post('/update-ios-voip-token', [UserApiController::class, 'updateIOSVoipToken']);
    Route::post('/country-of-residence', [UserApiController::class, 'updateCountryOfResidence'])->name('country-of-residence.update');
    Route::post('/delete-user', [UserApiController::class, 'deleteUser']);
    Route::post('/restore-user/{user}', [UserApiController::class, 'restoreUser'])->withoutMiddleware('auth:api');
    Route::post('/apple-account-notification', [UserApiController::class, 'appleAccountNotification'])->withoutMiddleware('auth:api');

    // Join The Club section
    Route::post('/join-the-club-start', [JoinTheClubApiController::class, 'joinTheClubStart']);
    Route::get('/join-the-club-availabilities', [JoinTheClubApiController::class, 'getUserAvailability'])->name('jtc_availabilities');
    Route::get('/join-the-club-availabilities', [JoinTheClubApiController::class, 'getUserAvailability']);
    Route::post('/join-the-club-availability', [JoinTheClubApiController::class, 'joinTheClubAvailability']);
    Route::delete('/join-the-club-delete-availability/{id}', [JoinTheClubApiController::class, 'joinTheClubDeleteAvailability']);
    Route::post('/join-the-club-accounting', [JoinTheClubApiController::class, 'joinTheClubAccounting']);
    Route::get('/join-the-club-completed', [JoinTheClubApiController::class, 'joinTheClubAvailabilityCompleted']);
    Route::post('/jtc/complete', [JoinTheClubApiController::class, 'joinTheClubComplete']);

    // User Bookmarked Talks
    Route::apiResource('user-bookmarked-talks', UserBookmarkedTalksApiController::class);
    Route::post('unfollow-talk', [UserBookmarkedTalksApiController::class, 'unfollowTalk']);
    Route::post('unfollow-single-talk', [UserBookmarkedTalksApiController::class, 'unfollowSingleTalk']);
    Route::get('get-talk-user/{talkId}', [TalksApiController::class, 'getTalkUserData']);

    // Notifications section
    Route::get('/get-notifications', [NotificationsApiController::class, 'getNotifications']);
    Route::get('/notifications-unread-count', [NotificationsApiController::class, 'countUnreadNotifications']);
    Route::post('/send-notifications', [NotificationsApiController::class, 'sendNotification']);
    Route::post('/seen-notifications', [NotificationsApiController::class, 'seenNotification']);
    Route::post('/seen-all-notifications', [NotificationsApiController::class, 'seenAllNotifications']);
    Route::patch('/notification/{notification:id}', [NotificationsApiController::class, 'read']);
    Route::post('/read-all-notifications', [NotificationsApiController::class, 'readAll']);
    Route::delete('/notification/{notification:id}', [NotificationsApiController::class, 'destroy']);
    Route::delete('/delete-all-notifications', [NotificationsApiController::class, 'destroyAll']);

    Route::get('/get-notifications-settings', [NotificationSettingsController::class, 'index']);
    Route::post('/set-notifications-settings', [NotificationSettingsController::class, 'store']);

    Route::get('/user-additional-info', [UserAdditionalInfoAPIController::class, 'index']);
    Route::post('/user-additional-info', [UserAdditionalInfoAPIController::class, 'store']);

    // Talk Categories
//    Route::apiResource('talk-categories', TalkCategoriesApiController::class);
    Route::any('talk-categories', [TalkCategoriesApiController::class, 'getTalkCategories']);
    Route::post('talk-subcategories', [TalkCategoriesApiController::class, 'getTalkSubcategories']);

    // Profile Verification
    Route::get('user-verifications', [ProfileVerificationApiController::class, 'profileVerification']);
    Route::post('add-profile-verification', [ProfileVerificationApiController::class, 'addProfileVerification']);

    Route::post('add-card', [CreditCardController::class, 'addCard']);

    Route::post('setup-intent', [CreditCardController::class, 'setupIntent']);

    Route::get('card-list', [CreditCardController::class, 'cardList']);
    Route::post('delete-card', [CreditCardController::class, 'deleteCard']);

    Route::post('add-paypal-transaction', [WalletController::class, 'addPayPalTransaction']);

    Route::post('paypal-create-order', [PayPalController::class, 'paypalCreateOrder']);
    Route::post('paypal-capture-order', [PayPalController::class, 'paypalCaptureOrder']);
    Route::post('paypal-authorize-order', [PayPalController::class, 'paypalAuthorizeOrder']);
    Route::post('paypal-payout-connect', [PayPalController::class, 'paypalPayoutConnect']);
    Route::post('store-paypal-data', [PayPalController::class, 'paypalStoreData']);

    Route::post('connect-calendar', [CalendarController::class, 'connect']);
    Route::post('disconnect-calendar/{calendar_id}', [CalendarController::class, 'disconnect']);
    Route::get('calendars', [CalendarController::class, 'calendars']);
    // Route::get('events/{calendar:id}', [CalendarController::class, 'events']);
    // Route::post('event/{calendar:id}', [CalendarController::class, 'storeEvent']);
    // Route::put('event/{calendar:id}/{event_id}', [CalendarController::class, 'updateEvent']);
    // Route::patch('event/{calendar:id}/{event_id}', [CalendarController::class, 'patchEvent']);
    Route::post('calendar-account-state', [CalendarController::class, 'accountState']);
    Route::post('calendar-state', [CalendarController::class, 'calendarState']);
    Route::post('set-primary-calendar/{calendar}', [CalendarController::class, 'setPrimaryCalendar']);
    Route::post('calendar-watch/{calendar:calendar_id}', [CalendarController::class, 'watch'])->name('calendar.watch')->withoutMiddleware(['auth:api']);

    Route::post('update-default-card', [CreditCardController::class, 'updateDefaultCard']);
    Route::post('deposite-in-wallet', [WalletController::class, 'depositeWallet']);
    Route::get('get-wallet-balance', [WalletController::class, 'getWalletBalance']);

//    Route::get('stripe-ouath', 'StripeOauthController@stripeOauth');

    Route::post('charge-wallet', [WalletController::class, 'ChargeFromWallet']);

    Route::post('add-book-transaction', [WalletController::class, 'addBookTransaction']);

    Route::get('get-transaction-history', [WalletController::class, 'getTransactionHistory']);

    Route::get('get-payment-methods', [WalletController::class, 'getPaymentMethods']);
    Route::post('set-payment-methods', [WalletController::class, 'setPaymentMethods']);

    Route::get('payment-methods', [PaymentMethodController::class, 'index']);
    Route::post('payment-methods', [PaymentMethodController::class, 'store']);
    Route::patch('payment-methods/update', [PaymentMethodController::class, 'update']);
    Route::delete('payment-methods/delete', [PaymentMethodController::class, 'destroy']);

    Route::post('cancel-call', [WalletController::class, 'cancelCall']);
    // Marko New Payment logic
//    Route::post('charge-customer', [PaymentController::class, 'chargeCustomer']);

    // Route::get('vats', [\App\Http\Controllers\Api\V1\Admin\VATController::class, 'index']);
    // Route::post('country-of-residence', [\App\Http\Controllers\Api\V1\Admin\VATController::class, 'countryOfResidence']);
});

Route::group(['prefix' => 'v1/static', 'as' => 'api.'], function () {
    // Custom Page
    Route::get('{slug}', [PageApiController::class, 'dynamic_page']);
});

/*
|--------------------------------------------------------------------------
| Twilio / Socket Routes (merged from talkila.twiliobackend)
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'api', 'middleware' => ['auth:api']], function () {
    Route::post('/socket-event', [\App\Http\Controllers\TwilioController::class, 'handleEvents']);
    Route::post('/room-status', [\App\Http\Controllers\TwilioController::class, 'roomStatus']);
    Route::post('/network-quality', [\App\Http\Controllers\SocketNetworkQualityController::class, 'store']);
    Route::post('/user-rooms', [\App\Http\Controllers\TwilioController::class, 'userRooms']);
});
