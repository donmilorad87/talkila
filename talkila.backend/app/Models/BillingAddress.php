<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserCurrencyTypePricing
 *
 * @package App\Models
 * @property int                                                              $user_id
 * @property string                                                           $street
 * @property string                                                           $zipcode
 * @property string                                                           $city
 * @property string                                                           $company_name
 * @property string                                                           $tax_number
 * @property string                                                           $email
 * @property string                                                           $tel_number
 * @property string                                                           $vat
 * @property int                                                              $state
 * @property int                                                              $countries_id
 * @property string                                                           $created_at
 * @property string                                                           $updated_at
 * @property string                                                           $deleted_at
 * @property int                                                              $id
 * @property string|null                                                      $prename
 * @property string|null                                                      $lastname
 * @property string|null                                                      $iban_recipient_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Talk[] $billingAddressTalks
 * @property-read int|null                                                    $billing_address_talks_count
 * @property-read \App\Models\Country|null                                    $countries
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress newQuery()
 * @method static \Illuminate\Database\Query\Builder|BillingAddress onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereCountriesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereIbanRecipientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress wherePrename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereTaxNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereTelNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress whereZipcode($value)
 * @method static \Illuminate\Database\Query\Builder|BillingAddress withTrashed()
 * @method static \Illuminate\Database\Query\Builder|BillingAddress withoutTrashed()
 * @mixin \Eloquent
 */
class BillingAddress extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'billing_addresses';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'street',
        'zipcode',
        'city',
        'company_name',
        'iban_recipient_name',
        'tax_number',
        'email',
        'tel_number',
        'vat',
        'pays_vat',
        'state',
        'countries_id',
        'user_id',
        /* 'type', */
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATE = [
        'not_valid' => '0',
        'valid'     => '1',
    ];

/*     const TYPE = [
        'supplier'   => 0,
        'client'     => 1,
    ]; */

    const DEFAULT_COUNTRY = 84; //Germany

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function billingAddressTalks()
    {
        return $this->hasMany(Talk::class, 'billing_address_id', 'id');
    }

    public function countries()
    {
        return $this->belongsTo(Country::class, 'countries_id');
    }
}
