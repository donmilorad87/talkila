<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * App\Models\TalkReported
 *
 * @property int $id
 * @property string|null $reason_text
 * @property int $reason_id
 * @property int $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $user_id
 * @property int|null $reported_talk_id
 * @mixin \Eloquent
 */
class TalkReported extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'reported_talks';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'reported_talk_id',
        'reason_id',
        'reason_text',
        'state',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    const STATE = [
        'not_valid' => 0,
        'valid'     => 1,
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function talk()
    {
        return $this->belongsTo(Talk::class, 'reported_talk_id');
    }
}
