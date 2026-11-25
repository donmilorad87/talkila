<?php

namespace App\Console\Commands;

use App\Entity\CallTypes;
use App\Entity\Notification;
use App\Entity\RoomStates;
use App\Entity\Twilio;
use App\Entity\UserTypes;
use App\Events\NewRoomStarted;
use App\Exceptions\Handler;
use App\Models\SocketParticipant;
use App\Models\SocketRoom;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StartNewRooms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:newroom';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create New Twilio Rooms and Notify people of new room';

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
     * @return int
     */
    public function handle()
    {
        // Open new Rooms
        $this->startRooms();

        return 0;
    }

    /*
    * Create rooms before two minutes for all talks and notify respective users
    */
    public function startRooms()
    {
        Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$request');

        try {
            $twilio        = new Twilio();
            $time_to_start = Carbon::now();
            $pending_rooms = SocketRoom::query()
                ->where('state', '=', RoomStates::ROOM_PENDING)
                ->where('talk_start_time', '<=', $time_to_start)
                ->where('talk_end_time', '>', $time_to_start)
                ->get();

            // TODO Move all this to separate Jobs per Room Creation
            foreach ($pending_rooms as $room) {
                try {
                    DB::beginTransaction();

                    // Create Video Room
                    // Twilio deprecated peer-to-peer and go room types; use group for all
                    $room_type = "group";

                    // empty_room_duration - The empty room timeout specifies how long a room will remain active after the last participant leaves.
                    // unused_room_duration - Unused room timeout specifies how long a room will remain active if no one joins
                    // Reference - https://www.twilio.com/changelog/new-configurable-video-room-timeout-parameters-in-rest-api
                    $data = [
                        "uniqueName"          => $room->id,
                        "type"                => $room_type,
                        "duration"            => $room->duration,
                        'empty_room_timeout'  => 60,
                        'unused_room_timeout' => 20,
                        "statusCallback"      => config('app.url') . "/api/twilio-room-event",
                    ];

                    $room_id = $twilio->createRoom($data);

                    // Get participants
                    foreach ($room->participants as $participant) {
                        $participant->twilio_access_token = $twilio->createAccessToken($participant->user_id, $room_id);
                        $participant->save();

                        $this->sendPush($participant, $room);

                        // TODO: Figure out where is this event being used.
                        event(new NewRoomStarted($participant, $room));
                    }

                    // Update room state to in progress
                    SocketRoom::query()
                        ->where('id', $room->id)
                        ->update([
                            'state' => RoomStates::ROOM_IN_PROGRESS,
                        ]);

                    DB::commit();
                } catch (\Throwable $exception) {
                    if (isset($room->id) && $room->id > 0) {
                        $twilio->closeRoom($room->id);
                    }

                    DB::rollBack();

                    Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');
                    app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_9800, self::class, __FUNCTION__);
                }
            }
        } catch (\Throwable $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_9801, self::class, __FUNCTION__);
        }
    }

    /*
    * Send Push notification to each user new style - to be renamed later
    */
    private function sendPush($participant, $room)
    {
        Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$request');
        Log::notice("participant: ");
        Log::notice($participant);
        Log::notice("room: ");
        Log::notice($room);

        try {

            // TODO: Figure out a correct way to notify appropriately.
            /**
             * If Participant has no Firebase ID and the device type used to access to Room is iOS or Android,
             * Log an error and return out of the function.
             */
            if (is_null($participant->firebase_id)) {
                if (in_array($participant->user->device_type, ['ios', 'android'])) {
                    Log::error('Firebase ID is not valid for User device type.');
                }

                return;
            }

            /**
             * If Firebase ID exists but does not match the format, throw an Exception.
             */
            if (($isValidDevice = preg_match('/[^a-zA-Z0-9]+/', $participant->firebase_id, $matches)) === false) {
                throw new Exception('Firebase ID is not valid.');
            }

            if ($participant->user_type == UserTypes::CLIENT) {
                $provider   = SocketParticipant::where('socket_room_id', '=', $participant->socket_room_id)->where('user_type', '=', UserTypes::PROVIDER)->first();
                $user_id    = $provider->user_id;
                $user_image = $provider->user_image;
                $user_name  = $provider->name_of_user;
            } else {
                $user_id    = $participant->user_id;
                $user_image = $participant->user_image;
                $user_name  = 'Talkila';
            }

            $response                                    = [];
            $response["click_action"]                    = 'FLUTTER_NOTIFICATION_CLICK';
            $response["status"]                          = 'done';
            $response["token"]                           = $participant->twilio_access_token;
            $response['identity']                        = $user_id;
            $response['caller_profile_image']            = $user_image;
            $response['caller_name']                     = $user_name;
            $response["is_mobile_native_calling_screen"] = true;
            $response['call_ringing_duration']           = config('duration.ringing');
            // Is it really needed here?
            $response["provider_id"] = $participant->id;
            $response["room"]        = $room->room_name;
            $response["room_id"]     = $room->id;
            $response["call_type"]   = $room->call_type;
            $response["room_type"]   = $room->talk_type;
            $response["user_type"]   = $participant->user_type;
            $response["duration"]    = $room->duration;
            $response["start_time"]  = Carbon::parse($room->talk_start_time)->addMinutes((int) $participant->timezone)->toDateTimeString();
            $response["end_time"]    = Carbon::parse($room->talk_end_time)->addMinutes((int) $participant->timezone)->toDateTimeString();
            $response["UUID"]        = $this->GUID();

            $notification = new Notification();

            if ($isValidDevice) {
                $payload = [
                    'registration_ids' => [$participant->firebase_id],
                    'data'             => $response,
                    'priority'         => 'high',
                    'time_to_live'     => ($room->duration <= 15 ? config('duration.room.short') : config('duration.room.long')) * 60,
                ];
                $notification->sendPushNotification($payload);
            } else {
                foreach (config('services.ios_voip_notification.urls') as $url) {
                    if (! is_null($url) && $url !== '') {
                        $notification->sendiOSPushNotification($response, $participant->firebase_id, $url);
                    }
                }
            }
        } catch (\Throwable $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_9802, self::class, __FUNCTION__);
        }
    }

    private function GUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
}