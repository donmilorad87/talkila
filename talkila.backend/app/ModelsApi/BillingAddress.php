<?php

namespace App\ModelsApi;

use App\Models;
use App\Scopes\UserApiScope;

/**
 * App\ModelsApi\BillingAddress
 *
 * @property int $id
 * @property string|null $prename
 * @property string|null $lastname
 * @property string|null $street
 * @property string|null $zipcode
 * @property string|null $city
 * @property string|null $company_name
 * @property string|null $iban_recipient_name
 * @property string|null $tax_number
 * @property string|null $email
 * @property string|null $tel_number
 * @property int|null $vat
 * @property int $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $countries_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Talk[] $billingAddressTalks
 * @property-read int|null $billing_address_talks_count
 * @property-read \App\Models\Country|null $countries
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingAddress newQuery()
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
 * @mixin \Eloquent
 */
class BillingAddress extends Models\BillingAddress
{
    protected static function boot()
    {
        parent::boot();
    }
}
