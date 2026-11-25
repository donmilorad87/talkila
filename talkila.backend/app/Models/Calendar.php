<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calendar extends Model
{
    use HasFactory, SoftDeletes;

    const GOOGLE = 1;

    const INACTIVE = 0;
    const ACTIVE   = 1;
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id',
        'user_id',
        'calendar_account_id',
        'calendar_id',
        'sync_token',
        'resource_id',
        'watcher_id',
        'name',
        'timezone',
        'color',
        'state',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * User that owns the Calendars.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calendar Account that owns the Calendars.
     *
     * @return BelongsTo
     */
    public function calendarAccount(): BelongsTo
    {
        return $this->belongsTo(CalendarAccount::class, 'calendar_account_id', 'id');
    }

    /**
     * Events associated with the Calendar.
     *
     * @return BelongsToMany
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }
}
