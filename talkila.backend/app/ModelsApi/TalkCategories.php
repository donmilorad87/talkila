<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\TalkCategories
 *
 * @property int $id
 * @property string $croatian
 * @property string $german
 * @property string $english
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TalkSubcategories[] $subcategories
 * @property-read int|null $subcategories_count
 * @method static \Illuminate\Database\Eloquent\Builder|TalkCategories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TalkCategories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TalkCategories query()
 * @method static \Illuminate\Database\Eloquent\Builder|TalkCategories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TalkCategories whereCroatian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TalkCategories whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TalkCategories whereEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TalkCategories whereGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TalkCategories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TalkCategories whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TalkCategories extends Models\TalkCategories
{
    protected static function boot()
    {
        parent::boot();
    }
}
