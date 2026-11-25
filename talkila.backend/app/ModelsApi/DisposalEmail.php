<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\DisposalEmail
 *
 * @property int $id
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalEmail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalEmail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalEmail query()
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalEmail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalEmail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalEmail whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalEmail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalEmail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DisposalEmail extends Models\DisposalEmail
{
    protected static function boot()
    {
        parent::boot();
    }
}
