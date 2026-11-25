<?php

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

/**
 * App\Models\ProfilCv
 *
 * @property int $id
 * @property int|null $type
 * @property \Illuminate\Support\Carbon|null $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property string|null $company_name
 * @property \App\Models\StaticProfession|null $profession
 * @property string|null $location
 * @property int $work_here
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $user_id
 * @property int|null $profession_id
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv newQuery()
 * @method static \Illuminate\Database\Query\Builder|ProfilCv onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereProfession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereProfessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfilCv whereWorkHere($value)
 * @method static \Illuminate\Database\Query\Builder|ProfilCv withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProfilCv withoutTrashed()
 * @mixin \Eloquent
 */
class ProfilCv extends Model
{
    use SoftDeletes, Auditable;

    public $table = 'profil_cvs';

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'type',
        'start_date',
        'end_date',
        'company_name',
        'location',
        'profession_id',
        'work_here',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const TYPE = [
        'job'       => '1',
        'education' => '2'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getStartDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getEndDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function profession()
    {
        return $this->belongsTo(StaticProfession::class, 'profession_id');
    }
}
