<?php

namespace App\Models;

use App\Traits\Serializable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerUser extends Model
{
    use HasFactory, Serializable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    public $fillable = [
        'partner_id',
        'username',
        'name',
        'username',
        'email',
        'image',
        'description',
        'country',
        'language',
        'is_unique',
        'hash',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    public $casts = [
        'is_unique' => 'boolean',
    ];

    /**
     * Get the Partner that owns the User.
     *
     * @return BelongsTo
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function dashboard()
    {
        return $this->hasOneThrough(PartnerDashboard::class, Partner::class, 'id', 'partner_id');
    }
}
