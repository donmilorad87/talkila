<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\AutocompleteTag
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $language_id
 * @method static \Illuminate\Database\Eloquent\Builder|AutocompleteTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AutocompleteTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AutocompleteTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|AutocompleteTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AutocompleteTag whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AutocompleteTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AutocompleteTag whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AutocompleteTag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AutocompleteTag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AutocompleteTag extends Models\AutocompleteTag
{
    protected static function boot()
    {
        parent::boot();
    }
}
