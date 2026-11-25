<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocketParticipant extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $table = 'socket_participants';

    protected $fillable = [
        'socket_room_id',
        'booking_id',
        'user_id',
        'name_of_user',
        'user_image',
        'firebase_id',
        'twilio_access_token',
        'is_active',
        'is_anonym',
        'user_type',
        'room_joined',
        'room_end'
    ];
    
    public function room()
    {
        return $this->belongsTo(SocketRoom::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
