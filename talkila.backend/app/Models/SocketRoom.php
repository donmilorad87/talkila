<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocketRoom extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $table = 'socket_rooms';
    protected $fillable = [
        'id',
        'talk_id',
        'booking_id',
        'room_name',
        'duration',
        'talk_type',
        'call_type',
        'teacher_joined',
        'student_joined',
        'talk_start_time',
        'talk_end_time',
        'call_extended',
        'state',
        'created_at',
    ];

    public function call_protocols()
    {
        return $this->hasMany(SocketCallsProtocol::class);
    }

    public function participants()
    {
        return $this->hasMany(SocketParticipant::class);
    }

    public function talk()
    {
        return $this->belongsTo(Talk::class, 'talk_id', 'id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }
}
