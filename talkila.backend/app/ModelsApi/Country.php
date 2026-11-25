<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\Country
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
 * @method static \Illuminate\Database\Eloquent\Builder|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereBulgarian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCroatian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCzech($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereDanish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereDutch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereFrench($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereHungarian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereItalian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country wherePolish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country wherePortuguese($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereRomanian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereRussian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereShortCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereShorterCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereSlovak($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereSpanish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereTurkish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Country extends Models\Country
{
    protected static function boot()
    {
        parent::boot();
    }
}
