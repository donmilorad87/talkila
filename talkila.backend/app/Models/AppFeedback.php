<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use \DateTimeInterface;

/**
 * App\Models\AppFeedback
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AppFeedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppFeedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppFeedback query()
 * @mixin \Eloquent
 */
class AppFeedback extends Model
{
    use Auditable;

    public $table = 'app_feedback';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'user_id',
        'rating',
        'comment',
        'state',
        'created_at',
        'updated_at',
    ];

    const STATE = [
        'inactive'  => '0',
        'active'    => '1'
    ];

    const STARS_CONTENT = [
        '0' => 'bad',
        '1' => 'very good'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
