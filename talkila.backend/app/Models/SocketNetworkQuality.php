<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocketNetworkQuality extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'socket_network_quality';
    protected $fillable = ['socket_room_id', 'socket_participant_id', 'quality_level', 'created_at'];

    public function room()
    {
        return $this->belongsTo(SocketRoom::class);
    }

    public function participant()
    {
        return $this->belongsTo(SocketParticipant::class);
    }
}
