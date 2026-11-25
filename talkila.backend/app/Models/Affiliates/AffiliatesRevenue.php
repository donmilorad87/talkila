<?php

namespace App\Models\Affiliates;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * Class UserCurrencyTypePricing
 *
 * @package App\Models
 * @property int $user_id
 * @property int $affiliates_sub_id
 * @property int $affiliates_sub_affiliate_id
 * @property string $revenue
 * @property string $created_at
 * @property string $updated_at
 * @property int $id

 * @mixin \Eloquent
 */
class AffiliatesRevenue extends Model
{
    public $table = 'affiliates_revenue';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'affiliates_sub_id',
        'affiliates_sub_affiliate_id',
        'revenue',
        'created_at',
        'updated_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
