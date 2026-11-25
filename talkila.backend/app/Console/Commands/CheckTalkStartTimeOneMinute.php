<?php

namespace App\Console\Commands;

use App\Entity\RoomStates;
use App\Entity\UserTypes;
use App\Exceptions\Handler;
use App\Jobs\NotifyClientTalkStartOneMinute;
use App\Jobs\NotifyTeacherTalkStartOneMinute;
use App\Models\SocketRoom;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckTalkStartTimeOneMinute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check_talk_start_time_one_minute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check every minute for upcoming talks and notify participants 1 minute before the talk.';

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
            $currentTimePlusMinute = date('Y-m-d H:i:00', strtotime('+1 minutes', strtotime(date('Y-m-d H:i:s'))));
            $socketRooms           = SocketRoom::query()
                ->where('talk_start_time', $currentTimePlusMinute)
                ->where('state', RoomStates::ROOM_PENDING)
                ->get();

            foreach ($socketRooms as $room) {
                foreach ($room->participants as $participant) {
                    $talk = $room->talk;

                    if ($participant->user_type == UserTypes::CLIENT) {
                        NotifyClientTalkStartOneMinute::dispatch(
                            $participant->user_id,
                            $talk->headline
                        );
                    }

                    if ($participant->user_type == UserTypes::PROVIDER) {
                        NotifyTeacherTalkStartOneMinute::dispatch(
                            $participant->user_id,
                            $talk->headline
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
