<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\FinanceCurrency
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
 * @mixin \Eloquent
 */
class FinanceCurrency extends Models\FinanceCurrency
{
    protected static function boot()
    {
        parent::boot();
    }
}
