<?php

namespace App\Console\Commands;

use App\Entity\RoomStates;
use App\Entity\UserTypes;
use App\Exceptions\Handler;
use App\Jobs\NotifyClientTalkStartTenMinutes;
use App\Jobs\NotifyTeacherTalkStartTenMinutes;
use App\Models\SocketRoom;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class CheckTalkStartTimeTenMinutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check_talk_start_time_ten_minutes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check every ten minute for upcoming talks and notify participants 10 minute before the talk.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $currentTimePlusMinute = date('Y-m-d H:i:00', strtotime('+10 minutes', strtotime(date('Y-m-d H:i:s'))));
            $socketRooms           = SocketRoom::query()
                ->where('talk_start_time', $currentTimePlusMinute)
                ->where('state', RoomStates::ROOM_PENDING)
                ->get();

            foreach ($socketRooms as $room) {
                $talk    = $room->talk;
                $booking = $room->booking;

                foreach ($room->participants as $participant) {
                    if ($participant->user_type == UserTypes::CLIENT) {
                        NotifyClientTalkStartTenMinutes::dispatch(
                            $participant->user_id,
                            $talk->headline,
                            Carbon::parse($booking->start_time)->addMinutes($participant->user->timezone)->format('H:i'),
                            $room->duration
                        );
                    }

                    if ($participant->user_type == UserTypes::PROVIDER) {
                        NotifyTeacherTalkStartTenMinutes::dispatch(
                            $participant->user_id,
                            $talk->headline,
                            $booking->price,
                            $room->duration
                        );
                    }
                }
            }
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2803, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2803,
                'success' => false,
            ], 500);
        }
    }
}
