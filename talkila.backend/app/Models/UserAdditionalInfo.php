<?php

namespace App\Models;

use App\Traits\Serializable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAdditionalInfo extends Model
{
    use HasFactory, Serializable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_additional_info';

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    /* Relationships
       ============================== */

    /**
     * User that the owns the Permission.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /* Accessors/Mutators
       ============================== */

    /**
     * Decode the data prior to saving it.
     */
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = isMobileApp()
            ? json_decode(json_encode($value), true)
            : json_decode($value, true);
    }
}
