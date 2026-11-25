<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingsBookedSlots extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'booking_id',
        'talk_id',
        'teacher_user_id',
        'participant_user_id',
        'slot_datetime',
        'slot_date',
        'slot_time',
        'updated_at',
        'deleted_at',
    ];

    /**
     * User that owns the Booking slot.
     *
     * @return BelongsTo
     */
    public function teacher_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_user_id');
    }

    /**
     * User that booked the Booking slot.
     *
     * @return BelongsTo
     */
    public function participant_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'participant_user_id');
    }

    /**
     * Booking that owns the Booking slot.
     *
     * @return BelongsTo
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Talk that owns the Booking slot.
     *
     * @return BelongsTo
     */
    public function talk(): BelongsTo
    {
        return $this->belongsTo(Talk::class);
    }
}
