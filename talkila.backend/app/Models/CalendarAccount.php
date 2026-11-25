<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalendarAccount extends Model
{
    use HasFactory;
    use SoftDeletes;

    const GOOGLE = 1;

    const DISABLED      = 0;
    const CLIENT_ONLY   = 1;
    const SUPPLIER_ONLY = 2;
    const BOTH          = 3;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'user_id',
        'email',
        'calendar_provider',
        'access_token',
        'refresh_token',
        'expires_at',
        'state',
        'is_synchronized',
        'is_primary',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * User that owns the Calendar Account.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calendars that belong to the Calendar Account.
     *
     * @return HasMany
     */
    public function calendars(): HasMany
    {
        return $this->hasMany(Calendar::class, 'calendar_account_id');
    }

    /**
     * Returns primary calendar.
     */
    public function primary()
    {
        return $this->calendars()->where('name', $this->email)->first();
    }

    /**
     * Returns Talkila calendar.
     */
    public function talkila()
    {
        return $this->calendars()->where('name', 'Talkila Bookings')->first();
    }
}
