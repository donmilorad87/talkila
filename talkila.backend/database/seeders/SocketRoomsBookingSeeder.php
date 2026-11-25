<?php

namespace Database\Seeders;

use App\Models\SocketRoom;
use Illuminate\Database\Seeder;

class SocketRoomsBookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $socket_rooms = SocketRoom::all();

        foreach ($socket_rooms as $socket_room) {
            $socket_room->update([
                'booking_id' => $this->getBookingIdFromRoom($socket_room),
            ]);
        }
    }

    protected function getBookingIdFromRoom($room)
    {
        return explode('_', $room->room_name)[3];
    }
}
