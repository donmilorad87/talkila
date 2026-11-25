<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * App\Models\ProfilPayoutMethod
 *
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilPayoutMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilPayoutMethod newQuery()
 * @method static \Illuminate\Database\Query\Builder|ProfilPayoutMethod onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilPayoutMethod query()
 * @method static \Illuminate\Database\Query\Builder|ProfilPayoutMethod withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProfilPayoutMethod withoutTrashed()
 * @mixin \Eloquent
 */
class ProfilPayoutMethod extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'payouts_methods';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'method',
        'value',
        'state',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const METHOD = [
        'iban'      => '1',
        'paypal'    => '2',
    ];

    const STATE = [
        'not_valid' => '0',
        'valid'     => '1',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
