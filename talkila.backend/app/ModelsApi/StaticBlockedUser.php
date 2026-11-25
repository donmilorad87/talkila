<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\StaticBlockedUser
 *
 * @property int $id
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|StaticBlockedUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticBlockedUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticBlockedUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticBlockedUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticBlockedUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticBlockedUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticBlockedUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticBlockedUser whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StaticBlockedUser extends Models\StaticBlockedUser
{
    protected static function boot()
    {
        parent::boot();
    }
}
