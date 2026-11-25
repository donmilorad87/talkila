<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\Serializable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserBookmarkedTalks extends Model
{
    use SoftDeletes, Auditable, Serializable, SoftDeletes;

    public $table = 'user_bookmarked_talks';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'talks_id',
        'state',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATE = [
        'not_valid' => '0',
        'valid'     => '1'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function talk()
    {
        return $this->belongsTo(Talk::class, 'talks_id');
    }
}
