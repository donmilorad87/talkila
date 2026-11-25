<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use \DateTimeInterface;

/**
 * App\Models\SuggestionsHomeScreen
 *
 * @property int $id
 * @property int $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $user_id
 * @property-read \App\Models\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|SuggestionsHomeScreen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuggestionsHomeScreen newQuery()
 * @method static \Illuminate\Database\Query\Builder|SuggestionsHomeScreen onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SuggestionsHomeScreen query()
 * @method static \Illuminate\Database\Eloquent\Builder|SuggestionsHomeScreen whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuggestionsHomeScreen whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuggestionsHomeScreen whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuggestionsHomeScreen whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuggestionsHomeScreen whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuggestionsHomeScreen whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|SuggestionsHomeScreen withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SuggestionsHomeScreen withoutTrashed()
 * @mixin \Eloquent
 */
class SuggestionsHomeScreen extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'suggestions_home_screen';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'state',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATE = [
        'not_valid'   => '0',
        'valid'       => '1'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
