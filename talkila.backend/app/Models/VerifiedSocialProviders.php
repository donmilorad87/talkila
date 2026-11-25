<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VerifiedSocialProviders extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'social_providers',
        'social_id',
        'social_username',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const PROVIDERS = [
        'facebook'   => '0',
        'instagram' => '1',
        'linkedin' => '2',
        'twitter' => '3'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
}
