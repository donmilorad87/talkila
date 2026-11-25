<?php

namespace App\Models\Affiliates;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subaffiliate extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'affiliates_sub';

    const STATE = [
        'active' => '1',
        'disabled' => '0'
    ];

    protected $fillable = [
        'affiliate_id',
        'tracking_id',
        'name',
        'email',
        'state',
    ];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'affiliates_sub_id', 'id');
    }

    public function affiliate_revenue()
    {
        return $this->hasMany(AffiliatesRevenue::class, 'affiliates_sub_id', 'id');
    }
}
