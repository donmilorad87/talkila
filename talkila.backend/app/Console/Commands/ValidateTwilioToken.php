<?php

namespace App\Console\Commands;

use App\Entity\RoomStates;
use App\Models\SocketParticipant;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ValidateTwilioToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'validate:twilio';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validates participants Twilio token.';

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
        Log::notice('Validating user Twilio token...');

        $participants = SocketParticipant::query()
            ->join('socket_rooms', 'socket_rooms.id', '=', 'socket_participants.socket_room_id')
            ->select([
                'socket_participants.id',
                'socket_participants.twilio_access_token',
            ])
            ->where('socket_rooms.state', RoomStates::ROOM_IN_PROGRESS)
            ->get();


        foreach ($participants as $participant) {
            if (! $participant->hasTwilioToken()) {
                $this->invalidRecords->push($participant->id);
            }
        }

        Log::error("Participants without valid Twilio Access token: {$this->invalidRecords->implode(', ')}");

        return true;
    }
}
