<?php

namespace App\Models\Affiliates;

use Illuminate\Database\Eloquent\Model;
use \DateTimeInterface;

/**
 * Class UserCurrencyTypePricing
 *
 * @package App\Models
 * @property int $affiliate_id
 * @property int $affiliates_sub_id
 * @property string $date
 * @property string $month
 * @property int $registrations
 * @property string $paypal
 * @property int $revenue
 * @property int $stage_1
 * @property int $stage_2
 * @property int $stage_3
 * @property string $created_at
 * @property string $updated_at
 * @property int $id

 * @mixin \Eloquent
 */
class AffiliateRevenuePerMonth extends Model
{
    public $table = 'affiliate_revenue_per_month';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'affiliate_id',
        'affiliates_sub_id',
        'date',
        'month',
        'registrations',
        'paypal',
        'revenue',
        'stage_1',
        'stage_2',
        'stage_3',
        'created_at',
        'updated_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function affiliate_sub()
    {
        return $this->belongsTo(Subaffiliate::class, 'affiliates_sub_id', 'id');
    }
}
