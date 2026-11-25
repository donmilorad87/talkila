<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * App\Models\FinanceCurrency
 *
 * @property int $id
 * @property string|null $iso_code
 * @property string|null $short_code
 * @property string|null $name
 * @property string|null $value
 * @property string|null $symbol
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Booking[] $financeCurrenciesBookings
 * @property-read int|null $finance_currencies_bookings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payout[] $financeCurrenciesPayouts
 * @property-read int|null $finance_currencies_payouts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Talk[] $financeCurrenciesTalks
 * @property-read int|null $finance_currencies_talks_count
 * @method static \Illuminate\Database\Eloquent\Builder|FinanceCurrency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinanceCurrency newQuery()
 * @method static \Illuminate\Database\Query\Builder|FinanceCurrency onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FinanceCurrency query()
 * @method static \Illuminate\Database\Eloquent\Builder|FinanceCurrency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinanceCurrency whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinanceCurrency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinanceCurrency whereIsoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinanceCurrency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinanceCurrency whereShortCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinanceCurrency whereSymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinanceCurrency whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinanceCurrency whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|FinanceCurrency withTrashed()
 * @method static \Illuminate\Database\Query\Builder|FinanceCurrency withoutTrashed()
 * @mixin \Eloquent
 */
class FinanceCurrency extends Model
{
    use SoftDeletes;

    public $table = 'finance_currencies';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'iso_code',
        'short_code',
        'name',
        'value',
        'symbol',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function financeCurrenciesPayouts()
    {
        return $this->hasMany(Payout::class, 'finance_currencies_id', 'id');
    }

    public function financeCurrenciesBookings()
    {
        return $this->hasMany(Booking::class, 'finance_currencies_id', 'id');
    }

    public function financeCurrenciesTalks()
    {
        return $this->hasMany(Talk::class, 'finance_currencies_id', 'id');
    }
}
