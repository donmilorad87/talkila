<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\DisposalDomain
 *
 * @property int $id
 * @property string|null $domain
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalDomain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalDomain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalDomain query()
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalDomain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalDomain whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalDomain whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalDomain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DisposalDomain whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DisposalDomain extends Models\DisposalDomain
{
    protected static function boot()
    {
        parent::boot();
    }
}
