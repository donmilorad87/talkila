<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * App\Models\LanguagesProfil
 *
 * @property int $id
 * @property int|null $level
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $user_id
 * @property int $language_id
 * @property-read \App\Models\Language $language
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|LanguagesProfil newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LanguagesProfil newQuery()
 * @method static \Illuminate\Database\Query\Builder|LanguagesProfil onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|LanguagesProfil query()
 * @method static \Illuminate\Database\Eloquent\Builder|LanguagesProfil whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguagesProfil whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguagesProfil whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguagesProfil whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguagesProfil whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguagesProfil whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguagesProfil whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|LanguagesProfil withTrashed()
 * @method static \Illuminate\Database\Query\Builder|LanguagesProfil withoutTrashed()
 * @mixin \Eloquent
 */
class LanguagesProfil extends Model
{
    use SoftDeletes;

    public $table = 'languages_profils';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'language_id',
        'level',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const LEVEL = [
      '0' => 'not specified',
      '1' => 'native',
      '2' => 'A1',
      '3' => 'A2',
      '4' => 'B1',
      '5' => 'B2',
      '6' => 'C1',
      '7' => 'C2',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
