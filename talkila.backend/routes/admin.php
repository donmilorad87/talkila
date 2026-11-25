<?php

use App\Http\Controllers\Admin\AdyenPaymentController;
use App\Http\Controllers\Admin\AuditLogsController;
use App\Http\Controllers\Admin\AvailabilityController;
use App\Http\Controllers\Admin\BillingAddressController;
use App\Http\Controllers\Admin\BookingsController;
use App\Http\Controllers\Admin\BookingsPaymentDetailsController;
use App\Http\Controllers\Admin\BookingsPayoutsController;
use App\Http\Controllers\Admin\CallsCancellationReasonController;
use App\Http\Controllers\Admin\CountriesController;
use App\Http\Controllers\Admin\DisposalDomainsController;
use App\Http\Controllers\Admin\DisposalEmailsController;
use App\Http\Controllers\Admin\EmailHistoriesLogController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\FinanceCurrenciesController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LanguagesController;
use App\Http\Controllers\Admin\LanguagesProfilController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PayoutController;
use App\Http\Controllers\Admin\PayoutsController;
use App\Http\Controllers\Admin\PayoutsMethodsController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\ProfilCvController;
use App\Http\Controllers\Admin\ProfileVerificationController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SearchesController;
use App\Http\Controllers\Admin\SocketCallsProtocolController;
use App\Http\Controllers\Admin\SocketParticipantController;
use App\Http\Controllers\Admin\SocketRoomController;
use App\Http\Controllers\Admin\StaticBlockedUserController;
use App\Http\Controllers\Admin\StaticForbiddenNamesController;
use App\Http\Controllers\Admin\StaticMetricsController;
use App\Http\Controllers\Admin\StaticProfessionsController;
use App\Http\Controllers\Admin\SuggestionsHomeScreenController;
use App\Http\Controllers\Admin\SystemLoginController;
use App\Http\Controllers\Admin\TalkCategoriesController;
use App\Http\Controllers\Admin\TalkController;
use App\Http\Controllers\Admin\TalkSubcategoriesController;
use App\Http\Controllers\Admin\UserBlockedController;
use App\Http\Controllers\Admin\UserBookmarkedTalksController;
use App\Http\Controllers\Admin\UserDontShowAgainController;
use App\Http\Controllers\Admin\UserFollowedController;
use App\Http\Controllers\Admin\UserImageVerificationController;
use App\Http\Controllers\Admin\UserReportedController;
use App\Http\Controllers\Admin\UserReportTypesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\UserVisitedController;
use App\Http\Controllers\Admin\VATController;

/**
 * Admin Routes.
 */
Route::group(['prefix' => '', 'as' => 'admin.'], function () {
    Route::get('/adminIndex', [HomeController::class, 'index'])->name('home');
    // Permissions
    Route::delete('permissions/destroy', [PermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
    Route::post('permissions/parse-csv-import', [PermissionsController::class, 'parseCsvImport'])->name('permissions.parseCsvImport');
    Route::post('permissions/process-csv-import', [PermissionsController::class, 'processCsvImport'])->name('permissions.processCsvImport');
    Route::resource('permissions', PermissionsController::class);

    // Roles
    Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.massDestroy');
    Route::post('roles/parse-csv-import', [RolesController::class, 'parseCsvImport'])->name('roles.parseCsvImport');
    Route::post('roles/process-csv-import', [RolesController::class, 'processCsvImport'])->name('roles.processCsvImport');
    Route::resource('roles', RolesController::class);

    // Users
    Route::delete('users/destroy', [UsersController::class, 'massDestroy'])->name('users.massDestroy');
    Route::post('users/parse-csv-import', [UsersController::class, 'parseCsvImport'])->name('users.parseCsvImport');
    Route::post('users/process-csv-import', [UsersController::class, 'processCsvImport'])->name('users.processCsvImport');
    Route::get('users/affiliate-users', [UsersController::class, 'affiliateUsers'])->name('users.affiliateUsers');
    Route::get('users/affiliate-action', [UsersController::class, 'actionAffiliate'])->name('users.actionAffiliate');
    Route::resource('users', UsersController::class);

    // User Blockeds
    Route::delete('users-blocked/destroy', [UserBlockedController::class, 'massDestroy'])->name('users-blocked.massDestroy');
    Route::post('users-blocked/parse-csv-import', [UserBlockedController::class, 'parseCsvImport'])->name('users-blocked.parseCsvImport');
    Route::post('users-blocked/process-csv-import', [UserBlockedController::class, 'processCsvImport'])->name('users-blocked.processCsvImport');
    Route::resource('users-blocked', UserBlockedController::class);
    Route::get('user-blocked/{user:id}', [UserBlockedController::class, 'userBlocked'])->name('user-blocked.userBlocked');
    Route::post('block-user/{id}', [UserBlockedController::class, 'blockUser'])->name('block-user.blockUser');

    // Audit Logs
    Route::resource('audit-logs', AuditLogsController::class, ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // User Followeds
    Route::delete('users-followed/destroy', [UserFollowedController::class, 'massDestroy'])->name('users-followed.massDestroy');
    Route::post('users-followed/parse-csv-import', [UserFollowedController::class, 'parseCsvImport'])->name('users-followed.parseCsvImport');
    Route::post('users-followed/process-csv-import', [UserFollowedController::class, 'processCsvImport'])->name('users-followed.processCsvImport');
    Route::resource('users-followed', UserFollowedController::class);
    Route::get('user-followed/{id}', [UserFollowedController::class, 'userFolloweds'])->name('user-followed.userFolloweds');

    // User Dont Show Agains
    Route::delete('user-dont-show-against/destroy', [UserDontShowAgainController::class, 'massDestroy'])->name('user-dont-show-against.massDestroy');
    Route::post('user-dont-show-against/parse-csv-import', [UserDontShowAgainController::class, 'parseCsvImport'])->name('user-dont-show-against.parseCsvImport');
    Route::post('user-dont-show-against/process-csv-import', [UserDontShowAgainController::class, 'processCsvImport'])->name('user-dont-show-against.processCsvImport');
    Route::resource('user-dont-show-against', UserDontShowAgainController::class);
    Route::get('user-dont-show-against/dt/{id}', [UserDontShowAgainController::class, 'userDontShowAgains'])->name('user-dont-show-against.userDontShowAgainst');

    // User Images Verification
    Route::get('user-image-verification', [UserImageVerificationController::class, 'index'])->name('user-image-verification.index');
    Route::post('user-image-verification/approve', [UserImageVerificationController::class, 'approve'])->name('user-image-verification.approve');
    Route::post('user-image-verification/skip', [UserImageVerificationController::class, 'skip'])->name('user-image-verification.skip');
    Route::post('user-image-verification/disapprove', [UserImageVerificationController::class, 'disapprove'])->name('user-image-verification.disapprove');

    // Socket Calls Protocol
    Route::resource('socket-calls-protocol', SocketCallsProtocolController::class);

    // Socket Participants
    Route::resource('socket-participants', SocketParticipantController::class);

    // Socket Rooms
    Route::get('socket-rooms/talks-select-list', [SocketRoomController::class, 'talksSelectList'])->name('socket-rooms.talksSelectList');
    Route::resource('socket-rooms', SocketRoomController::class);

    // Store Bookings Payment Details
    Route::delete('bookings-payment-details/destroy', [BookingsPaymentDetailsController::class, 'massDestroy'])->name('bookings-payment-details.massDestroy');
    Route::post('bookings-payment-details/paymentStore', [BookingsPaymentDetailsController::class, 'paymentStore'])->name('bookings-payment-details.paymentStore');
    Route::resource('bookings-payment-details', BookingsPaymentDetailsController::class);

    // System Logins
    Route::delete('system-logins/destroy', [SystemLoginController::class, 'massDestroy'])->name('system-logins.massDestroy');
    Route::post('system-logins/parse-csv-import', [SystemLoginController::class, 'parseCsvImport'])->name('system-logins.parseCsvImport');
    Route::post('system-logins/process-csv-import', [SystemLoginController::class, 'processCsvImport'])->name('system-logins.processCsvImport');
    Route::resource('system-logins', SystemLoginController::class);

    // Static Professions
    Route::delete('static-professions/destroy', [StaticProfessionsController::class, 'massDestroy'])->name('static-professions.massDestroy');
    Route::post('static-professions/parse-csv-import', [StaticProfessionsController::class, 'parseCsvImport'])->name('static-professions.parseCsvImport');
    Route::post('static-professions/process-csv-import', [StaticProfessionsController::class, 'processCsvImport'])->name('static-professions.processCsvImport');
    Route::resource('static-professions', StaticProfessionsController::class);

    // Static Reviews
//    Route::delete('static-reviews/destroy', 'StaticReviewsController@massDestroy')->name('static-reviews.massDestroy');
//    Route::resource('static-reviews', 'StaticReviewsController');

    // Static Forbidden Names
    Route::delete('static-forbidden-names/destroy', [StaticForbiddenNamesController::class, 'massDestroy'])->name('static-forbidden-names.massDestroy');
    Route::post('static-forbidden-names/parse-csv-import', [StaticForbiddenNamesController::class, 'parseCsvImport'])->name('static-forbidden-names.parseCsvImport');
    Route::post('static-forbidden-names/process-csv-import', [StaticForbiddenNamesController::class, 'processCsvImport'])->name('static-forbidden-names.processCsvImport');
    Route::resource('static-forbidden-names', StaticForbiddenNamesController::class);

    // Static Blocked Users
    Route::delete('static-blocked-users/destroy', [StaticBlockedUserController::class, 'massDestroy'])->name('static-blocked-users.massDestroy');
    Route::post('static-blocked-users/parse-csv-import', [StaticBlockedUserController::class, 'parseCsvImport'])->name('static-blocked-users.parseCsvImport');
    Route::post('static-blocked-users/process-csv-import', [StaticBlockedUserController::class, 'processCsvImport'])->name('static-blocked-users.processCsvImport');
    Route::resource('static-blocked-users', StaticBlockedUserController::class);

    // Searches
    Route::delete('searches/destroy', [SearchesController::class, 'massDestroy'])->name('searches.massDestroy');
    Route::post('searches/parse-csv-import', [SearchesController::class, 'parseCsvImport'])->name('searches.parseCsvImport');
    Route::post('searches/process-csv-import', [SearchesController::class, 'processCsvImport'])->name('searches.processCsvImport');
    Route::resource('searches', SearchesController::class);
    Route::get('user-search/{id}', [SearchesController::class, 'userSearches'])->name('user-search.userSearches');

    // Profil Payout Methods
    Route::delete('profile-payout-methods/destroy', [PayoutsMethodsController::class, 'massDestroy'])->name('profile-payout-methods.massDestroy');
    Route::post('profile-payout-methods/parse-csv-import', [PayoutsMethodsController::class, 'parseCsvImport'])->name('profile-payout-methods.parseCsvImport');
    Route::post('profile-payout-methods/process-csv-import', [PayoutsMethodsController::class, 'processCsvImport'])->name('profile-payout-methods.processCsvImport');
    Route::resource('profile-payout-methods', PayoutsMethodsController::class);
    Route::get('user-payout-methods/{id}', [PayoutsMethodsController::class, 'userPayoutMethod'])->name('user-payout-methods.userPayoutMethod');

    Route::get('adyen-payment-methods', [AdyenPaymentController::class, 'adyenPaymentMethods'])->name('adyen-payment-methods');
    Route::post('adyen-make-payment', [AdyenPaymentController::class, 'adyenMakePayment'])->name('adyen-make-payment');
    Route::post('adyen-additional-details', [AdyenPaymentController::class, 'adyenAdditionalDetails'])->name('adyen-additional-details');

    // !!!IMPORTANT!!! Just for testing This need to be removed and only can be called via system not via route call
    // Adyen WebHook UserName: adyenTalkilaNotification, Password: GX@24#Em$CcRzUz, HMAC Key: 41740B6E9B384390023F9C4925ED3C58820FEFBF7FB14B6E4AD835C90FF740A5
    Route::get('adyen-refund-payment-tmp', [AdyenPaymentController::class, 'adyenRefundPayment'])->name('adyen-refund-payment-tmp');

    // Profil Cvs
    Route::delete('profile-cvs/destroy', [ProfilCvController::class, 'massDestroy'])->name('profile-cvs.massDestroy');
    Route::post('profile-cvs/parse-csv-import', [ProfilCvController::class, 'parseCsvImport'])->name('profile-cvs.parseCsvImport');
    Route::post('profile-cvs/process-csv-import', [ProfilCvController::class, 'processCsvImport'])->name('profile-cvs.processCsvImport');
    Route::resource('profile-cvs', ProfilCvController::class);
    Route::get('user-profile-cvs/{id}', [ProfilCvController::class, 'userProfilCvs'])->name('user-profile-cvs.userProfilCvs');

    // Languages
    Route::delete('languages/destroy', [LanguagesController::class, 'massDestroy'])->name('languages.massDestroy');
    Route::resource('languages', LanguagesController::class);

    // Countries
    Route::delete('countries/destroy', [CountriesController::class, 'massDestroy'])->name('countries.massDestroy');
    Route::post('countries/parse-csv-import', [CountriesController::class, 'parseCsvImport'])->name('countries.parseCsvImport');
    Route::post('countries/process-csv-import', [CountriesController::class, 'processCsvImport'])->name('countries.processCsvImport');
    Route::resource('countries', CountriesController::class);

    // Languages Profils
    Route::delete('languages-profils/destroy', [LanguagesProfilController::class, 'massDestroy'])->name('languages-profils.massDestroy');
    Route::resource('languages-profils', LanguagesProfilController::class);

    // Payout Invoices
    Route::delete('payout-invoices/destroy', [PayoutsController::class, 'massDestroy'])->name('payout-invoices.massDestroy');
    Route::post('payout-invoices/parse-csv-import', [PayoutsController::class, 'parseCsvImport'])->name('payout-invoices.parseCsvImport');
    Route::post('payout-invoices/process-csv-import', [PayoutsController::class, 'processCsvImport'])->name('payout-invoices.processCsvImport');
    Route::resource('payout-invoices', PayoutsController::class)->except('show');
    Route::get('payout-invoices/fetch-monthly-payouts', [PayoutsController::class, 'fetchPayoutsByMonth'])->name('payout-invoices.fetch-monthly-payouts');
    Route::get('payout-invoices/fetch-suppliers', [PayoutsController::class, 'fetchSuppliers'])->name('payout-invoices.fetch-suppliers');
    Route::get('payout-invoices/fetch-suppliers-by-month', [PayoutsController::class, 'fetchSuppliersByMonth'])->name('payout-invoices.fetch-suppliers-by-month');
    Route::get('payout-invoices/{payout}/fetch-supplier', [PayoutsController::class, 'fetchSupplierPayoutsByCountry'])->name('payout-invoices.fetch-supplier-payouts');
    Route::get('payout-invoices/{payout}/fetch-supplier-bookings', [PayoutsController::class, 'fetchSupplierBookings'])->name('payout-invoices.fetch-supplier-bookings');
    Route::get('payout-invoices/details/{month}', [PayoutsController::class, 'details'])->name('payout-invoices.details');
    Route::post('payout-invoices/pay/{payout}', [PayoutsController::class, 'pay'])->name('payout-invoices.payment');
    Route::get('payout-invoices/{payout}', [PayoutsController::class, 'show'])->name('payout-invoices.show');

    // Payout Currencies
    Route::delete('payout-currencies/destroy', [FinanceCurrenciesController::class, 'massDestroy'])->name('payout-currencies.massDestroy');
    Route::resource('payout-currencies', FinanceCurrenciesController::class);

    // Email Histories
    Route::get('email-histories/show-user-emails/{id}', [EmailHistoriesLogController::class, 'showUserEmails'])->name('email-histories.showUserEmails');

    // Disposal Domains
    Route::delete('disposal-domains/destroy', [DisposalDomainsController::class, 'massDestroy'])->name('disposal-domains.massDestroy');
    Route::resource('disposal-domains', DisposalDomainsController::class);

    // Disposal Emails
    Route::delete('disposal-emails/destroy', [DisposalEmailsController::class, 'massDestroy'])->name('disposal-emails.massDestroy');
    Route::resource('disposal-emails', DisposalEmailsController::class);

    // Availabilities
    Route::delete('availabilities/destroy', [AvailabilityController::class, 'massDestroy'])->name('availabilities.massDestroy');
    Route::post('availabilities/parse-csv-import', [AvailabilityController::class, 'parseCsvImport'])->name('availabilities.parseCsvImport');
    Route::post('availabilities/process-csv-import', [AvailabilityController::class, 'processCsvImport'])->name('availabilities.processCsvImport');
    Route::resource('availabilities', AvailabilityController::class);

    // Billing Addresses
    Route::delete('billing-addresses/destroy', [BillingAddressController::class, 'massDestroy'])->name('billing-addresses.massDestroy');
    Route::post('billing-addresses/parse-csv-import', [BillingAddressController::class, 'parseCsvImport'])->name('billing-addresses.parseCsvImport');
    Route::post('billing-addresses/process-csv-import', [BillingAddressController::class, 'processCsvImport'])->name('billing-addresses.processCsvImport');
    Route::get('user-billing-addresses/{id}', [BillingAddressController::class, 'userBillingAddresses'])->name('user-billing-addresses.userBillingAddresses');
    Route::resource('billing-addresses', BillingAddressController::class);

    // Bookings
    Route::delete('bookings/destroy', [BookingsController::class, 'massDestroy'])->name('bookings.massDestroy');
    Route::post('bookings/parse-csv-import', [BookingsController::class, 'parseCsvImport'])->name('bookings.parseCsvImport');
    Route::post('bookings/process-csv-import', [BookingsController::class, 'processCsvImport'])->name('bookings.processCsvImport');
    Route::post('bookings/storeBooking', [BookingsController::class, 'storeBooking'])->name('bookings.storeBooking');
    Route::resource('admin/bookings', BookingsController::class);

    Route::get('user-bookings/{id}', [BookingsController::class, 'userBookings'])->name('user-bookings.userBookings');

    // Calls Cancellation Reasons
    Route::delete('calls-cancellation-reasons/destroy', [CallsCancellationReasonController::class, 'massDestroy'])->name('calls-cancellation-reasons.massDestroy');
    Route::post('calls-cancellation-reasons/parse-csv-import', [CallsCancellationReasonController::class, 'parseCsvImport'])->name('calls-cancellation-reasons.parseCsvImport');
    Route::post('calls-cancellation-reasons/process-csv-import', [CallsCancellationReasonController::class, 'processCsvImport'])->name('calls-cancellation-reasons.processCsvImport');
    Route::resource('calls-cancellation-reasons', CallsCancellationReasonController::class);

    // Bookings Payout Invoices
    Route::delete('bookings-payout-invoices/destroy', [BookingsPayoutsController::class, 'massDestroy'])->name('bookings-payout-invoices.massDestroy');
    Route::post('bookings-payout-invoices/parse-csv-import', [BookingsPayoutsController::class, 'parseCsvImport'])->name('bookings-payout-invoices.parseCsvImport');
    Route::post('bookings-payout-invoices/process-csv-import', [BookingsPayoutsController::class, 'processCsvImport'])->name('bookings-payout-invoices.processCsvImport');
    Route::resource('bookings-payout-invoices', BookingsPayoutsController::class);

    // Talks
    Route::delete('talks/destroy', [TalkController::class, 'massDestroy'])->name('talks.massDestroy');
    Route::post('talks/media', [TalkController::class, 'storeMedia'])->name('talks.storeMedia');
    Route::post('talks/ckmedia', [TalkController::class, 'storeCKEditorImages'])->name('talks.storeCKEditorImages');
    Route::post('talks/parse-csv-import', [TalkController::class, 'parseCsvImport'])->name('talks.parseCsvImport');
    Route::post('talks/process-csv-import', [TalkController::class, 'processCsvImport'])->name('talks.processCsvImport');
    Route::get('user-talks/{id}', [TalkController::class, 'userTalks'])->name('user-talks.userTalks');
    Route::resource('talks', TalkController::class);

    // Feedback
    Route::delete('feedback/destroy', [FeedbackController::class, 'massDestroy'])->name('feedback.massDestroy');
    Route::post('feedback/media', [FeedbackController::class, 'storeMedia'])->name('feedback.storeMedia');
    Route::post('feedback/ckmedia', [FeedbackController::class, 'storeCKEditorImages'])->name('feedback.storeCKEditorImages');
    Route::post('feedback/parse-csv-import', [FeedbackController::class, 'parseCsvImport'])->name('feedback.parseCsvImport');
    Route::post('feedback/process-csv-import', [FeedbackController::class, 'processCsvImport'])->name('feedback.processCsvImport');
    Route::post('feedback/{id}', [FeedbackController::class, 'updateStatus'])->name('feedback.updateStatus');
    Route::post('feedback-review-update/{id}', [FeedbackController::class, 'updateReviewStatus'])->name('feedback.updateReviewStatus');
    Route::resource('feedback', FeedbackController::class);
    Route::get('user-feedback/{id}', [FeedbackController::class, 'userFeedback'])->name('user-feedback.userFeedback');
    Route::get('waiting-for-approval', [FeedbackController::class, 'waitingForApproval'])->name('waiting-for-approval.waitingForApproval');
    Route::get('feedback-under-review', [FeedbackController::class, 'feedbackUnderReview'])->name('feedback-under-review');
    Route::get('feedback-under-review/{id}', [FeedbackController::class, 'feedbackUnderReviewShow'])->name('feedback-under-review-show');

    // User Report Types
    Route::delete('user-report-types/destroy', [UserReportTypesController::class, 'massDestroy'])->name('user-report-types.massDestroy');
    Route::resource('user-report-types', UserReportTypesController::class);

    // User Reported
    Route::delete('user-reporteds/destroy', [UserReportedController::class, 'massDestroy'])->name('user-reporteds.massDestroy');
    Route::post('user-reporteds/parse-csv-import', [UserReportedController::class, 'parseCsvImport'])->name('user-reporteds.parseCsvImport');
    Route::post('user-reporteds/process-csv-import', [UserReportedController::class, 'processCsvImport'])->name('user-reporteds.processCsvImport');
    Route::resource('user-reporteds', UserReportedController::class);
    Route::get('user-reported/{id}', [UserReportedController::class, 'userReporteds'])->name('user-reported.userReporteds');

    // Static Metrics
    Route::delete('static-metrics/destroy', [StaticMetricsController::class, 'massDestroy'])->name('static-metrics.massDestroy');
    Route::post('static-metrics/parse-csv-import', [StaticMetricsController::class, 'parseCsvImport'])->name('static-metrics.parseCsvImport');
    Route::post('static-metrics/process-csv-import', [StaticMetricsController::class, 'processCsvImport'])->name('static-metrics.processCsvImport');
    Route::resource('static-metrics', StaticMetricsController::class);

    // User Visited
    Route::delete('user-visiteds/destroy', [UserVisitedController::class, 'massDestroy'])->name('user-visiteds.massDestroy');
    Route::post('user-visiteds/parse-csv-import', [UserVisitedController::class, 'parseCsvImport'])->name('user-visiteds.parseCsvImport');
    Route::post('user-visiteds/process-csv-import', [UserVisitedController::class, 'processCsvImport'])->name('user-visiteds.processCsvImport');
    Route::get('user-visited/{id}', [UserVisitedController::class, 'userVisiteds'])->name('user-visited.userVisiteds');
    Route::resource('user-visiteds', UserVisitedController::class);

    // Pages
    Route::delete('cms/destroy', [PageController::class, 'massDestroy'])->name('cms.massDestroy');
    Route::resource('cms', PageController::class);

    // Talk Categories
    Route::delete('talk-categories/destroy', [TalkCategoriesController::class, 'massDestroy'])->name('talk-categories.massDestroy');
    Route::post('talk-categories/parse-csv-import', [TalkCategoriesController::class, 'parseCsvImport'])->name('talk-categories.parseCsvImport');
    Route::post('talk-categories/process-csv-import', [TalkCategoriesController::class, 'processCsvImport'])->name('talk-categories.processCsvImport');
    Route::resource('talk-categories', TalkCategoriesController::class);

    // Talk Subcategories
    Route::delete('talk-subcategories/destroy', [TalkSubcategoriesController::class, 'massDestroy'])->name('talk-subcategories.massDestroy');
    Route::post('talk-subcategories/parse-csv-import', [TalkSubcategoriesController::class, 'parseCsvImport'])->name('talk-subcategories.parseCsvImport');
    Route::post('talk-subcategories/process-csv-import', [TalkSubcategoriesController::class, 'processCsvImport'])->name('talk-subcategories.processCsvImport');
    Route::resource('talk-subcategories', TalkSubcategoriesController::class);

    // Suggestions Home Screen
    Route::delete('suggestions-home-screen/destroy', [SuggestionsHomeScreenController::class, 'massDestroy'])->name('suggestions-home-screen.massDestroy');
    Route::post('suggestions-home-screen/parse-csv-import', [SuggestionsHomeScreenController::class, 'parseCsvImport'])->name('suggestions-home-screen.parseCsvImport');
    Route::post('suggestions-home-screen/process-csv-import', [SuggestionsHomeScreenController::class, 'processCsvImport'])->name('suggestions-home-screen.processCsvImport');
    Route::resource('suggestions-home-screen', SuggestionsHomeScreenController::class);

    // User Bookmarked Talks
    Route::delete('user-bookmarked-talks/destroy', [UserBookmarkedTalksController::class, 'massDestroy'])->name('user-bookmarked-talks.massDestroy');
    Route::post('user-bookmarked-talks/parse-csv-import', [UserBookmarkedTalksController::class, 'parseCsvImport'])->name('user-bookmarked-talks.parseCsvImport');
    Route::post('user-bookmarked-talks/process-csv-import', [UserBookmarkedTalksController::class, 'processCsvImport'])->name('user-bookmarked-talks.processCsvImport');
    Route::resource('user-bookmarked-talks', UserBookmarkedTalksController::class);
    Route::get('user-booked-talks/{id}', [UserBookmarkedTalksController::class, 'userBookmarkedTalks'])->name('user-booked-talks.userBookmarkedTalks');

    //User Verification
    Route::get('profile-verifications', [ProfileVerificationController::class, 'index'])->name('profile-verifications.index');
    Route::get('profile-verifications/{id}', [ProfileVerificationController::class, 'show'])->name('profile-verifications.show');
    Route::post('profile-verifications/approve', [ProfileVerificationController::class, 'approveProfile'])->name('profile-verifications.approve');
    Route::post('profile-verifications/skip', [ProfileVerificationController::class, 'skipProfile'])->name('profile-verifications.skip');
    Route::post('profile-verifications/disapprove', [ProfileVerificationController::class, 'disapproveProfile'])->name('profile-verifications.disapprove');

    Route::resource('vat', VATController::class);
});
