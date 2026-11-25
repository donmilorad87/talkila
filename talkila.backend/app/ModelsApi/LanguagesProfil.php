<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\LanguagesProfil
 *
 * @property int $id
 * @property int|null $level
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $user_id
 * @property int $language_id
 * @property-read \App\Models\Language $language
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|LanguagesProfil newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LanguagesProfil newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LanguagesProfil query()
 * @method static \Illuminate\Database\Eloquent\Builder|LanguagesProfil whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguagesProfil whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguagesProfil whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguagesProfil whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguagesProfil whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguagesProfil whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LanguagesProfil whereUserId($value)
 * @mixin \Eloquent
 */
class LanguagesProfil extends Models\LanguagesProfil
{
    protected static function boot()
    {
        parent::boot();
    }
}
