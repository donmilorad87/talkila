<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * App\Models\Pages
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
 * @method static \Illuminate\Database\Query\Builder|Pages onlyTrashed()
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
 * @method static \Illuminate\Database\Query\Builder|Pages withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Pages withoutTrashed()
 * @mixin \Eloquent
 */
class Pages extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'pages';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'slug',
        'body',
        'meta_data',
        'language',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
