<?php

namespace App\Console\Commands;

use App\Entity\RoomStates;
use App\Models\SocketRoom;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ValidateRoomStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'validate:room-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validates status of Socket Rooms.';

    /**
     * Collection of invalid Rooms that are Pending.
     *
     * @var Collection
     */
    protected $invalidPendingRecords;

    /**
     * Collection of invalid Rooms that are In Progress.
     *
     * @var Collection
     */
    protected $invalidInProgressRecords;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->invalidPendingRecords    = collect();
        $this->invalidInProgressRecords = collect();
    }

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle(): bool
    {
        Log::notice('Validating Socket Room states...');

        $rooms = SocketRoom::query()
            ->select([
                'id',
                'state',
                'talk_start_time',
                'talk_end_time',
            ])
            ->whereIn('state', [
                RoomStates::ROOM_PENDING,
                RoomStates::ROOM_IN_PROGRESS,
            ])
            ->get();

        foreach ($rooms as $room) {
            switch ($room->state) {
                case RoomStates::ROOM_PENDING:
                    $this->validatePendingRoom($room);
                    break;
                case RoomStates::ROOM_IN_PROGRESS:
                    $this->validateRoomInProgress($room);
                    break;
            }
        }

        Log::error("Invalid Pending Rooms: {$this->invalidPendingRecords->implode(', ')}");
        Log::error("Invalid In Progress Rooms {$this->invalidInProgressRecords->implode(', ')}");


        return true;
    }

    /**
     * Validate the state of Socket Rooms that are Pending.
     *
     * @param  SocketRoom  $room
     *
     * @return void
     */
    protected function validatePendingRoom(SocketRoom $room): void
    {
        if ($room->hasStarted() && !$room->hasEnded()) {
            Log::error("Room {$room->id} should be in progress!");

            $this->invalidPendingRecords->push($room->id);
        }

        if ($room->hasStarted() < $room->hasEnded()) {
            Log::error("Room {$room->id} should have ended!");

            $this->invalidPendingRecords->push($room->id);
        }
    }

    /**
     * Validate the state of Socket Rooms that are In Progress.
     *
     * @param  SocketRoom  $room
     *
     * @return void
     */
    protected function validateRoomInProgress(SocketRoom $room): void
    {
        if ($room->hasStarted() && $room->hasEnded()) {
            Log::error("Room {$room->id} should have ended!");

            $this->invalidInProgressRecords->push($room->id);
        }
    }
}
