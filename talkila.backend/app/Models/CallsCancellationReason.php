<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\Serializable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\CallsCancellationReason
 *
 * @property int $id
 * @property string $croatian
 * @property string $german
 * @property string $english
 * @property int|null $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Booking[] $cancellationReasonBookings
 * @property-read int|null $cancellation_reason_bookings_count
 * @method static \Illuminate\Database\Eloquent\Builder|CallsCancellationReason newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CallsCancellationReason newQuery()
 * @method static \Illuminate\Database\Query\Builder|CallsCancellationReason onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CallsCancellationReason query()
 * @method static \Illuminate\Database\Eloquent\Builder|CallsCancellationReason whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallsCancellationReason whereCroatian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallsCancellationReason whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallsCancellationReason whereEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallsCancellationReason whereGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallsCancellationReason whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallsCancellationReason whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CallsCancellationReason whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|CallsCancellationReason withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CallsCancellationReason withoutTrashed()
 * @mixin \Eloquent
 */
class CallsCancellationReason extends Model
{
    use SoftDeletes, Auditable, Serializable;

    public $table = 'calls_cancellation_reasons';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'croatian',
        'german',
        'english',
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
        'state',
        'type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATE = [
        'not_valid'   => '0',
        'valid'       => '1'
    ];

    public function cancellationReasonBookings()
    {
        return $this->hasMany(Booking::class, 'cancellation_reason_id', 'id');
    }
}