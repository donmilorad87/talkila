<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\Serializable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * App\Models\Country
 *
 * @property int $id
 * @property string|null $short_code
 * @property string|null $english
 * @property string|null $german
 * @property string|null $croatian
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $shorter_code
 * @property string|null $spanish
 * @property string|null $french
 * @property string|null $italian
 * @property string|null $dutch
 * @property string|null $polish
 * @property string|null $danish
 * @property string|null $hungarian
 * @property string|null $portuguese
 * @property string|null $russian
 * @property string|null $turkish
 * @property string|null $bulgarian
 * @property string|null $romanian
 * @property string|null $slovak
 * @property string|null $czech
 * @method static Builder|Country newModelQuery()
 * @method static Builder|Country newQuery()
 * @method static \Illuminate\Database\Query\Builder|Country onlyTrashed()
 * @method static Builder|Country query()
 * @method static Builder|Country whereBulgarian($value)
 * @method static Builder|Country whereCreatedAt($value)
 * @method static Builder|Country whereCroatian($value)
 * @method static Builder|Country whereCzech($value)
 * @method static Builder|Country whereDanish($value)
 * @method static Builder|Country whereDeletedAt($value)
 * @method static Builder|Country whereDutch($value)
 * @method static Builder|Country whereEnglish($value)
 * @method static Builder|Country whereFrench($value)
 * @method static Builder|Country whereGerman($value)
 * @method static Builder|Country whereHungarian($value)
 * @method static Builder|Country whereId($value)
 * @method static Builder|Country whereItalian($value)
 * @method static Builder|Country wherePolish($value)
 * @method static Builder|Country wherePortuguese($value)
 * @method static Builder|Country whereRomanian($value)
 * @method static Builder|Country whereRussian($value)
 * @method static Builder|Country whereShortCode($value)
 * @method static Builder|Country whereShorterCode($value)
 * @method static Builder|Country whereSlovak($value)
 * @method static Builder|Country whereSpanish($value)
 * @method static Builder|Country whereTurkish($value)
 * @method static Builder|Country whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Country withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Country withoutTrashed()
 * @mixin \Eloquent
 */
class Country extends Model
{
    const GERMANY = 84;

    use Serializable, SoftDeletes, Auditable;

    public $table = 'countries';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'short_code',
        'shorter_code',
        'vat_value',
        'german',
        'croatian',
        'created_at',
        'updated_at',
        'deleted_at',
        'spanish',
        'french',
        'italian',
        'dutch',
        'polish',
        'danish',
        'hungarian',
        'portuguese',
        'russian',
        'turkish',
        'bulgarian',
        'romanian',
        'slovak',
        'czech',
    ];

    /**
     * Scope a query to only include Countries that have VAT.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeWhereHasVAT($query)
    {
        return $query->whereNotNull('vat_value');
    }

    /**
     * Get the name depending on the User selected language.
     *
     * @return mixed
     */
    public function getNameAttribute() {
        switch (Str::upper(session('language'))) {
            case('DE'):
                return $this->german;
            case('HR'):
                return $this->croatian;
            default:
                return $this->english;
        }
    }
}
