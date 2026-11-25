<?php

namespace App\Models;

use App\ModelsApi\Booking;
use App\ModelsApi\StaticProfession;
use App\ModelsApi\User;
use App\ModelsApi\UserFollowed;
use App\Traits\Auditable;
use App\Traits\Serializable;
use App\Traits\WithoutGroupTalks;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Talk extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, Serializable, WithoutGroupTalks;

    public $table = 'talks';

    public $talkTypes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'teacher_user_id',
        'languages_id',
        'anonym_call',
        'call_type',
        'talk_type',
        'interactive_mode',
        'repeat',
        'headline',
        'description',
        'duration',
        'start_time_call',
        'end_time_call',
        'weekday',
        'price',
        'max_participiants',
        'finance_currencies_id',
        'billing_address_id',
        'talk_categories_id',
        'talk_subcategories_id',
        'state',
        'reviews',
        'ratings',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // protected
    //     $casts = [
    //     'price' => 'integer',
    // ];

    const ANONYM_CALL = [
        'not_allowed' => '0',
        'allowed'     => '1',
    ];

    const CALL_TYPE = [
        'voice_call'               => '1',
        'video_call'               => '2',
        'voice_call or video_call' => '3',
    ];

    const TALK_TYPE = [
        'face_to_face' => '1',
        'group'        => '2',
    ];

    const STATE = [
        'deleted'       => '0',
        'valid'         => '1',
        'paused'        => '2',
        'updated'       => '3',
        'inappropriate' => '4',
    ];

    const TALK_DAYS_IN_ADVANCE = 22;

    /**
     * Scope a query to only include talks from eligible suppliers.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeWithEligibleSuppliers($query)
    {
        $user = request()->has('logged_user_id')
            ? User::query()->find(request()->input('logged_user_id'))
            : auth()->user();

        $blockedSuppliers = $user
            ? $user
                ->blockedUsers()
                ->pluck('blocked_user_id')
                ->toArray()
            : [];

        $followedSuppliers = $user
            ? $user
                ->followings()
                ->where('user_followeds.state', UserFollowed::STATE['valid'])
                ->whereNotIn('follower_user_id', $blockedSuppliers)
                ->pluck('follower_user_id')
                ->toArray()
            : [];

        return $query->whereHas('supplier', function ($query) use ($user, $followedSuppliers, $blockedSuppliers) {
            $query
                ->join('user_verification_requests', 'users.id', '=', 'user_verification_requests.user_id')
                ->join('availabilities', 'users.id', '=', 'availabilities.user_id')
                // ->where('users.id', '!=', $user ? $user->id : 0) // TODO: re-enable in production to hide own talks from search
                ->where('approved', User::STATE['approved'])
                ->where('type', User::TYPE['supplier'])
                ->where('user_verification_requests.status', UserVerificationRequests::STATE['approved'])
                ->where('availabilities.state', Availability::STATE['valid'])
                ->whereNotIn('users.id', $blockedSuppliers)
                ->where(function ($query) use ($followedSuppliers) {
                    $query->where('visibility', User::VISIBILITY['open']);
                    $query->orWhereIn('users.id', $followedSuppliers);
                });
        });
    }

    /* Relationship declarations
       ============================== */

    public function talk_bookings()
    {
        return $this->hasMany(Booking::class, 'talk_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(TalkCategories::class, 'talk_categories_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(TalkSubcategories::class, 'talk_subcategories_id');
    }

    public function teacher_user()
    {
        return $this->belongsTo(User::class, 'teacher_user_id');
    }

    /**
     * Each talk belongs to a User/Teacher.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_user_id');
    }

    /**
     * Each talk belongs to a Supplier.
     */
    public function supplier()
    {
        return $this->belongsTo(User::class, 'teacher_user_id');
    }

    /**
     * Each talk has many Availabilities.
     */
    public function availabilities()
    {
        return $this->hasManyThrough(Availability::class, Talk::class, 'id', 'user_id', 'id', 'teacher_user_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'languages_id');
    }

    public function finance_currencies()
    {
        return $this->belongsTo(FinanceCurrency::class, 'finance_currencies_id');
    }

    public function billing_address()
    {
        return $this->belongsTo(BillingAddress::class, 'billing_address_id');
    }

    public function followers_count()
    {
        return $this->hasMany(UserBookmarkedTalks::class, 'talks_id')->where('state', true);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function talkReviews()
    {
        return $this->hasManyThrough(Feedback::class, Booking::class);
    }

    /**
     * Each talk is bookmarked by many Users/Fans.
     */
    public function fans()
    {
        return $this->hasManyThrough(User::class, UserBookmarkedTalks::class, 'talks_id', 'id', 'id', 'user_id');
    }

    /**
     * Slots that the Talk is booked for.
     *
     * @return HasMany
     */
    public function bookedSlots(): HasMany
    {
        return $this->hasMany(BookingsBookedSlots::class);
    }

    /* Methods
       ============================== */

    /**
     * Determine whether the talk has been bookmarked by the User.
     *
     * @param  User  $user
     *
     * @return bool
     */
    public function isBookmarkedBy(User $user)
    {
        return $this->fans()->where('name', '=', $user->name)->exists();
    }

    /**
     * Get full Talk Details by ID.
     *
     * @param  int  $id  Talk ID
     *
     * @return mixed
     */
    public function getTalkById($id)
    {
        $langauge = StaticProfession::DATABASE_LANGUAGE[request()->header('Application-Language', 'en')];

        return $this
            ->select([
                'users.id as teacher_id',
                'users.name as teacher_name',
                'users.username as teacher_username',
                'users.profile_picture as teacher_profile_picture',
                'talks.id',
                'talks.duration',
                'talks.headline',
                'talks.call_type',
                'talks.talk_type',
                'talks.interactive_mode',
                'talks.description',
                'talks.max_participiants',
                'talks.price',
                'talks.anonym_call as is_anonymous_allowed',
                'talks.start_time_call',
                'talks.end_time_call',
                'talks.weekday',
                'talks.talk_categories_id as talk_category_id',
                'talks.talk_subcategories_id as talk_subcategory_id',
                "talk_categories.{$langauge} as talk_category_name",
                "talk_subcategories.{$langauge} as talk_subcategory_name",
                'languages_id',
                "languages.{$langauge} as language_name",
                'talks.finance_currencies_id',
                'taken_slots'  => Booking::select(DB::raw('COUNT(*)'))->where('id', $id),
                'bookings.start_call as start_call_date',
                'talks.state',
                'taken_places' => DB::table('talks')->selectRaw('CASE WHEN taken_slots > 0 THEN taken_slots ELSE 0 END AS taken_places')->where('id', $id),
                'talks.reviews as total_reviews',
                'ratings'      => DB::table('talks')->selectRaw('CASE WHEN reviews > 0 THEN ROUND(ratings::NUMERIC / reviews::NUMERIC, 1) ELSE 0 END AS ratings')->where('id', $id),
            ])
            ->selectRaw('CASE WHEN user_bookmarked_talks.state = 1 THEN 1 ELSE 0 END AS is_favorite')
            ->join('users', 'talks.teacher_user_id', '=', 'users.id')
            ->join('talk_categories', 'talks.talk_categories_id', '=', 'talk_categories.id')
            ->join('talk_subcategories', 'talks.talk_subcategories_id', '=', 'talk_subcategories.id')
            ->join('languages', 'talks.languages_id', '=', 'languages.id')
            ->leftJoin('user_bookmarked_talks', function ($query) {
                $query->on('user_bookmarked_talks.talks_id', '=', 'talks.id')
                    ->where('user_bookmarked_talks.user_id', '=', auth()->id())
                    ->whereNull('user_bookmarked_talks.deleted_at');
            })
            ->leftJoin('bookings', 'talks.id', '=', 'bookings.talk_id')
            ->withCount('followers_count as countFollowers')
            ->withCount('talk_bookings as bookingsCount')
            ->find($id);
    }

    /**
     * Get Reviews for a Talk
     *
     * @param  ?int  $offset  Results offset.
     * @param  ?int  $limit   Results limit.
     */
    public function getTalkReviews(?int $offset, ?int $limit)
    {
        return $this->talk_bookings()
            ->whereHas('talksFeedback')
            ->join('feedback', 'bookings.id', '=', 'feedback.booking_id')
            ->join('users', 'feedback.user_id', '=', 'users.id')
            ->select([
                'users.id as reviewer_id',
                'users.name as reviewer_name',
                'users.profile_picture as reviewer_profile_picture',
                'feedback.description as comment',
                'feedback.created_at as review_date',
                'feedback.stars_content as rating',
            ])
            ->offset($offset ?: 0)
            ->limit($limit ?: 5)
            ->get();
    }

    /**
     * Get Reviews for a Talk
     */
    public function getTalkReviewsCount()
    {
        return $this->talk_bookings()
            ->whereHas('talksFeedback')
            ->join('feedback', 'bookings.id', '=', 'feedback.booking_id')
            ->join('users', 'feedback.user_id', '=', 'users.id')
            ->select([
                'users.id as reviewer_id',
                'users.name as reviewer_name',
                'users.profile_picture as reviewer_profile_picture',
                'feedback.description as comment',
                'feedback.created_at as review_date',
                'feedback.stars_content as rating',
            ])
            ->count();
    }

    /* Accessors/Mutators
       ============================== */

    /**
     * Get the Type of the Talk.
     *
     * @return string
     */
    public function getTalkAttribute()
    {
        return $this->talkTypes['talk'][$this->talk_type];
    }

    /**
     * Get the Type of the Call.
     *
     * @return string
     */
    public function getCallAttribute()
    {
        return $this->talkTypes['call'][$this->call_type];
    }
}