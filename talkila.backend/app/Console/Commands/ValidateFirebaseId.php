<?php

namespace App\Console\Commands;

use App\Entity\RoomStates;
use App\Models\SocketParticipant;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ValidateFirebaseId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'validate:firebase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validates participants Firebase ID.';

    /**
     * Collection of invalid participants.
     *
     * @var Collection
     */
    protected $invalidRecords;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->invalidRecords = collect();
    }

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle(): bool
    {
        Log::notice('Validating user Firebase data...');

        $participants = SocketParticipant::query()
            ->join('socket_rooms', 'socket_rooms.id', '=', 'socket_participants.socket_room_id')
            ->join('users', 'users.id', '=', 'socket_participants.user_id')
            ->select([
                'socket_participants.id',
                'socket_participants.firebase_id',
                'users.device_type',
            ])
            ->where('socket_rooms.state', RoomStates::ROOM_PENDING)
            ->get();

        foreach ($participants as $participant) {
            if ($participant->loggedInViaApp() && !$participant->hasValidFirebaseId()) {
                $this->invalidRecords->push($participant->id);
            }
        }

        Log::error("Participants without valid Firebase ID: {$this->invalidRecords->implode(', ')}");


        return true;
    }
}
