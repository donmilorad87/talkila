<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\Pages
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property int $bg_img
 * @property int $show_contact
 * @property string $body
 * @property string $meta_data
 * @property string $template
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Pages newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pages newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pages query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pages whereBgImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pages whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pages whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pages whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pages whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pages whereMetaData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pages whereShowContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pages whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pages whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pages whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pages whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Pages extends Models\Pages
{
    protected static function boot()
    {
        parent::boot();
    }
}
