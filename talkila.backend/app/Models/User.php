<?php

namespace App\Models;

use App\Entity\ParticipantStates;
use App\Entity\RoomStates;
use App\Entity\TalkCategory;
use App\Entity\TalkSubcategory;
use App\Entity\TalkTypes;
use App\Http\Controllers\Admin\BookingsController;
use App\Http\Controllers\Api\V1\Admin\NotificationsApiController;
use App\Jobs\NotifyClientTalkCanceled;
use App\Jobs\NotifyTeacherTalkCanceled;
use App\Mail\AccountDeleted;
use App\Mail\BookingCancellationClient;
use App\Mail\BookingCancellationSupplier;
use App\Models\Affiliates\Affiliate;
use App\Models\Affiliates\Subaffiliate;
use App\ModelsApi\StaticProfession;
use App\Notifications\ResetPasswordNotification;
use App\Traits\Serializable;
use Carbon\Carbon;
use File;
use Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;
use Log;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable, HasApiTokens, Billable, Serializable;

    public $table = 'users';

    protected $hidden = [
        'remember_token',
        'password',
        'google_token',
        'facebook_token',
        'apple_token',
    ];

    protected $dates = [
        'email_verified_at',
        'verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'type',
        'state',
        'name',
        'email',
        'email_verified_at',
        'password',
        'visibility',
        'partner_id',
        'partner_user_id',
        'billing_address_id',
        'vat_id',
        'wallet_balance',
        'gender',
        'description',
        'profession',
        'youtube_video',
        'notification_message',
        'profile_picture',
        'profile_picture_tmp',
        'approved',
        'verified',
        'verified_at',
        'verification_token',
        'talk_token',
        'talk_token_used_at',
        'firebase_id',
        'voip_token',
        'timezone',
        'remember_token',
        'deactivation_reason',
        'username',
        'created_at',
        'updated_at',
        'deleted_at',
        'google_token',
        'google_details',
        'facebook_token',
        'facebook_details',
        'apple_token',
        'apple_details',
        'paypal_email',
        'paypal_access_token',
        'paypal_refresh_token',
        'default_payment_method',
        'login_type',
        'device_type',
        'last_language',
        'reviews',
        'ratings',
        'affiliate_revenue_limit_reached',
        'affiliates_valid_until',
        'affiliates_sub_id',
        'affiliates_sub_affiliate_id',
    ];

    protected $casts = [
        'timezone' => 'integer',
    ];

    const TYPE = [
        'client'   => '1',
        'supplier' => '2',
    ];

    const STATE = [
        'not_activated' => '0',
        'approved'      => '1',
        'spam'          => '2',
        'deactivated'   => '3',
    ];

    const VISIBILITY = [
        'open'    => '1',
        'private' => '2',
    ];

    const VERIFIED = [
        '1' => 'not verified',
        '2' => 'verified',
    ];

    const GENDER = [
        '0' => 'not defined',
        '1' => 'male',
        '2' => 'female',
    ];

    const NOTIFICATION_MESSAGE = [
        '0' => 'false',
        '1' => 'true',
    ];

    const LOGIN_TYPE = [
        'standard' => '1',
        'gmail'    => '2',
        'facebook' => '3',
        'apple'    => '4',
    ];

    const API_COLUMNS = [
        'users.id',
        'users.type',
        'users.visibility',
        'users.gender',
        'users.name',
        'users.username',
        'users.email',
        'users.description',
        'users.profession',
        'users.youtube_video',
        // 'users.billing_address_id',
        'users.notification_message',
        'users.notification_sound',
        'users.approved',
        'users.verified',
        'users.partner_id',
    ];

    /**
     * Talk filters.
     */
    public $filters;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        self::created(function (User $user) {
            if (auth()->check()) {
                $user->verified    = 1;
                $user->verified_at = Carbon::now()->format(config('panel.date_format') . ' ' . config('panel.time_format'));
                $user->save();
            } elseif (!$user->verification_token) {
                $token     = Str::random(64);
                $usedToken = User::where('verification_token', $token)->first();

                while ($usedToken) {
                    $token     = Str::random(64);
                    $usedToken = User::where('verification_token', $token)->first();
                }

                $user->verification_token = $token;
                $user->save();

                $registrationRole = config('panel.registration_default_role');

                if (!$user->roles()->get()->contains($registrationRole)) {
                    $user->roles()->attach($registrationRole);
                }
            }

            $billing = BillingAddress::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'countries_id' => Country::GERMANY,
                    'email'        => $user->email,
                    'company_name' => $user->name,
                    'user_id'      => $user->id,
                ]
            );

            $user->billing_address_id = $billing->id;
            $user->save();
        });
    }

    /* Relationship declarations
       ============================== */

    public function userBookmarkedTalks()
    {
        return $this->hasMany(UserBookmarkedTalks::class, 'user_id', 'id');
    }

    public function talks()
    {
        return $this->hasMany(Talk::class, 'teacher_user_id', 'id');
    }

    // Duplicate.
    public function userTalks()
    {
        return $this->hasMany(Talk::class, 'teacher_user_id', 'id');
    }

    public function userUserFolloweds()
    {
        return $this->hasMany(UserFollowed::class, 'user_id', 'id');
    }

    public function followerUserUserFolloweds()
    {
        return $this->hasMany(UserFollowed::class, 'follower_user_id', 'id');
    }

    public function userUserBlockeds()
    {
        return $this->hasMany(UserBlocked::class, 'user_id', 'id');
    }

    public function blockedUserUserBlockeds()
    {
        return $this->hasMany(UserBlocked::class, 'blocked_user_id', 'id');
    }

    public function blockedUsers()
    {
        return $this->hasMany(UserBlocked::class, 'user_id', 'id');
    }

    public function userUserDontShowAgains()
    {
        return $this->hasMany(UserDontShowAgain::class, 'user_id', 'id');
    }

    public function dontShowAgainUserUserDontShowAgains()
    {
        return $this->hasMany(UserDontShowAgain::class, 'dont_show_again_user_id', 'id');
    }

    public function userProfilCvs()
    {
        return $this->hasMany(ProfilCv::class, 'user_id', 'id');
    }

    public function userLanguagesProfils()
    {
        return $this->hasMany(LanguagesProfil::class, 'user_id', 'id');
    }

    public function userEmailHistories()
    {
        return $this->hasMany(EmailHistoriesLog::class, 'from_user', 'email');
    }

    public function userSearches()
    {
        return $this->hasMany(Search::class, 'user_id', 'id');
    }

    public function userAvailabilities()
    {
        return $this->hasMany(Availability::class, 'user_id', 'id');
    }

    public function participiantFeedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function userUserReporteds()
    {
        return $this->hasMany(UserReported::class, 'user_id', 'id');
    }

    public function reporterUserUserReporteds()
    {
        return $this->hasMany(UserReported::class, 'reporter_user_id', 'id');
    }

    public function userUserVisiteds()
    {
        return $this->hasMany(UserVisited::class, 'user_id', 'id');
    }

    public function teacherBookings()
    {
        return $this->hasMany(Booking::class, 'teacher_user_id', 'id');
    }

    public function participiantBookings()
    {
        return $this->hasMany(Booking::class, 'participant_user_id', 'id');
    }

    public function visitedUserUserVisiteds()
    {
        return $this->hasMany(UserVisited::class, 'visited_user_id', 'id');
    }

    public function userBillingAddress()
    {
        return $this->belongsTo(BillingAddress::class, 'billing_address_id', 'id');
    }

    public function billingAddress()
    {
        return $this->hasMany(BillingAddress::class, 'user_id', 'id');
    }

    public function payouts()
    {
        return $this->hasMany(Payout::class, 'user_id', 'id');
    }

    public function suggestionsHomeScreen()
    {
        return $this->hasMany(SuggestionsHomeScreen::class, 'user_id', 'id');
    }

    public function affiliate()
    {
        return $this->hasOne(Affiliate::class, 'user_id', 'id');
    }

    public function userOfAffiliate()
    {
        return $this->hasOne(Affiliate::class, 'affiliates_sub_affiliate_id', 'id');
    }

    public function userOfSubAffiliate()
    {
        return $this->hasOne(Subaffiliate::class, 'affiliates_sub_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function jtc()
    {
        return $this->hasOne(JoinTheClub::class, 'users_id', 'id');
    }

    /**
     * Each user has belongs to a Role.
     */
    public function role()
    {
        return $this->roles()->first();
    }

    /**
     * Each user has many available days.
     */
    public function availabilities(): HasMany
    {
        return $this->hasMany(Availability::class);
    }

    /**
     * Each user has one Billing address.
     */
    public function billing(): HasOne
    {
        return $this->hasOne(BillingAddress::class)->latest('id');
    }

    /**
     * Get all Billing Addresses of a User.
     */
    public function billings(): HasMany
    {
        return $this->hasMany(BillingAddress::class);
    }

    /**
     * Each user has many bookings.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'teacher_user_id', 'id');
    }

    /**
     * Each user has many Booked talks.
     */
    public function booked(): HasMany
    {
        return $this->hasMany(Booking::class, 'participant_user_id', 'id');
    }

    /**
     * @return HasManyThrough
     */
    public function bookingsProtocolsSupplier()
    {
        return $this->hasManyThrough(BookingsProtocol::class, Booking::class, 'teacher_user_id', 'booking_id', 'id', 'id');
    }

    /**
     * @return HasManyThrough
     */
    public function bookingsProtocolsClient()
    {
        return $this->hasManyThrough(BookingsProtocol::class, Booking::class, 'participant_user_id', 'booking_id', 'id', 'id');
    }

    /**
     * Each user has many Bookmarked talks.
     */
    public function bookmarks(): HasMany
    {
        return $this->hasMany(UserBookmarkedTalks::class);
    }

    /**
     * Each user has one Payout Method.
     */
    public function payoutMethods(): HasMany
    {
        return $this->hasMany(ProfilPayoutMethod::class);
    }

    /**
     * Verified Social Providers
     */
    public function social()
    {
        return $this->hasMany(SocialNetworkVerification::class);
    }

    public function verifiedSocialProviders()
    {
        return $this->hasMany(VerifiedSocialProviders::class);
    }

    /**
     * Each user has one Payout Method.
     */
    public function payoutMethod(): HasOne
    {
        return $this->hasOne(ProfilPayoutMethod::class)->latest('id');
    }

    /**
     * PayPal accounts that belong to the user.
     *
     * @return HasMany
     */
    public function paypalAccounts(): HasMany
    {
        return $this->hasMany(PaypalAccounts::class);
    }

    /**
     * Calendar Tokens that belong to the user.
     *
     * @return HasMany
     */
    public function calendarAccounts(): HasMany
    {
        return $this->hasMany(CalendarAccount::class);
    }

    /**
     * Calendars that belong to the user.
     *
     * @return HasMany
     */
    public function calendars(): HasMany
    {
        return $this->hasMany(Calendar::class);
    }

    /**
     * Events that the user owns.
     *
     * @return BelongsToMany
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }

    /**
     * Default PayPal account that belong to the user.
     */
    public function defaultPaypalAccount()
    {
        return $this->hasOne(PaypalAccounts::class)->where('state', '=', true)->first();
    }

    /**
     * Each user has one Metric.
     */
    public function metric(): HasOne
    {
        return $this->hasOne(StaticMetric::class);
    }

    /**
     * Each user has many Feedbacks.
     */
    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * Each user has many Talk Reviews.
     */
    public function talkReviews(): HasManyThrough
    {
        return $this->hasManyThrough(Feedback::class, Booking::class, 'teacher_user_id', 'booking_id', 'id', 'id');
    }

    /**
     * Each user has many Bookmarked talks.
     */
    public function bookmarkedTalks(): HasManyThrough
    {
        return $this->hasManyThrough(Talk::class, UserBookmarkedTalks::class, 'user_id', 'id', 'id', 'talks_id');
    }

    /**
     * Each user has many followers.
     */
    public function followers(): HasMany
    {
        return $this->hasMany(UserFollowed::class, 'follower_user_id');
    }

    /**
     * Each user has many followings.
     */
    public function followings(): HasMany
    {
        return $this->hasMany(UserFollowed::class);
    }

    /**
     * Each user is following many Users.
     */
    public function followedUsers(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, UserFollowed::class, 'user_id', 'id', 'id', 'follower_user_id');
    }

    /**
     * Each user has a VAT .
     */
    public function vat(): HasOne
    {
        // This used to be a relationship with VAT Model, but was changed when we decided to merge 'static_vat' and 'countries'.
        return $this->hasOne(Country::class, 'id', 'vat_id');
    }

    /**
     * Get the user that Notification Settings belong to.
     */
    public function notificationSettings(): HasOne
    {
        return $this->hasOne(NotificationSettings::class);
    }

    /**
     * Get Notifications that the User owns.
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notifications::class, 'users_id');
    }

    /**
     * Email Change requests that belong to the user.
     *
     * @return HasMany
     */
    public function emailChanges(): HasMany
    {
        return $this->hasMany(EmailChangeVerification::class);
    }

    /**
     * Emails that the user has received.
     *
     * @return HasMany
     */
    public function receivedEmailHistory(): HasMany
    {
        return $this->hasMany(EmailHistoriesLog::class, 'to_user', 'email');
    }

    /**
     * Emails that the user has sent.
     *
     * @return HasMany
     */
    public function sentEmailHistory(): HasMany
    {
        return $this->hasMany(EmailHistoriesLog::class, 'from_user', 'email');
    }

    /**
     * Socket participation's that the user was a part of.
     *
     * @return HasMany
     */
    public function socketParticipants(): HasMany
    {
        return $this->hasMany(SocketParticipant::class);
    }

    /**
     * Socket Rooms that the user was a part of.
     *
     * @return HasManyThrough
     */
    public function socketRooms()
    {
        return $this->hasManyThrough(SocketRoom::class, SocketParticipant::class, 'user_id', 'id', 'id', 'socket_room_id');
    }

    /**
     * Profile Verifications that the user has requested.
     *
     * @return HasMany
     */
    public function profileVerificationRequests(): HasMany
    {
        return $this->hasMany(UserVerificationRequests::class);
    }

    /**
     * Pending Profile Verifications that the user has requested.
     */
    public function pendingProfileVerificationRequest()
    {
        return $this->hasOne(UserVerificationRequests::class)->latestOfMany();
    }

    /**
     * Image Verifications that the user has requested.
     *
     * @return HasMany
     */
    public function imageVerificationRequests(): HasMany
    {
        return $this->hasMany(UserImages::class);
    }

    /**
     * Slots that the user has booked.
     *
     * @return HasMany
     */
    public function bookedSlots(): HasMany
    {
        return $this->hasMany(BookingsBookedSlots::class, 'teacher_user_id');
    }

    /**
     * User App permissions of the User.
     *
     * @return HasMany
     */
    public function additionalInfo(): HasMany
    {
        return $this->hasMany(UserAdditionalInfo::class);
    }

    /**
     * Partner that owns the User.
     *
     * @return BelongsTo
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    /**
     * Partner User that owns User.
     *
     * @return BelongsTo
     */
    public function partnerUser(): BelongsTo
    {
        return $this->belongsTo(PartnerUser::class);
    }

    /* Methods
       ============================== */

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function userRole()
    {
        if ($this->roles()->where('id', 1)->exists()) {
            return 'Admin';
        } else {
            if ($this->roles()->where('id', 2)->exists()) {
                return 'Teacher';
            } else {
                if ($this->roles()->where('id', 3)->exists()) {
                    return 'User';
                } else {
                    if ($this->roles()->where('id', 4)->exists()) {
                        return 'Affiliate';
                    }
                }
            }
        }
    }

    /**
     * Returns all Suppliers.
     *
     * @return Collection
     */
    public function getSuppliers(): Collection
    {
        return $this->where('type', User::TYPE['supplier'])
            ->join('bookings AS revenue', function ($join) {
                $join->on('revenue.teacher_user_id', '=', 'users.id')
                    ->whereNull('revenue.cancel_type')
                    ->where('users.type', User::TYPE['supplier']);
            })
            ->join('payouts_methods AS payout_method', 'users.id', '=', 'payout_method.user_id')
            ->select([
                'users.id',
                'users.username',
                \DB::raw('ROUND(SUM(revenue.price), 2) AS revenue'),
                \DB::raw('ROUND(SUM(revenue.price*0.2), 2) AS commission'),
                \DB::raw('ROUND(SUM(revenue.price-revenue.price*0.2), 2) AS payout'),
                \DB::raw("CASE WHEN payout_method.method=1 THEN 'IBAN' ELSE 'PayPal' END AS payout_method"),
            ])
            ->groupBy('revenue.teacher_user_id')
            ->get();
    }

    /**
     * Return all User Bookings.
     *
     * @return Collection
     */
    public function getBookings(): Collection
    {
        return $this->bookings()
            ->whereIn('bookings.state', [Booking::STATE['paid'], Booking::STATE['completed'], Booking::STATE['payout'], Booking::STATE['postponed']])
            ->join('static_vat', 'bookings.vat_id', '=', 'static_vat.id')
            ->join('talks', 'bookings.talk_id', '=', 'talks.id')
            ->select([
                'bookings.state',
                'bookings.id',
                'bookings.parent_id',
                'bookings.price',
                'talks.headline AS talk',
                'static_vat.english AS country',
                \DB::raw('ROUND(bookings.price-bookings.price*0.2, 2) AS payout'),
                \DB::raw('CONCAT(bookings.start_date, " ", SUBSTRING(bookings.start_time, 1, LENGTH(bookings.start_time)-3), " - ", SUBSTRING(bookings.end_time, 1, LENGTH(bookings.end_time)-3)) AS date'),
                \DB::raw("TO_CHAR(bookings.start_date, 'FMMonth') AS month"),
            ])
            ->get();
    }

    /**
     * Return all User Bookings for Payout.
     *
     * @return Collection
     */
    public function getBookingsForPayout(): Collection
    {
        return $this->bookings()
            ->whereNull('cancel_type')
            ->join('static_vat', 'bookings.vat_id', '=', 'static_vat.id')
            ->join('payouts_methods AS payout_method', 'bookings.teacher_user_id', '=', 'payout_method.user_id')
            ->select([
                'bookings.id',
                'static_vat.english AS country_of_residence',
                'bookings.vat AS vat_value',
                'bookings.start_date',
                \DB::raw('COUNT(*) AS bookings_count'),
                \DB::raw('ROUND(SUM(bookings.price), 2) AS revenue'),
                \DB::raw('ROUND(SUM(bookings.price-bookings.price*0.2), 2) AS payout'),
                \DB::raw('ROUND(SUM((bookings.price-bookings.price*0.2)-(bookings.price-bookings.price*0.2)/(1+(bookings.vat*0.01))), 2) AS tax'),
                \DB::raw('ROUND(SUM(bookings.price-bookings.price*0.2)/(1+(bookings.vat*0.01)), 2) AS net'),
                \DB::raw("CASE WHEN payout_method.method=1 THEN 'IBAN' ELSE 'PayPal' END AS payout_method"),
            ])
            ->groupBy('country_of_residence', 'vat_value')
            ->get();
    }

    /**
     * Return all User Bookings for Payout by each Month.
     *
     * @return Collection
     */
    public function getBookingsForPayoutByMonth(): Collection
    {
        return $this->bookings()
            // ->join('static_vat', 'bookings.vat_id', '=', 'static_vat.id')
            ->join('payouts_methods AS payout_method', 'bookings.teacher_user_id', '=', 'payout_method.user_id')
            ->select([
                'bookings.id',
                // 'static_vat.english AS country_of_residence',
                'bookings.vat AS vat_value',
                \DB::raw('COUNT(*) AS bookings_count'),
                \DB::raw('ROUND(SUM(bookings.price), 2) AS revenue'),
                \DB::raw('ROUND(SUM(bookings.price-bookings.price*0.2), 2) AS payout'),
                \DB::raw('ROUND(SUM((bookings.price-bookings.price*0.2)-(bookings.price-bookings.price*0.2)/(1+(bookings.vat*0.01))), 2) AS tax'),
                \DB::raw('ROUND(SUM(bookings.price-bookings.price*0.2)/(1+(bookings.vat*0.01)), 2) AS net'),
                \DB::raw("CASE WHEN payout_method.method=1 THEN 'IBAN' ELSE 'PayPal' END AS payout_method"),
                \DB::raw("TO_CHAR(bookings.start_date, 'FMMonth') AS month"),
                \DB::raw('YEAR(bookings.start_date) AS year'),
            ])
            ->whereNull('cancel_type')
            ->groupBy('month')
            ->get();
    }

    /**
     * Return User Bookings for Payout by Month.
     *
     * @param  string  $payout
     *
     * @return Collection
     */
    public function getBookingsByPayout(string $payout): Collection
    {
        return $this->payouts()->where('id', $payout)->first()->bookings;
    }

    /**
     * Returns Revenue of all User Bookings.
     *
     * @return float
     */
    public function getBookingsRevenue(): float
    {
        return round($this->getBookingsForPayout()->sum('revenue'), 2);
    }

    /**
     * Returns Commission of all User Bookings.
     *
     * @return float
     */
    public function getBookingsCommission(): float
    {
        return round($this->getBookingsForPayout()->sum('revenue') * 0.2, 2);
    }

    /**
     * Returns Commission of all User Bookings.
     *
     * @return float
     */
    public function getBookingsPayout(): float
    {
        return round($this->getBookingsRevenue() - $this->getBookingsCommission(), 2);
    }

    /**
     * Returns count of all Bookings.
     *
     * @return int
     */
    public function getBookingsCount(): int
    {
        return $this->bookings()->whereNull('cancel_type')->count();
    }

    /**
     * Returns Users' current earnings.
     *
     * @param  int|null  $limit
     * @param  int|null  $offset
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCurrentEarnings(?int $limit = null, ?int $offset = null): \Illuminate\Support\Collection
    {
        $bookings = $this->bookings()
            ->whereIn('bookings.state', [
                Booking::STATE['paid'],
                Booking::STATE['review'],
                Booking::STATE['completed'],
                Booking::STATE['postponed'],
                Booking::STATE['canceled_without_refund'],
            ])
            ->join('static_vat', 'bookings.vat_id', '=', 'static_vat.id')
            ->join('talks', 'bookings.talk_id', '=', 'talks.id')
            ->select([
                'bookings.state',
                'bookings.id',
                'bookings.parent_id',
                'bookings.price',
                'talks.headline AS headline',
                'static_vat.english AS country',
                \DB::raw('ROUND(bookings.price-bookings.price*0.2, 2) AS payout'),
                \DB::raw("CONCAT(TO_CHAR(bookings.start_date, 'DD.MM.YYYY'), ' ', TO_CHAR(bookings.start_time, 'HH24:MI'), ' - ', TO_CHAR(bookings.end_time, 'HH24:MI')) AS date"),
                \DB::raw("TO_CHAR(bookings.start_date, 'FMMonth') AS month"),
            ]);

        return collect([
            'total'       => $bookings->sum('bookings.price') * 0.8,
            'talks_count' => $bookings->count(),
            'duration'    => $bookings->sum('bookings.duration'),
            'bookings'    => $bookings
                ->when($limit, function ($query) use ($limit) {
                    $query->limit($limit);
                })
                ->when(is_null($limit), function ($query) use ($limit) {
                    $query->limit(3);
                })
                ->when($offset && $limit != 0, function ($query) use ($offset) {
                    $query->offset($offset);
                })->get(),
        ]);
    }

    /**
     * Store Users' Notification Settings.
     *
     * @param  array  $settings  Notification settings.
     *
     * @return Model
     */
    public function storeNotificationSettings($settings)
    {
        return $this->notificationSettings()->updateOrCreate(
            [
                'user_id' => $this->id,
            ],
            $settings
        );
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function talksTotalIncome()
    {
        $oTalkIncome = Talk::query()->selectRaw('SUM(price) AS total_all')->where('teacher_user_id', $this->id)->first();

        return $oTalkIncome->total_all;
    }

    public function getUserDataById($userId)
    {
        $userData = User::where('id', $userId)->first();

        return $userData;
    }

    public function addStripeCustomer($userId, $stripeId)
    {
        $data                 = User::find($userId);
        $data->user_stripe_id = $stripeId;
        $data->save();

        return $data->id;
    }

    public function spentMoney()
    {
        $bookingsSum = Booking::query()->where('participant_user_id', $this->id)->whereNull('cancel_type')->sum('price');

        return $bookingsSum;
    }

    public function canceledTalks($param = 'count')
    {
        $bookings = Booking::query()->where('participant_user_id', $this->id)->count();

        $bookingsCount = Booking::query()->where('participant_user_id', $this->id)
            ->where(function ($query) {
                $query->where('cancel_type', Booking::CANCEL_TYPE['client']);
                $query->orWhere('cancel_type', Booking::CANCEL_TYPE['active_talk_client']);
            })->count();
        $percentage    = ($bookingsCount / 100) * $bookings;

        if ($param == 'percentage') {
            return $percentage;
        } else {
            return $bookingsCount;
        }
    }

    /**
     * Return currently logged user.
     */
    public function current()
    {
        return auth()->user();
    }

    /**
     * Determine whether the user has bookmarked the talk.
     *
     * @param $talk
     *
     * @return bool
     */
    public function hasBookmarked($talk)
    {
        return count($this->bookmarkedTalks->where('id', $talk->id)) > 0;
    }

    /**
     * Starts 'Join The Club' process for current user.
     *
     * @return int
     */
    public function startJTC()
    {
        return $this->jtc()->update([
            'jtc_started' => true,
        ]);
    }

    /**
     * Get current user favored talks.
     *
     * @param  int  $offset
     * @param  int  $limit
     */
    public function getFavoredTalks($offset = 0, $limit = 5)
    {
        $talks = $this->bookmarkedTalks()->with('teacher', 'category', 'subcategory', 'language', 'fans', 'availabilities');

        return [
            'talks_count' => $talks->count(),
            'filters'     => $this->filters->active($talks->get()),
            'data'        => $talks->offset($offset)->limit($limit)->distinct()->get(),
        ];
    }

    /**
     * Get current user filtered favored talks.
     *
     * @param  int  $offset
     * @param  int  $limit
     */
    public function getFilteredFavoredTalks($filters, $offset = 0, $limit = 5)
    {
        $talks = $this->current()->bookmarkedTalks()
            ->with('teacher', 'category', 'subcategory', 'language', 'fans')
            ->where('talks.state', '!=', 2)
            // ->distinct()
            ->whereDurations($filters['duration'])
            ->wherePrices($this->filters->prices($filters['priceRange']))
            ->whereDays($this->filters->days($filters['availability']))
            ->whereTalks($this->filters->talkTypes($filters['talks']))
            ->whereAnonymus(optional($filters)['anonTalks'] ?: false)
            ->whereLanguage(optional($filters)['language_id']);

        return [
            'talks_count' => $talks->count(),
            'data'        => $talks->offset($offset)->limit($limit)->get(),
        ];
    }

    /**
     * Deactivate User account.
     *
     * @return void
     */
    public function deactivate()
    {
        $email = $this->email;

        if ($this->facebook_details) {
            $facebook_access_token = config('socials.facebook.client_id') . '|' . config('socials.facebook.client_secret');

            $response = Http::delete("https://graph.facebook.com/{$this->facebook_token}/permissions", [
                'access_token' => $facebook_access_token,
            ]);

            Log::notice('Revoke Facebook token: ' . json_encode($response->status()));
        }

        if ($this->google_details) {
            $details = json_decode($this->google_details);

            $response = Http::asForm()->post("https://oauth2.googleapis.com/revoke", [
                'token' => $details->token,
            ]);

            Log::notice('Revoke Google token: ' . json_encode($response->status()));
        }

        if ($this->apple_details) {
            $details = json_decode($this->apple_details);

            $response = Http::asForm()->post("https://appleid.apple.com/auth/revoke", [
                'client_id'       => config('socials.apple.client_id'),
                'client_secret'   => config('socials.apple.client_secret'),
                'token'           => $details->refresh_token ?? '',
                'token_type_hint' => 'refresh_token',
            ]);

            Log::notice('Revoke Apple Refresh token: ' . json_encode($response->status()));

            $response = Http::asForm()->post("https://appleid.apple.com/auth/revoke", [
                'client_id'       => config('socials.apple.client_id'),
                'client_secret'   => config('socials.apple.client_secret'),
                'token'           => $details->access_token ?? '',
                'token_type_hint' => 'access_token',
            ]);

            Log::notice('Revoke Apple Access token: ' . json_encode($response->status()));
        }

        if ($this->calendarAccounts->isNotEmpty()) {
            foreach ($this->calendarAccounts as $calendar_account) {
                $response = Http::asForm()->post("https://oauth2.googleapis.com/revoke", [
                    'token' => $calendar_account->access_token,
                ]);

                foreach ($calendar_account->calendars as $calendar) {
                    $calendar->delete();

                    Log::notice('Removed calendar ' . $calendar_account->calendar_id);
                }

                $calendar_account->delete();

                Log::notice('Revoke Google Calendar token for calendar ID ' . $calendar_account->id);
            }
        }

        $calendar_accounts = CalendarAccount::where('email', $email)->get();

        foreach ($calendar_accounts as $calendar_account) {
            $calendar_account->delete();
            // Mail.
        }

        $billings = $this->billings()->update([
            'email'               => $this->setGDPRColumn(),
            'company_name'        => $this->setGDPRColumn(),
            'street'              => $this->setGDPRColumn(),
            'zipcode'             => $this->setGDPRColumn(),
            'city'                => $this->setGDPRColumn(),
            'iban_recipient_name' => $this->setGDPRColumn(),
        ]);
        Log::notice("GDPR-ed {$billings} number of entries from Billings table for user {$email}.");

        $email_changes = $this->emailChanges()->update([
            'requested_email' => $this->setGDPRColumn(),
        ]);
        Log::notice("GDPR-ed {$email_changes} number of entries from Email Changes table for user {$email}.");

        $received_emails = $this->receivedEmailHistory()->update([
            'to_user' => $this->setGDPRColumn(),
        ]);
        Log::notice("GDPR-ed {$received_emails} number of received email entries from Email Histories table for user {$email}.");

        $sent_emails = $this->sentEmailHistory()->update([
            'from_user' => $this->setGDPRColumn(),
        ]);
        Log::notice("GDPR-ed {$sent_emails} number of sent email entries from Email Histories table for user {$email}.");

        $password_resets = \DB::table('password_resets')->where('email', $this->email)->update([
            'email' => $this->setGDPRColumn(),
        ]);
        Log::notice("GDPR-ed {$password_resets} number of entries from Password Resets table for user {$email}.");

        $socket_participants = $this->socketParticipants()->update([
            'name_of_user'        => $this->setGDPRColumn(),
            'twilio_access_token' => $this->setGDPRColumn(),
            'firebase_id'         => $this->setGDPRColumn(),
            'is_active'           => ParticipantStates::DIDNT_SHOW,
        ]);

        Log::notice("GDPR-ed {$socket_participants} number of entries from Socket Participants table for user {$email}.");

        $socket_rooms = $this->socketRooms()
            ->whereDate('talk_start_time', '>=', now()->toDateTimeString())
            ->update([
                'state' => RoomStates::USER_DELETED,
            ]);

        Log::notice("GDPR-ed {$socket_rooms} number of entries from Socket Rooms table for user {$email}.");

        $profile_verifications = $this->profileVerificationRequests()
            ->where('status', '!=', UserVerificationRequests::STATE['approved'])
            ->update([
                'status'     => UserVerificationRequests::STATE['declined'],
                'deleted_at' => now(),
            ]);

        Log::notice("GDPR-ed {$profile_verifications} number of entries from User Verification Requests table for user {$email}.");

        $image_verifications = $this->imageVerificationRequests()
            ->where('state', '!=', UserImages::STATE['approved'])
            ->update([
                'image' => config('app.default_image'),
                'state' => UserImages::STATE['declined'],
            ]);

        Log::notice("GDPR-ed {$image_verifications} number of entries from User Image Requests table for user {$email}.");

        $bookings = $this->bookings()
            ->where('state', Booking::STATE['paid'])
            ->whereDate('start_date', '>=', date('Y-m-d'));

        $bookings->update([
            'state' => Booking::STATE['cancelled_due_supplier'],
        ]);

        $this->refundBookings($bookings);

        Log::notice("GDPR-ed {$bookings->count()} number of booking entries from Bookings table for user {$email}.");

        $booked = $this->booked()
            ->where('state', Booking::STATE['paid'])
            ->whereDate('start_date', '>=', date('Y-m-d'));

        $booked->update([
            'state' => Booking::STATE['cancelled_due_client'],
        ]);

        $this->refundBookings($booked);

        Log::notice("GDPR-ed {$booked->count()} number of booking entries from Bookings table for user {$email}.");

        $booked_slots = $this->bookedSlots()->delete();

        Log::notice("GDPR-ed {$booked_slots} number of booked entries from Booking Booked Slots table for user {$email}.");

        $partner_user = $this->partnerUser()->first();

        if ($partner_user) {
            $partner_user->update([
                'name'        => $this->setGDPRColumn(),
                'username'    => $this->setGDPRColumn(),
                'email'       => $this->setGDPRColumn(),
                'image'       => $this->setGDPRColumn(),
                'description' => $this->setGDPRColumn(),
            ]);

            $partner_user->delete();
        }

        Log::notice("GDPR-ed {$partner_user} number of booked entries from Partner Users table for user {$email}.");


        // $protocols_supplier = $this->bookingsProtocolsSupplier()
        //     ->whereDate('start_date', '>=', date('Y-m-d'))
        //     ->update([
        //         'bookings_protocol.state' => 20,
        //     ]);
        //
        // Log::notice("GDPR-ed {$protocols_supplier} number of Client entries from Booking Protocols table for user {$email}.");
        //
        // $protocols_client = $this->bookingsProtocolsClient()
        //     ->whereDate('start_date', '>=', date('Y-m-d'))
        //     ->update([
        //         'bookings_protocol.state' => 20,
        //     ]);
        //
        // Log::notice("GDPR-ed {$protocols_client} number of Supplier entries from Booking Protocols table for user {$email}.");

        File::deleteDirectory(public_path('assets/images/user/' . $this->id));

        Mail::to($this->email)->queue(new AccountDeleted($this));

        $user = $this->update([
            'email'               => $this->setGDPRColumn(),
            'name'                => $this->setGDPRColumn(),
            'username'            => $this->setGDPRColumn(),
            'profile_picture'     => config('app.default_image'),
            'profile_picture_tmp' => config('app.default_image'),
            'google_token'        => $this->setGDPRColumn(),
            'google_details'      => null,
            'facebook_token'      => null,
            'facebook_details'    => null,
            'apple_token'         => null,
            'apple_details'       => null,
            'firebase_id'         => null,
            'voip_token'          => null,
        ]);

        Log::notice("GDPR-ed {$user} number of entries from Users table for user {$email}.");

        $this->delete();
    }

    /**
     * Set GDPR prefix to the column.
     *
     * @return string
     */
    protected function setGDPRColumn(): string
    {
        return 'gdpr_' . $this->id;
    }

    public function getCalendarAccessToken($calendar)
    {
        if ($this->calendarAccounts->isEmpty()) {
            return;
        }

        switch (class_basename(get_class($calendar))) {
            case 'Calendar':
                return $calendar->calendarAccount->access_token;
            case 'CalendarAccount':
                return $calendar->access_token;
        }
    }

    public function getCalendarRefreshToken($calendar)
    {
        switch (class_basename(get_class($calendar))) {
            case 'Calendar':
                return $calendar->calendarAccount->refresh_token;
            case 'CalendarAccount':
                return $calendar->refresh_token;
        }
    }

    public function getClientCalendars()
    {
        return $this->calendars()
            // ->join('calendar_accounts', function ($join) {
            // $join->on('calendars.calendar_account_id', '=', 'calendar_accounts.id')
            // ->whereIn('calendar_accounts.state', [CalendarAccount::CLIENT_ONLY, CalendarAccount::BOTH]);
            // })
            ->whereHas('calendarAccount', function ($query) {
                $query->whereIn('calendar_accounts.state', [CalendarAccount::CLIENT_ONLY, CalendarAccount::BOTH]);
            })
            ->where('calendars.state', Calendar::ACTIVE)
            ->get();
    }

    public function getSupplierCalendars()
    {
        return $this->calendars()
            // ->join('calendar_accounts', function ($join) {
            // $join->on('calendars.calendar_account_id', '=', 'calendar_accounts.id')
            // ->whereIn('calendar_accounts.state', [CalendarAccount::SUPPLIER_ONLY, CalendarAccount::BOTH]);
            // })
            ->whereHas('calendarAccount', function ($query) {
                $query->whereIn('calendar_accounts.state', [CalendarAccount::SUPPLIER_ONLY, CalendarAccount::BOTH]);
            })
            ->where('calendars.state', Calendar::ACTIVE)
            ->get();
    }

    public function refundBookings($bookings)
    {
        $wallet_history = new WalletHistory();

        foreach ($bookings->get() as $booking) {
            if ($booking->state == $booking::STATE['cancelled_due_supplier']) {
                $talk      = $booking->talk;
                $talk_type = $talk->talk_type == TalkTypes::VOICE_CALL ? 'Phone-Talk' : 'Video-Talk';
                $client    = $booking->participant_user;
                $supplier  = $booking->teacher_user()->withTrashed()->first();

                BookingsController::createBookingProtocolEvent($booking->id, \App\Models\Booking::STATE['cancelled_due_supplier']);

                if ($client) {
                    $wallet_history->addFundsInWallet($client, $booking->price, WalletHistory::TYPE['CREDIT'], $booking->id, null, null, WalletHistory::STATUS['COMPLETED'], WalletHistory::SOURCE['REFUND']);

                    NotifyClientTalkCanceled::dispatch(
                        $client->id,
                        $booking->id,
                        $talk->headline,
                        Carbon::parse($booking->start_date)->format('d.m.Y'),
                        convertToUserTimezone($booking->start_time, 'H:i')
                    );

                    $notificationData = [
                        'user_id'      => $supplier->id,
                        'type'         => $talk->headline,
                        'param_type'   => 'name_of_talk',
                        'param_id'     => $booking->id,
                        'talkName'     => $talk->headline,
                        'talkDate'     => Carbon::parse($booking->start_date)->format('d.m.Y'),
                        'talkTime'     => convertToUserTimezone($booking->start_time, 'H:i'),
                        'talkSupplier' => $supplier->username,
                        'value'        => Notifications::VALUE['canceled_by_supplier'],
                    ];

                    $notification = NotificationsApiController::sendNotification(request(), $notificationData);

                    Mail::to($client->email)->queue(
                        new BookingCancellationClient(
                            $supplier->last_language,
                            $supplier->email,
                            $supplier->username,
                            $talk->id,
                            $talk->headline,
                            convertToUserTimezone($booking->start_date, 'd.m.Y'),
                            convertToUserTimezone($booking->start_time, 'H:i'),
                            convertToUserTimezone($booking->end_time, 'H:i'),
                            $talk->duration,
                            $talk->price,
                            $talk_type,
                            $booking->id
                        )
                    );
                }

                $booking->update([
                    'state'                  => $booking::STATE['cancelled_due_supplier'],
                    'cancellation_reason_id' => 6,
                    'cancel_type'            => Booking::CANCEL_TYPE['supplier'],
                ]);
            }

            if ($booking->state == $booking::STATE['cancelled_due_client']) {
                $time_difference = \Illuminate\Support\Carbon::parse($booking->updated_at)->diffInHours(now()->addHours(48));
                $talk            = $booking->talk;
                $talk_type       = $talk->talk_type == TalkTypes::VOICE_CALL ? 'Phone-Talk' : 'Video-Talk';
                $client          = $booking->participant_user()->withTrashed()->first();
                $supplier        = $booking->teacher_user;

                BookingsController::createBookingProtocolEvent($booking->id, Booking::STATE['cancelled_due_client']);

                if ($time_difference > 48) {
                    $this->wallet_history->addFundsInWallet($client, $booking->price, WalletHistory::TYPE['CREDIT'], $booking->id, null, null, WalletHistory::STATUS['COMPLETED'], WalletHistory::SOURCE['REFUND']);
                }

                NotifyTeacherTalkCanceled::dispatch(
                    $supplier->id,
                    $booking->id,
                    $talk->headline,
                    Carbon::parse($booking->start_date)->format('d.m.Y'),
                    convertToUserTimezone($booking->start_time, 'H:i')
                );

                $notificationData = [
                    'user_id'      => $supplier->id,
                    'type'         => $talk->headline,
                    'param_type'   => 'name_of_talk',
                    'param_id'     => $booking->id,
                    'talkName'     => $talk->headline,
                    'talkDate'     => Carbon::parse($booking->start_date)->format('d.m.Y'),
                    'talkTime'     => convertToUserTimezone($booking->start_time, 'H:i'),
                    'talkSupplier' => $booking->supplier->username,
                    'value'        => Notifications::VALUE['canceled_by_supplier'],
                ];

                NotificationsApiController::sendNotification(request(), $notificationData);

                $notification = NotificationsApiController::sendNotification(request(), $notificationData);


                Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$notification');
                Log::notice($notification);

                Mail::to($supplier->email)->queue(
                    new BookingCancellationSupplier(
                        $supplier->last_language,
                        $client->email,
                        $supplier->email,
                        $supplier->username,
                        $talk->headline,
                        convertToUserTimezone($booking->start_date, 'd.m.Y'),
                        convertToUserTimezone($booking->start_time, 'H:i'),
                        convertToUserTimezone($booking->end_time, 'H:i'),
                        $talk->duration,
                        $talk->price,
                        $talk_type,
                        $booking->id,
                    )
                );

                $booking->update([
                    'state'                  => $booking::STATE['cancelled_due_client'],
                    'cancellation_reason_id' => 6,
                    'cancel_type'            => Booking::CANCEL_TYPE['client'],
                ]);
            }
        }
    }

    /**
     * Determines whether the current user has any active bookings in the future.
     *
     * @return bool
     */
    public function hasActiveBookings(): bool
    {
        return Booking::query()
            ->where('state', Booking::STATE['paid'])
            ->where('start_call', '>', now()->toDateTimeString())
            ->where(function ($query) {
                $query->where('participant_user_id', $this->id);
                $query->orWhere('teacher_user_id', $this->id);
            })
            ->exists();
    }

    /**
     * Get the user's currently active booking (within the call time window).
     *
     * @return Booking|false
     */
    public function activeBooking()
    {
        $userID = $this->id;

        $booking = Booking::query()
            ->where('state', Booking::STATE['paid'])
            ->where(function ($query) use ($userID) {
                $query->where('participant_user_id', $userID);
                $query->orWhere('teacher_user_id', $userID);
            })
            ->where(function ($query) {
                $query->where('start_call', '<=', now()->addMinute());
                $query->where('end_call', '>=', now());
            })
            ->orderBy('id', 'DESC')
            ->first();

        if (!$booking) {
            return false;
        }

        if ($booking->parent_id) {
            $parentBooking = Booking::find($booking->parent_id);

            if ($parentBooking && $parentBooking->state !== Booking::STATE['postponed']) {
                $booking = $parentBooking;
            }
        }

        return $booking;
    }

    /**
     * Determine whether the email has been verified.
     *
     * @param  string  $email  User email.
     *
     * @return bool
     */
    public function isVerified(string $email): bool
    {
        return $this->query()
            ->where('email', '=', $email)
            ->where('verified', '=', true)
            ->exists();
    }

    /**
     * Determine whether the email is unique.
     *
     * @param  string  $email  User email.
     *
     * @return bool
     */
    public function hasUniqueEmail(string $email): bool
    {
        return $this->query()
            ->where('email', '=', $email)
            ->doesntExist();
    }

    /**
     * Determine whether the username is unique.
     *
     * @param  null|string  $username  User username.
     *
     * @return bool
     */
    public function hasUniqueUsername(?string $username): bool
    {
        if (is_null($username)) {
            return true;
        }

        return $this->query()
            ->where('username', '=', $username)
            ->doesntExist();
    }

    /**
     * Generate a username from a string.
     *
     * @param  string  $base   Base of the username.
     * @param  int     $count  Number of suggestions,
     *
     * @return array
     */
    public function generateUsername(string $base, int $count = 1): array
    {
        $usernames = [];

        for ($i = 0; $i < $count; $i++) {
            $usernames[] = $base . '_' . rand(100, 999);
        }

        $existingUsernames = User::query()
            ->whereIn('username', $usernames)
            ->pluck('username')
            ->toArray();

        return array_diff($usernames, $existingUsernames);
    }

    /**
     * Create a JTC account with the 'username' step completed.
     *
     * @param  bool  $withStepOne
     *
     * @return void
     */
    public function createJTC(bool $withStepOne = true): void
    {
        $this->jtc()
            ->create([
                'jtc_started' => true,
                'step_1'      => $withStepOne,
            ]);
    }

    /**
     * Create placeholder Talks.
     *
     * @return void
     */
    public function createTalks(): void
    {
        $appLanguage = request()->user()
            ? request()->user()->last_language
            : request()->header('Application-Language', 'de');
        $language    = StaticProfession::DATABASE_LANGUAGE[$appLanguage];
        app()->setLocale($appLanguage);
        $durations = [15, 30, 45, 60];

        foreach ($durations as $duration) {
            $this->talks()
                ->create([
                    'talk_categories_id'    => TalkCategory::FUN,
                    'talk_subcategories_id' => TalkSubcategory::FUN['OTHER'],
                    'finance_currencies_id' => FinanceCurrency::where('iso_code', '=', 'EUR')->first()->id,
                    'languages_id'          => Language::where('english', 'LIKE', "%$language%")->first()->id,
                    'headline'              => __("EXAMPLE_TALK_{$duration}_TITLE", ['username' => session()->get('username') ?? $this->username]),
                    'description'           => __('EXAMPLE_TALK_DESCRIPTION', ['duration' => $duration]),
                    'price'                 => $duration,
                    'duration'              => $duration,
                    'talk_type'             => TalkTypes::VIDEO_CALL,
                ]);
        }
    }

    /**
     * Create Availability slots.
     *
     * @return void
     */
    public function createAvailabilities(): void
    {
        $appTimezone = $this->timezone;

        foreach (Availability::WEEKDAYS as $weekday) {
            $isWeekend = in_array($weekday, [Availability::WEEKDAY['Saturday'], Availability::WEEKDAY['Sunday']]);

            $this->availabilities()
                ->create([
                    'weekday'    => $weekday,
                    'start_time' => Carbon::parse('10:00:00')->subMinutes($appTimezone),
                    'end_time'   => Carbon::parse($isWeekend ? '18:00:00' : '16:00:00')->subMinutes($appTimezone),
                    'state'      => !$isWeekend,
                ]);
        }
    }

    public function createImageVerification(?string $image): void
    {
        if (!$image) {
            return;
        }

        $this->imageVerificationRequests()
            ->create([
                'image' => $image,
            ]);
    }

    /**
     * Determine whether the user is a Partner.
     *
     * @return bool
     */
    public function isPartner(): bool
    {
        return !is_null($this->partner_id);
    }

    /**
     * Determine whether the user has completed JTC Step.
     *
     * @param  int  $step  JTC Step.
     *
     * @return bool
     */
    public function hasCompletedJTCStep(int $step): bool
    {
        if (!$this->jtc) {
            return false;
        }

        return $this->jtc["step_$step"] === true;
    }

    /**
     * Complete JT Step in case it was not yet completed.
     *
     * @param  int  $step  JTC Step.
     *
     * @return void
     */
    public function completeJTCStep(int $step): void
    {
        if ($this->hasCompletedJTCStep($step)) {
            return;
        }

        if (!$this->jtc) {
            $this->jtc()->create([
                'users_id'    => $this->id,
                'jtc_started' => true,
                "step_{$step}" => true,
            ]);
            return;
        }

        $this->jtc()->update([
            "step_{$step}" => true,
        ]);
    }

    /**
     * Determine whether the user has created any Talks.
     *
     * @return bool
     */
    public function hasTalks(): bool
    {
        return $this->talks()->exists();
    }

    /**
     * Determine whether the user has created any Availabilities.
     *
     * @return bool
     */
    public function hasAvailabilities(): bool
    {
        return $this->availabilities()->exists();
    }

    /**
     * Find the User via 'talk_token'.
     *
     * @param  string  $token Join Talk token.
     *
     * @return User|null
     */
    public function findViaToken(string $token): ?User
    {
        return $this->where('talk_token', $token)
            // ->whereNull('talk_token_used_at')
            ->first();
    }

    /* Accessors/Mutators
       ============================== */

    /**
     * Get Users first name.
     */
    public function getFirstNameAttribute()
    {
        return Str::of($this->name)->explode(' ')->first();
    }

    /**
     * Get Users last name.
     */
    public function getLastNameAttribute()
    {
        return Str::of($this->name)->explode(' ')->last();
    }

    /**
     * Get Users profile picture.
     */
    public function getAvatarAttribute()
    {
        return $this->profile_picture;
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y - m - d H:i:s', $value)->format(config('panel . date_format') . ' ' . config('panel . time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel . date_format') . ' ' . config('panel . time_format'), $value)->format('Y - m - d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function getVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y - m - d H:i:s', $value)->format(config('panel . date_format') . ' ' . config('panel . time_format')) : null;
    }

    // TODO: This is mutator is currently causing an issue with verification.
    // public function setVerifiedAtAttribute($value)
    // {
    //     $this->attributes['verified_at'] = $value ? Carbon::createFromFormat(config('panel . date_format') . ' ' . config('panel . time_format'), $value)->format('Y - m - d H:i:s') : null;
    // }

    /**
     * Get the receiver information for the invoice.
     * Typically includes the name and some sort of (E-mail/physical) address.
     *
     * @return array An array of strings
     */
    public function getInvoiceInformation()
    {
        return [$this->name, $this->email];
    }

    /**
     * Get additional information to be displayed on the invoice. Typically a note provided by the customer.
     *
     * @return string|null
     */
    public function getExtraBillingInformation()
    {
        return null;
    }

}
