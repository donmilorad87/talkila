<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocketRoomError extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = null;
    protected $table = 'socket_room_error';
    protected $fillable = ['socket_room_id', 'error', 'created_at'];

    public function room()
    {
        return $this->belongsTo(SocketRoom::class);
    }
}
