<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\Serializable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\EmailHistoriesLog
 *
 * @property int                    $id
 * @property int                    $from_user
 * @property int                    $to_user
 * @property string                 $subject
 * @property string                 $message
 * @property string                 $template_id
 * @property string                 $created_at
 * @property string                 $updated_at
 * @property string                 $deleted_at
 * @property \App\EmailHistoriesLog $emailHistoriesLog
 * @property-read \App\Models\User  $user
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistoriesLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistoriesLog newQuery()
 * @method static \Illuminate\Database\Query\Builder|EmailHistoriesLog onlyTrashed()
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
 * @method static \Illuminate\Database\Query\Builder|EmailHistoriesLog withTrashed()
 * @method static \Illuminate\Database\Query\Builder|EmailHistoriesLog withoutTrashed()
 * @mixin \Eloquent
 */
class EmailHistoriesLog extends Model
{
    use SoftDeletes, Auditable, Serializable;

    public $table = 'email_histories_log';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'state',
        'from_user',
        'to_user',
        'subject',
        'message',
        'template_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /* Relationships
       ============================== */

    /**
     * User that sent the email.
     *
     * @return BelongsTo
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_user', 'email');
    }

    /**
     * User that sent email is sent to.
     *
     * @return BelongsTo
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_user','email');
    }

    /* Accessors/Mutators
       ============================== */

    /**
     * Determine whether a string is an HTML.
     *
     * @return bool
     */
    public function getIsHTMLAttribute(): bool
    {
        return $this->attributes['message'] === strip_tags($this->attributes['message']);
    }
}
