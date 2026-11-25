<?php

namespace App\Traits;

use App\Scopes\GroupTalksScope;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static static|Builder|\Illuminate\Database\Query\Builder withGroup()
 */
trait WithoutGroupTalks
{
    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootWithoutGroupTalks()
    {
        static::addGlobalScope(new GroupTalksScope);
    }
}
