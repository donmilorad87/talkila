<?php

namespace App\Models;

use App\Traits\Serializable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PartnerDashboard extends Model
{
    use HasFactory, Serializable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    public $fillable = [
        'partner_id',
        'total_new_registrations',
        'total_jtc_finished',
        'total_jtc_verified',
        'total_active_users',
        'total_bookings',
        'total_bookings_cancelled',
        'total_revenue',
        'total_revenue',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    public $casts = [
        'total_revenue' => 'float',
    ];

    /**
     * Get the Partner that owns the Dashboard.
     *
     * @return BelongsTo
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    /**
     * Get the Weekly Dashboard that belongs to the Dashboard.
     *
     * @return HasOne
     */
    public function weekly(): HasOne
    {
        return $this->hasOne(PartnerDashboardWeekly::class);
    }
}
