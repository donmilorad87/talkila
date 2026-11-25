<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * App\Models\Language
 *
 * @property int $id
 * @property string $code
 * @property string $croatian
 * @property string $english
 * @property string $german
 * @property string|null $french
 * @property string|null $dutch
 * @property string|null $czech
 * @property string|null $romanian
 * @property string|null $italian
 * @property string|null $spanish
 * @property string|null $polish
 * @property string|null $bulgarian
 * @property string|null $turkish
 * @property string|null $danish
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LanguagesProfil[] $languageLanguagesProfils
 * @property-read int|null $language_languages_profils_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Talk[] $languagesTalks
 * @property-read int|null $languages_talks_count
 * @method static \Illuminate\Database\Eloquent\Builder|Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language newQuery()
 * @method static \Illuminate\Database\Query\Builder|Language onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereBulgarian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereCroatian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereCzech($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereDanish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereDutch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereFrench($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereItalian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language wherePolish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereRomanian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereSpanish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereTurkish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Language withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Language withoutTrashed()
 * @mixin \Eloquent
 */
class Language extends Model
{
    use SoftDeletes;

    public $table = 'languages';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'order_by',
        'code',
        'croatian',
        'english',
        'german',
        'french',
        'dutch',
        'czech',
        'romanian',
        'italian',
        'spanish',
        'danish',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function languageLanguagesProfils()
    {
        return $this->hasMany(LanguagesProfil::class, 'language_id', 'id');
    }

    public function languagesTalks()
    {
        return $this->hasMany(Talk::class, 'languages_id', 'id');
    }

    /* Accessors/Mutators
       ============================== */

    /**
     * Get the Language name depending on the User selected language.
     *
     * @return mixed
     */
    public function getNameAttribute() {
        switch (Str::lower(session('language'))) {
            case('de'):
                return $this->german;
            case('hr'):
                return $this->croatian;
            default:
                return $this->english;
        }
    }
}
