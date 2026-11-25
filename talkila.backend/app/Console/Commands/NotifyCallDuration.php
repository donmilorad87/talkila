<?php

namespace App\Console\Commands;

use App\Entity\CallTypes;
use App\Entity\Events;
use App\Entity\ParticipantStates;
use App\Entity\RoomStates;
use App\Entity\StateTypes;
use App\Entity\TalkTypes;
use App\Entity\Twilio;
use App\Entity\UserTypes;
use App\Events\EndCall;
use App\Events\NotifyProvider;
use App\Events\SingleUserEndCall;
use App\Events\SingleUserNotify;
use App\Exceptions\Handler;
use App\Mail\BookingInvoiceClient;
use App\Mail\TalkClientDidNotShow;
use App\Mail\TalkSupplierDidNotShow;
use App\Models\SocketCallsProtocol;
use App\Models\SocketParticipant;
use App\Models\SocketRoom;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyCallDuration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:duration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifies remaining time of the calls to clients on all active calls';

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
     * Handles the logic for cron job. Takes the room info of active calls, minus the duration, updates via the socket events.
     * For extended calls, checks the current open extensions and notify each user.
     * Kicks the user with expired extension.
     * Closes room, once all extensions are expired.
     * @return int
     */
    public function handle()
    {
        // Manage running rooms
        $this->notifyOpenRooms();
    }

    /**
     * Record server end call
     * @return void
     */
    private function endRoom($room_id, $room_name, $reason, $provider_id)
    {
        Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$request');
        Log::notice("room_id: ");
        Log::notice($room_id);
        Log::notice("room_name: ");
        Log::notice($room_name);
        Log::notice("reason: ");
        Log::notice($reason);
        Log::notice("provider_id: ");
        Log::notice($provider_id);

        try {
            $socket_call_protocol                 = new SocketCallsProtocol();
            $socket_call_protocol->socket_room_id = $room_id;

            // using provider id to avoid foreign key constraint
            $socket_call_protocol->socket_participant_id = $provider_id;
            $socket_call_protocol->event                 = Events::TALK_END;
            $socket_call_protocol->support_data          = "room-name: " . $room_name . "||reason: " . $reason;
            $socket_call_protocol->created_at            = new DateTime();
            $socket_call_protocol->save();
        } catch (Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_9700, self::class, __FUNCTION__);
        }
    }

    /**
     * Notify provider with the updated time for all clients
     * @return void
     */
    private function notifyTeacher($room_info)
    {
        Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$request');
        Log::notice("room_info: ");
        Log::notice($room_info);

        try {
            $room_participants = SocketParticipant::where('socket_room_id', '=', $room_info->id)->get();
            $supplier = $room_participants->where('user_type', UserTypes::PROVIDER)->first();
            $participant_with_duration = [];

            foreach ($room_participants as $participant) {
                $current_time                                     = Carbon::now();
                $room_end_time                                    = Carbon::parse($participant->room_end);
                $current_duration                                 = $current_time->diffInMinutes($room_end_time);
                $participant_with_duration[$participant->user_id] = $current_duration;
            }

            event(new NotifyProvider($participant_with_duration, $supplier->user_id));
        } catch (Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_9701, self::class, __FUNCTION__);
        }
    }

    private function notifyOpenRooms()
    {
        Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$request');

        try {
            $twilio        = new Twilio();
            $time_to_start = Carbon::now();
            $active_rooms  = SocketRoom::query()
                ->where('state', '=', RoomStates::ROOM_IN_PROGRESS)
                ->where('talk_start_time', '<=', $time_to_start)
                ->get();

            Log::notice('rooms', $active_rooms->pluck('id')->toArray());

            foreach ($active_rooms as $room_info) {
                DB::beginTransaction();

                $supplier                = $room_info->participants->where('user_type', UserTypes::PROVIDER)->first();
                $client                  = $room_info->participants->where('user_type', UserTypes::CLIENT)->first();
                $booking                 = $room_info->booking;
                $talk                    = $room_info->talk;
                $type                    = $room_info->talk_type === TalkTypes::VOICE_CALL ? 'Voice Call' : 'Video Call';
                $duration                = Carbon::now()->diffInMinutes(Carbon::parse($room_info->talk_end_time), false);
                $contributor_pickup_time = $room_info->duration > 15 ? config('duration.room.long') : config('duration.room.short');

                Log::notice('room', [$room_info->id]);
                Log::notice('duration', [$duration]);
                Log::notice('room duration', [$room_info->duration]);
                Log::notice('pickup time', [$contributor_pickup_time]);

                // if provider didn't joined till limit
                if ($room_info->teacher_joined == StateTypes::NO && $duration <= ($room_info->duration - $contributor_pickup_time)) {
                    $twilio->closeRoom($room_info->id);

                    SocketRoom::query()
                        ->find($room_info->id)
                        ->update([
                            'state' => RoomStates::TEACHER_DONT_SHOW,
                        ]);

                    event(new EndCall($duration, $room_info->id));

                    $this->endRoom($room_info->id, $room_info->room_name, "Teacher didn't show up.", 1);

                    $supplier_updated = SocketParticipant::query()
                        ->where('socket_room_id', '=', $room_info->id)
                        ->where('user_type', '=', UserTypes::PROVIDER)
                        ->update([
                            'is_active' => ParticipantStates::DIDNT_SHOW,
                        ]);

                    SocketParticipant::query()
                        ->where('socket_room_id', '=', $room_info->id)
                        ->where('user_type', '=', UserTypes::CLIENT)
                        ->update([
                            'is_active' => ParticipantStates::OTHER_PERSON_DIDNT_SHOW,
                        ]);

                    if ($supplier_updated) {
                        Mail::to($supplier->user->email)->queue(new TalkSupplierDidNotShow($supplier->email, $talk, $booking, $room_info, $type));
                    }

                    DB::commit();

                    return 0;
                }

                if ($room_info->student_joined == StateTypes::NO && ($duration < 0)) {
                    SocketParticipant::query()
                        ->where('socket_room_id', '=', $room_info->id)
                        ->where('user_type', '=', UserTypes::CLIENT)
                        ->whereIn('is_active', [ParticipantStates::INACTIVE, ParticipantStates::DECLINED])
                        ->update([
                            'is_active' => ParticipantStates::DIDNT_SHOW,
                        ]);

                    $twilio->closeRoom($room_info->id);

                    SocketRoom::query()
                        ->find($room_info->id)
                        ->update([
                            'state' => RoomStates::STUDENT_DONT_SHOW,
                        ]);

                    event(new EndCall($duration, $room_info->id));

                    $this->endRoom($room_info->id, $room_info->room_name, "Student didn't show up.", 1);

                    SocketParticipant::query()
                        ->where('socket_room_id', '=', $room_info->id)
                        ->where('user_type', '=', UserTypes::PROVIDER)
                        ->update([
                            'is_active' => ParticipantStates::OTHER_PERSON_DIDNT_SHOW,
                        ]);

                    Mail::to($client->user->email)->queue(new TalkClientDidNotShow($supplier->email, $talk, $booking, $room_info, $type));
                    Mail::to($client->user->email)->queue(new BookingInvoiceClient($client->user->last_lang ?: 'de', $booking, $supplier->user, $client->user));

                    DB::commit();

                    return 0;
                }

                // TODO: Figure out the value of $duration.
                // if room time finished
                if ($duration < 0) {
                    $twilio->closeRoom($room_info->id);

                    SocketRoom::query()
                        ->find($room_info->id)
                        ->update([
                            'state' => RoomStates::ROOM_DONE,
                        ]);

                    $this->endRoom($room_info->id, $room_info->room_name, "Talk finished.", 1);

                    SocketParticipant::query()
                        ->where('socket_room_id', '=', $room_info->id)
                        ->whereNotIn('is_active', [
                            ParticipantStates::HANGUP,
                            ParticipantStates::DIDNT_SHOW,
                            ParticipantStates::KICKED,
                        ])
                        ->update([
                            'is_active' => ParticipantStates::TIME_ENDED,
                        ]);

                    event(new EndCall($duration, $room_info->id));

                    DB::commit();

                    return 0;
                }

                // Teacher joined start time function
                if ($room_info->teacher_joined == StateTypes::YES) {
                    // Kick users whose time is over
                    $this->kickUsersWithExpiredTime($room_info->id);

                    // Notify all users for current time of their talk
                    $this->notifyUsersOfTime($room_info);

                    // TODO Check with Mir what is difference between notifyProviderOfTime and notifyTeacher
                    // Notify provider of his time
                    $this->notifyProviderOfTime($room_info);

                    // Notify provider of all clients time in group talk
                    if ($room_info->call_type == CallTypes::GROUP) {
                        $this->notifyTeacher($room_info);
                    }

                    DB::commit();

                    return 0;
                }

                DB::commit();
            }
        } catch (Exception $exception) {
            DB::rollBack();

            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_9702, self::class, __FUNCTION__);
        }
    }

    /*
    * Kick users with expired time
    */
    private function kickUsersWithExpiredTime($socket_room_id)
    {
        Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$request');
        Log::notice("socket_room_id: ");
        Log::notice($socket_room_id);
        DB::beginTransaction();

        try {
            $twilio               = new Twilio();
            $expired_participants = SocketParticipant::where('socket_room_id', '=', $socket_room_id)
                ->whereIn('is_active', [ParticipantStates::INACTIVE, ParticipantStates::JOINED, ParticipantStates::REJOINED, ParticipantStates::DECLINED])
                ->where('user_type', '=', UserTypes::CLIENT)
                ->where('room_end', '<=', Carbon::now())
                ->get();
            foreach ($expired_participants as $participant) {
                $twilio->kickParticipant($socket_room_id, $participant->user_id);
                SocketParticipant::where('id', '=', $participant->id)
                    ->update(['is_active' => ParticipantStates::TIME_ENDED]);
                event(new SingleUserEndCall("End Call", $participant->user_id, false, ""));
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_9703, self::class, __FUNCTION__);
        }
    }

    /*
    * Notify all users of their talk time
    */
    private function notifyUsersOfTime($socket_room)
    {
        Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$request');
        Log::notice("socket_room: ");
        Log::notice($socket_room);

        try {
            $active_participants = SocketParticipant::where('socket_room_id', '=', $socket_room->id)
                ->whereIn('is_active', [ParticipantStates::JOINED, ParticipantStates::REJOINED])
                ->where('user_type', '=', UserTypes::CLIENT)
                ->where('room_end', '>', Carbon::now())
                ->get();

            foreach ($active_participants as $participant) {
                $current_duration = Carbon::now()->diffInMinutes($participant->room_end);
                $total_duration   = Carbon::parse($participant->room_end)->diffInMinutes(Carbon::parse($participant->room_joined));
                $start_time       = Carbon::parse($participant->room_joined)->addMinutes($participant->user->timezone)->toDateTimeString();
                $end_time         = Carbon::parse($participant->room_end)->addMinutes($participant->user->timezone)->toDateTimeString();

                // This is how it used to be:
                // event(new SingleUserNotify($current_duration, $total_duration, $participant->room_joined, $participant->room_end, $participant->user_id));

                event(new SingleUserNotify($current_duration, $total_duration, $start_time, $end_time, $participant->user_id));
            }
        } catch (Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_9704, self::class, __FUNCTION__);
        }
    }

    /*
    * Notify provider of their talk time
    */
    private function notifyProviderOfTime($socket_room)
    {
        Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$request');
        Log::notice("socket_room: ");
        Log::notice($socket_room);

        try {
            $provider = SocketParticipant::where('socket_room_id', '=', $socket_room->id)
                ->whereIn('is_active', [ParticipantStates::JOINED, ParticipantStates::REJOINED])
                ->where('user_type', '=', UserTypes::PROVIDER)
                ->first();
            if ($provider) {
                $current_time   = Carbon::now();
                $room_end_time  = Carbon::parse($socket_room->talk_end_time);
                $duration       = $current_time->diffInMinutes($room_end_time);
                $total_duration = Carbon::parse($socket_room->talk_end_time)->diffInMinutes(Carbon::parse($socket_room->talk_start_time));
                $start_time     = Carbon::parse($socket_room->talk_start_time)->addMinutes($provider->user->timezone)->toDateTimeString();
                $end_time       = Carbon::parse($socket_room->talk_end_time)->addMinutes($provider->user->timezone)->toDateTimeString();

                // This is how it used to be:
                // event(new SingleUserNotify($duration, $total_duration, $socket_room->talk_start_time, $socket_room->talk_end_time, $provider->user_id));

                event(new SingleUserNotify($duration, $total_duration, $start_time, $end_time, $provider->user_id));
            }
        } catch (Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_9705, self::class, __FUNCTION__);
        }
    }
}
