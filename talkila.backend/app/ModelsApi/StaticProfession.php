<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\StaticProfession
 *
 * @property int $id
 * @property string|null $croatian
 * @property string|null $german
 * @property string|null $english
 * @property string|null $spanish
 * @property string|null $french
 * @property string|null $italien
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProfilCv[] $professionProfilCvs
 * @property-read int|null $profession_profil_cvs_count
 * @method static \Illuminate\Database\Eloquent\Builder|StaticProfession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticProfession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticProfession query()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticProfession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticProfession whereCroatian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticProfession whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticProfession whereEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticProfession whereFrench($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticProfession whereGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticProfession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticProfession whereItalien($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticProfession whereSpanish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticProfession whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StaticProfession extends Models\StaticProfession
{
    protected static function boot()
    {
        parent::boot();
    }
}
