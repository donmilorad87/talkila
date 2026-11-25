<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\Serializable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\JoinTheClub
 *
 * @method static \Illuminate\Database\Eloquent\Builder|JoinTheClub newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JoinTheClub newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JoinTheClub query()
 * @mixin \Eloquent
 */
class JoinTheClub extends Model
{
    use Auditable, Serializable;

    public $table = 'jtc';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'users_id',
        'jtc_started',
        'state',
        'step_1',
        'step_2',
        'step_3',
        'step_4',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'jtc_started' => 'boolean',
        'step_1'      => 'boolean',
        'step_2'      => 'boolean',
        'step_3'      => 'boolean',
        'step_4'      => 'boolean',
    ];

    const STATE = [
        'not_finished'      => '0',
        'sent_notification' => '1',
        'verified'          => '2',
    ];

    /**
     * Determine if the JTC process has been completed.
     *
     * @return bool
     */
    public function getAvailableAttribute(): bool
    {
        return $this->step_1 + $this->step_2 + $this->step_3 + $this->step_4 === 4;
    }

    /**
     * Return JTC Availability progress.
     *
     * @return int
     */
    public function getAvailabilityAttribute(): int
    {
        return intval((100 / 6) * ($this->step_1 + $this->step_2 + $this->step_3 + $this->step_4));
    }

    /**
     * Return JTC last completed step.
     *
     * @return int
     */
    public function getCompletedStepAttribute(): int
    {
        return intval($this->step_1 + $this->step_2 + $this->step_3 + $this->step_4);
    }
}
