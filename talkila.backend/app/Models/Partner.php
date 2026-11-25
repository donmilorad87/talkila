<?php

namespace App\Models;

use App\Traits\Serializable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Partner extends Authenticatable
{
    use HasFactory, Serializable;

    const NEW_ACCOUNT              = 0;
    const HAS_ACCOUNT_NOT_VERIFIED = 1;
    const HAS_ACCOUNT_VERIFIED     = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    public $fillable = [
        'name',
        'email',
        'slug',
        'icon',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the Users for the Partner.
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the Partner Users for the Partner.
     *
     * @return HasMany
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(PartnerUser::class, 'partner_id');
    }

    /**
     * Get the Dashboard that the Partner owns.
     *
     * @return hasOne
     */
    public function dashboard(): hasOne
    {
        return $this->hasOne(PartnerDashboard::class);
    }

    /**
     * Create a new Partner account.
     *
     * @param  array  $data    Account data.
     * @param  bool   $unique  Indicates if the account is unique.
     *
     * @return void
     */
    public function createAccount(array $data, bool $unique): void
    {
        if ($this->accounts()->where('email', '=', $data['email'])->exists()) {
            return;
        }

        $this->accounts()->create(array_merge($data, ['is_unique' => $unique, 'hash' => sha1($data['email'])]));
    }

    /**
     * Hash Partner's password prior to saving it.
     *
     * @param $value
     *
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
