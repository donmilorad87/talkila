<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocketCallsProtocol extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $table = 'socket_calls_protocol';
    protected $fillable = ['socket_room_id', 'socket_participant_id', 'event', 'support_data', 'created_at'];

    public function room()
    {
        return $this->belongsTo(SocketRoom::class, 'socket_room_id', 'id');
    }

    public function participant()
    {
        return $this->belongsTo(SocketParticipant::class, 'socket_participant_id', 'id');
    }
}
