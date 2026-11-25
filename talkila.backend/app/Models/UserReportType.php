<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * App\Models\UserReportType
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $croatian
 * @property string|null $english
 * @property string|null $german
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
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportType newQuery()
 * @method static \Illuminate\Database\Query\Builder|UserReportType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportType query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportType whereCroatian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportType whereEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportType whereGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|UserReportType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|UserReportType withoutTrashed()
 * @mixin \Eloquent
 */
class UserReportType extends Model
{
    use SoftDeletes;

    public $table = 'user_report_types';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'state',
        'type',
        'croatian',
        'english',
        'german',
        'french',
        'dutch',
        'czech',
        'romanian',
        'italian',
        'spanish',
        'polish',
        'bulgarian',
        'turkish',
        'danish',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const TYPE = [
        'teacher_reasons'   => 1,
        'talk_reasons'      => 2,
    ];

    const STATE = [
        'not_valid' => '0',
        'valid'     => '1',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
