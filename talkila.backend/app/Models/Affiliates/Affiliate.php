<?php

namespace App\Models\Affiliates;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    use HasFactory;

    public $table = 'affiliates';

    protected $fillable = [
        'user_id',
        'paypal_address',
        'state',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subaffiliates()
    {
        return $this->hasMany(Subaffiliate::class);
    }
}
