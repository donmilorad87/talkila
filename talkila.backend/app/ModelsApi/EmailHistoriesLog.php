<?php

namespace App\ModelsApi;

use App\Models;

/**
 * App\ModelsApi\EmailHistoriesLog
 *
 * @property int $id
 * @property string $from_user
 * @property string $to_user
 * @property string|null $subject
 * @property string|null $message
 * @property string|null $template_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistoriesLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistoriesLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistoriesLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistoriesLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistoriesLog whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistoriesLog whereFromUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistoriesLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistoriesLog whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistoriesLog whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistoriesLog whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistoriesLog whereToUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistoriesLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EmailHistoriesLog extends Models\EmailHistoriesLog
{
    protected static function boot()
    {
        parent::boot();
    }
}
