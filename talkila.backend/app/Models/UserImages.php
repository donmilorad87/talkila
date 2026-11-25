<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserVerificationRequests
 *
 * @package App\Models
 * @property int $user_id
 * @property string $image
 * @property int $state
 * @property string $size
 * @property string $created_at
 * @property string $updated_at
 * @property int $id
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserImages newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserImages newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserImages query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserImages whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserImages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserImages whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserImages whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserImages whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserImages whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserImages whereUserId($value)
 * @mixin \Eloquent
 */
class UserImages extends Model
{
    use Auditable;

    public $table = 'user_images';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'user_id',
        'image',
        'state',
        'size',
        'created_at',
        'updated_at',
    ];

    const STATE = [
      'pending'     => '0',
      'approved'    => '1',
      'declined'    => '2',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }
}
