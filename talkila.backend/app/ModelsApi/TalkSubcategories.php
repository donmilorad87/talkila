<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\TalkSubcategories
 *
 * @property int $id
 * @property string $croatian
 * @property string $german
 * @property string $english
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $courses_categories_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ModelsApi\Talk[] $talks
 * @property-read int|null $talks_count
 * @method static \Illuminate\Database\Eloquent\Builder|TalkSubcategories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TalkSubcategories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TalkSubcategories query()
 * @method static \Illuminate\Database\Eloquent\Builder|TalkSubcategories whereCoursesCategoriesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TalkSubcategories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TalkSubcategories whereCroatian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TalkSubcategories whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TalkSubcategories whereEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TalkSubcategories whereGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TalkSubcategories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TalkSubcategories whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TalkSubcategories extends Models\TalkSubcategories
{
    protected static function boot()
    {
        parent::boot();
    }
}

