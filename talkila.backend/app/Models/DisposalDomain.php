<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * App\Models\DisposalDomain
 *
 * @property int $id
 * @property string|null $domain
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalDomain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalDomain newQuery()
 * @method static \Illuminate\Database\Query\Builder|DisposalDomain onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalDomain query()
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalDomain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalDomain whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalDomain whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalDomain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalDomain whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|DisposalDomain withTrashed()
 * @method static \Illuminate\Database\Query\Builder|DisposalDomain withoutTrashed()
 * @mixin \Eloquent
 */
class DisposalDomain extends Model
{
    use SoftDeletes;

    public $table = 'disposal_domains';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'domain',
        'statistics',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
