<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\TalksSubcategories
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TalksSubcategories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TalksSubcategories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TalksSubcategories query()
 * @mixin \Eloquent
 */
class TalksSubcategories extends Models\TalksCategories
{
    protected static function boot()
    {
        parent::boot();
    }
}
