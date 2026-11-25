<?php

namespace App\ModelsApi;

use App\Models;
use App\Scopes\TeacherApiScope;

/**
 * App\ModelsApi\Talk
 *
 * @property-read \App\Models\BillingAddress $billing_address
 * @property-read \App\Models\FinanceCurrency $finance_currencies
 * @property-read \App\Models\Language $languages
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Booking[] $talk_bookings
 * @property-read int|null $talk_bookings_count
 * @property-read \App\Models\TalkCategories $talksCategories
 * @property-read \App\Models\User $teacher_user
 * @method static \Illuminate\Database\Eloquent\Builder|Talk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Talk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Talk query()
 * @mixin \Eloquent
 */
class Talk extends Models\Talk
{
    protected static function boot()
    {
        parent::boot();
    }
}
