<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\DisposalEmail
 *
 * @property int $id
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalEmail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalEmail newQuery()
 * @method static \Illuminate\Database\Query\Builder|DisposalEmail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalEmail query()
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalEmail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalEmail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalEmail whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalEmail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalEmail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|DisposalEmail withTrashed()
 * @method static \Illuminate\Database\Query\Builder|DisposalEmail withoutTrashed()
 * @mixin \Eloquent
 */
class DisposalEmail extends Model
{
    use SoftDeletes;

    public $table = 'disposal_emails';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'email',
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
