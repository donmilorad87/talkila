<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\SystemLogin
 *
 * @property int $id
 * @property int|null $login_type
 * @property int|null $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $user_id
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|SystemLogin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemLogin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemLogin query()
 * @method static \Illuminate\Database\Eloquent\Builder|SystemLogin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemLogin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemLogin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemLogin whereLoginType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemLogin whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemLogin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SystemLogin whereUserId($value)
 * @mixin \Eloquent
 */
class SystemLogin extends Models\SystemLogin
{
    protected static function boot()
    {
        parent::boot();
    }
}
