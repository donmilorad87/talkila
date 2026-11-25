<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\UserReportType
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $croatian
 * @property string|null $english
 * @property string|null $german
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportType query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportType whereCroatian($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportType whereEnglish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportType whereGerman($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserReportType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class UserReportType extends Models\UserReportType
{
    protected static function boot()
    {
        parent::boot();
    }
}
