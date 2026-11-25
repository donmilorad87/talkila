<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * App\Models\StaticProfession
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
 * @method static \Illuminate\Database\Query\Builder|StaticProfession onlyTrashed()
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
 * @method static \Illuminate\Database\Query\Builder|StaticProfession withTrashed()
 * @method static \Illuminate\Database\Query\Builder|StaticProfession withoutTrashed()
 * @mixin \Eloquent
 */
class StaticProfession extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'static_professions';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'croatian',
        'german',
        'english',
        'spanish',
        'french',
        'italien',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

     public const DATABASE_LANGUAGE = [
        'de' => 'german',
        'en' => 'english',
        'hr' => 'croatian',
        'pl' => 'polish'
     ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function professionProfilCvs()
    {
        return $this->hasMany(ProfilCv::class, 'profession_id', 'id');
    }
}
