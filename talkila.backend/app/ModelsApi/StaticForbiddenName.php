<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\StaticForbiddenName
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|StaticForbiddenName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticForbiddenName newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticForbiddenName query()
 * @method static \Illuminate\Database\Eloquent\Builder|StaticForbiddenName whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticForbiddenName whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticForbiddenName whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticForbiddenName whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaticForbiddenName whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StaticForbiddenName extends Models\StaticForbiddenName
{
    protected static function boot()
    {
        parent::boot();
    }
}
