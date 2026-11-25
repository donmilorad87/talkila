<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * App\Models\StaticForbiddenName
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|StaticForbiddenName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticForbiddenName newQuery()
 * @method static \Illuminate\Database\Query\Builder|StaticForbiddenName onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticForbiddenName query()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticForbiddenName whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticForbiddenName whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticForbiddenName whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticForbiddenName whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticForbiddenName whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|StaticForbiddenName withTrashed()
 * @method static \Illuminate\Database\Query\Builder|StaticForbiddenName withoutTrashed()
 * @mixin \Eloquent
 */
class StaticForbiddenName extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'static_forbidden_names';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
