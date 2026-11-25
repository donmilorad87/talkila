<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\Feedback
 *
 * @property int $id
 * @property int|null $stars_content
 * @property int|null $stars_voice_quality
 * @property string|null $description
 * @property int|null $state
 * @property int|null $anonym
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $participiant_id
 * @property int|null $calls_id
 * @property-read \App\Models\Booking $calls
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User $participiant
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback query()
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereCallsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereParticipiantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereStarsContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereStarsVoiceQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feedback whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Feedback extends Models\Feedback
{
    protected static function boot()
    {
        parent::boot();
    }
}
