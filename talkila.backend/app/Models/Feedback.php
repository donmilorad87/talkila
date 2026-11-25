<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Feedback extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable;

    public $table = 'feedback';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'booking_id',
        'stars_content',
        'stars_voice_quality',
        'description',
        'state',
        'anonym',
        'user_role',
        'under_review_status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const TYPE = [
      'received'    => '0',
      'given'       => '1'
    ];

    const USER_ROLE = [
        'participant'   => '1',
        'teacher'       => '2',
    ];

    const STARS_CONTENT = [
        '0' => 'bad',
        '1' => 'very good'
    ];

    const REVIEW_STATUS = [
        'not_reviewed'      => '0',
        'no_refund'         => '1',
        'soft_refund'       => '2',
        'hard_refund'       => '3',
        'no_action_refund'  => '4'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function calls()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
