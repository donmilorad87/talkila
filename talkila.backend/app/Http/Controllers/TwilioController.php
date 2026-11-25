<?php

namespace App\Http\Controllers;

use App\Console\Commands\StartNewRooms;
use App\Entity\CallTypes;
use App\Entity\Events;
use App\Entity\ParticipantStates;
use App\Entity\RoomStates;
use App\Entity\StateTypes;
use App\Entity\Twilio;
use App\Entity\UserTypes;
use App\Events\CallActionRequest;
use App\Events\ClientCallActions;
use App\Events\EndCall;
use App\Events\ExtensionAccepted;
use App\Events\ExtensionCancelled;
use App\Events\ExtensionRejected;
use App\Events\ExtensionRequest;
use App\Events\GlobalCallActions;
use App\Events\ReconnectToRoom;
use App\Events\ScreenShareOff;
use App\Events\ScreenShareOn;
use App\Events\SingleUserEndCall;
use App\Events\SingleUserExtension;
use App\Events\ClientRaiseHand;
use App\Events\SupplierAcceptRaisedHand;
use App\Events\SupplierRejectRaisedHand;
use App\Exceptions\Handler;
use App\Models\HelperModel;
use App\Models\Notifications;
use App\Models\SocketCallsProtocol;
use App\Models\SocketParticipant;
use App\Models\SocketRoom;
use App\Models\Talk;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/*
* Handles all the functionality for room creation and handling events from the app side
* during the call including storing network quality and calls protocol
*/

class TwilioController extends Controller
{
    public function prepareCall(Request $request)
    {
        Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$request');
        Log::notice($request);

        DB::beginTransaction();
        try {
            $duration         = $request->duration * 60;
            $duration         = ($duration == 0) ? 900 : $duration;
            $duration_to_mins = $request->duration;
            $start_time       = Carbon::now();
            $end_time         = Carbon::now()->addMinutes((int) $duration_to_mins);
            $attendees_data   = [];

            foreach ($request->attendees as $attendee) {
                $attendees_data[$attendee['user_id']]["user_id"]        = $attendee['user_id'];
                $attendees_data[$attendee['user_id']]["firebase_token"] = $attendee['token'];
                $attendees_data[$attendee['user_id']]["mobile_number"]  = $attendee['mobile_number'];
            }
            $room                  = new SocketRoom();
            $room->talk_id         = 2;
            $room->room_name       = $request->room_name;
            $room->duration        = $duration_to_mins;
            $room->talk_type       = $request->talk_type;
            $room->call_type       = $request->call_type;
            $room->teacher_joined  = StateTypes::NO;
            $room->student_joined  = StateTypes::NO;
            $room->talk_start_time = $start_time;
            $room->talk_end_time   = $end_time;
            $room->call_extended   = StateTypes::NO;
            $room->state           = RoomStates::ROOM_PENDING;
            $room->save();

            $host_socket_participant                 = new SocketParticipant();
            $host_socket_participant->socket_room_id = $room->id;
            $host_socket_participant->booking_id     = 1;
            if ($request->pointer == 35) {
                $host_socket_participant->user_id = 16;
            } else {
                $host_socket_participant->user_id = 3;
            }
            $host_socket_participant->name_of_user = $request->host['user_id'];
            $host_socket_participant->firebase_id  = $request->host["token"];
            $host_socket_participant->user_image   = "https://api.talkila.com/assets/images/user/3/3.jpg?t=1612619859.5541";
            $host_socket_participant->is_active    = StateTypes::NO;
            $host_socket_participant->is_anonym    = StateTypes::NO;
            $host_socket_participant->user_type    = UserTypes::PROVIDER;
            $host_socket_participant->room_end     = $end_time;
            $host_socket_participant->save();

            if ($request->pointer == 35) {
                $client_ids = [17, 18, 4, 5, 6, 7, 10];
            } else {
                $client_ids = [10, 4, 5, 6, 7, 2, 18];
            }

            $index = 0;
            foreach ($request->attendees as $attendee) {
                $client_socket_participant                 = new SocketParticipant();
                $client_socket_participant->socket_room_id = $room->id;
                $client_socket_participant->booking_id     = 1;
                $client_socket_participant->user_id        = $client_ids[$index];
                $client_socket_participant->name_of_user   = $attendee['user_id'];
                $client_socket_participant->firebase_id    = $attendee['token'];
                $client_socket_participant->user_image     = "https://api.talkila.com/assets/images/user/" . $client_ids[$index] . "/" . $client_ids[$index] . ".jpg?t=1612619859.5541";
                $client_socket_participant->is_active      = StateTypes::NO;
                $client_socket_participant->is_anonym      = StateTypes::NO;
                $client_socket_participant->user_type      = UserTypes::CLIENT;
                $client_socket_participant->room_end       = $end_time;
                $client_socket_participant->save();
                $index = $index + 1;
            }

            $rooms = new StartNewRooms();
            $rooms->startRooms();
            DB::commit();

            Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$response');
            Log::notice("Room Created.");

            return "Room Created.";
        } catch (Exception $exception) {
            DB::rollBack();

            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');
            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['URGENT'],
                Handler::TYPE_EXCEPTION_8000,
                self::class,
                __FUNCTION__
            );
        }
    }

    public function handleEvents(Request $request)
    {
        Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$request');
        Log::notice($request);

        $payload = $request;
        $event   = $payload->event;

        DB::beginTransaction();

        try {
            $response     = response()->error('Something went wrong.');
            $current_user = $payload->user();
            $booking      = $current_user->activeBooking();

            if (!$booking) {
                return response()->error('Could not find any active bookings.');
            }

            $socket_room  = $booking->activeSocketRoom();
            $participants = $socket_room->participants;

            if (!in_array($socket_room->state, [RoomStates::ROOM_PENDING, RoomStates::ROOM_IN_PROGRESS])) {
                return response()->error('Room is not available.');
            }

            if (in_array($event, [Events::PICKUP, Events::REDIAL, Events::DECLINE, Events::HANGUP, Events::EXTEND_CALL_ACCEPT, Events::EXTEND_CALL_REQUEST, Events::EXTEND_CALL_SUCCESSFUL])) {
                $client = $participants
                    ->where('user_type', UserTypes::CLIENT)
                    ->where('user_id', $payload->user()->id)
                    ->first();
            }

            if (in_array($event, [Events::EXTEND_CALL_ACCEPT, Events::EXTEND_CALL_REJECT])) {
                $client = $participants
                    ->where('user_type', UserTypes::CLIENT)
                    ->where('user_id', $payload->client_id)
                    ->first();
            }

            if (isset($client)) {
                $client_profile_picture = $client->user_image ?? config('app.user_default_image');
            }

            $supplier                 = $participants->where('user_type', UserTypes::PROVIDER)->first();
            $supplier_profile_picture = $supplier->user_image ?? config('app.user_default_image');
            $extension_minutes        = intval($payload->minutes_increased);

            $user_type = isset($client) && $current_user->id === $client->user_id
                ? UserTypes::CLIENT
                : UserTypes::PROVIDER;

            $payload->request->add([
                'socket_room_id'        => $socket_room->id,
                'socket_participant_id' => isset($client) && $user_type === UserTypes::CLIENT
                    ? $client->id
                    : $supplier->id,
                'user_type'             => $user_type,
                'supplier_name'         => $supplier->name_of_user,
                'support_data'          => "",  // TODO: Construct Support data message depending on the event triggered.
            ]);

            if (in_array($event, [Events::EXTEND_CALL_ACCEPT, Events::EXTEND_CALL_REQUEST, Events::EXTEND_CALL_SUCCESSFUL])) {
                $extension_price = round(($booking->price / $booking->duration) * $extension_minutes, 2);
            }

            if ($event === Events::EXTEND_CALL_SUCCESSFUL) {
                $payload->request->add([
                    'supplier_id'            => $supplier->user_id,
                    'client_name'            => $client->name_of_user,
                    'client_profile_picture' => $client_profile_picture,
                    'extension_minutes'      => $extension_minutes,
                    'extension_price'        => $extension_price,
                ]);
            }

            $action = $this->getEventAction($event);
            $state  = $this->getEventState($event);

            switch ($event) {
                case Events::KICK_PARTICIPANT:
                    $response = $this->kickUser($payload);
                    break;

                case Events::EXTEND_CALL_ACCEPT:
                    event(
                        new ExtensionAccepted(
                            $extension_minutes,
                            $client->user_id,
                            $supplier->name,
                            $supplier_profile_picture,
                            $extension_price
                        )
                    );
                    $response = response()->success('Call extended accepted.');
                    break;

                case Events::EXTEND_CALL_REJECT:
                    event(
                        new ExtensionRejected(
                            "Call extension request rejected",
                            $client->user_id,
                            $supplier->name,
                            $supplier_profile_picture
                        )
                    );

                    $response = response()->success('Call extended rejected.');
                    break;

                case Events::EXTEND_CALL_REQUEST:
                    event(
                        new ExtensionRequest(
                            $extension_minutes,
                            $supplier->user_id,
                            $extension_price,
                            $client->user_id,
                            $client->name_of_user,
                            $client_profile_picture
                        )
                    );

                    $response = response()->success('Call extended requested.');
                    break;

                case Events::EXTEND_CALL_CANCELLED:
                    event(
                        new ExtensionCancelled(
                            'Call extension cancelled.',
                            $supplier->user_id,
                            $client->name_of_user,
                            $client_profile_picture
                        )
                    );

                    $response = response()->success('Call extension cancelled.');
                    break;

                case Events::AUDIO_OFF:
                    event(
                        new CallActionRequest(
                            $action,
                            $state,
                            $current_user->id,
                            $socket_room->id
                        )
                    );

                    $response = response()->success('User muted.');
                    break;

                case Events::AUDIO_ON:
                    event(
                        new CallActionRequest(
                            $action,
                            $state,
                            $current_user->id,
                            $socket_room->id
                        )
                    );

                    $response = response()->success('User unmuted.');
                    break;

                case Events::VIDEO_ON:
                    event(
                        new CallActionRequest(
                            $action,
                            $state,
                            $current_user->id,
                            $socket_room->id
                        )
                    );

                    $response = response()->success('User camera On.');
                    break;

                case Events::VIDEO_OFF:
                    event(
                        new CallActionRequest(
                            $action,
                            $state,
                            $current_user->id,
                            $socket_room->id
                        )
                    );

                    $response = response()->success('User camera Off.');
                    break;

                case Events::RECONNECT_TO_ROOM:
                    foreach ($participants as $participant) {
                        if ($current_user->id != $participant->user_id) {
                            event(new ReconnectToRoom($participant->user_id));
                        }
                    }

                    $response = response()->success('User has reconnected to room.');
                    break;

                case Events::PICKUP:
                    $response = $this->pickUpcall($payload, ParticipantStates::JOINED);
                    break;

                case Events::REDIAL:
                    $response = $this->pickUpcall($payload, ParticipantStates::REJOINED);
                    break;

                case Events::DECLINE:
                    $response = $this->declineTheCall($payload);
                    break;

                case Events::HANGUP:
                    $response = $this->hangUpCall($payload);
                    break;

                case Events::EXTEND_CALL_SUCCESSFUL:
                    $response = $this->extendCallSuccess($payload);
                    break;

                case Events::GROUP_SUPPLIER_SET_ALL_AUDIO_OFF:
                    event(
                        new GlobalCallActions(
                            $action,
                            $state,
                            $socket_room->id
                        )
                    );

                    $response = response()->success('Room muted.');
                    break;

                case Events::GROUP_SUPPLIER_SET_ALL_AUDIO_ON:
                    event(
                        new GlobalCallActions(
                            $action,
                            $state,
                            $socket_room->id
                        )
                    );

                    $response = response()->success('Room unmuted.');
                    break;

                case Events::GROUP_SUPPLIER_SET_ALL_VIDEO_OFF:
                    event(
                        new GlobalCallActions(
                            $action,
                            $state,
                            $socket_room->id
                        )
                    );

                    $response = response()->success('Room camera off.');
                    break;

                case Events::GROUP_SUPPLIER_SET_ALL_VIDEO_ON:
                    event(
                        new GlobalCallActions(
                            $action,
                            $state,
                            $socket_room->id
                        )
                    );

                    $response = response()->success('Room camera on.');
                    break;

                case Events::SUPPLIER_SET_CLIENT_AUDIO_OFF:
                    event(
                        new ClientCallActions(
                            $action,
                            $state,
                            $payload->user_id
                        )
                    );

                    $response = response()->success('User muted.');
                    break;

                case Events::SUPPLIER_SET_CLIENT_AUDIO_ON:
                    event(
                        new ClientCallActions(
                            $action,
                            $state,
                            $payload->user_id
                        )
                    );

                    $response = response()->success('User unmuted.');
                    break;

                case Events::SUPPLIER_SET_CLIENT_VIDEO_OFF:
                    event(
                        new ClientCallActions(
                            $action,
                            $state,
                            $payload->user_id
                        )
                    );

                    $response = response()->success('User camera off.');
                    break;

                case Events::SUPPLIER_SET_CLIENT_VIDEO_ON:
                    event(
                        new ClientCallActions(
                            $action,
                            $state,
                            $payload->user_id
                        )
                    );

                    $response = response()->success('User camera on.');
                    break;

                case Events::SCREEN_SHARE_ON:
                    event(
                        new ScreenShareOn(
                            $payload->user()->id,
                            $socket_room->id
                        )
                    );

                    $response = response()->success('Screen Share on.');
                    break;

                case Events::SCREEN_SHARE_OFF:
                    event(
                        new ScreenShareOff(
                            $payload->user()->id,
                            $socket_room->id
                        )
                    );

                    $response = response()->success('Screen Share off.');
                    break;

                case Events::CLIENT_RAISE_HAND:

                    event(
                        new ClientRaiseHand(
                            $payload->user()->id,
                            $socket_room->id
                        )
                    );

                    $response = response()->success('CLIENT_RAISED_HAND' . ' | $payload->user()->id: ' . $payload->user()->id . ' socket_room->id: ' . $socket_room->id);
                    break;

                case Events::SUPPLIER_ACCEPT_RAISED_HAND:
                    event(
                        new SupplierAcceptRaisedHand(
                            $payload->client_id,
                            $socket_room->id
                        )
                    );

                    $response = response()->success(__('SUCCESSFULLY_ACCEPTED_RAISED_HAND'));
                    break;

                case Events::SUPPLIER_REJECT_RAISED_HAND:
                    event(
                        new SupplierRejectRaisedHand(
                            $payload->client_id,
                            $socket_room->id
                        )
                    );

                    $response = response()->success(__('SUCCESSFULLY_REJECT_RAISED_HAND'));
                    break;

            }

            SocketCallsProtocolController::store($payload);

            DB::commit();

            return $response;
        } catch (\Throwable $exception) {
            DB::rollBack();

            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_8001, self::class, __FUNCTION__);

            return response()->error($exception->getMessage());
        }
    }

    private function kickUser($payload)
    {
        Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$request');
        Log::notice($payload);
        DB::beginTransaction();

        try {
            $user_type      = $payload->user_type;
            $socket_room_id = $payload->socket_room_id;
            $current_user   = $payload->user();

            if ($user_type == UserTypes::CLIENT) {
                return response()->success(__('ONLY_SUPPLIER_CAN_KICK'));
            } else {
                if ($user_type == UserTypes::PROVIDER) {
                    $twilio = new Twilio();
                    $twilio->kickParticipant($payload->socket_room_id, $payload->user_id);

                    SocketParticipant::query()
                        ->where('socket_room_id', '=', $payload->socket_room_id)
                        ->where('user_id', '=', $payload->user_id)
                        ->update([
                            'is_active' => ParticipantStates::KICKED,
                        ]);

                    event(new SingleUserEndCall("End Call", $payload->user_id, true, $payload->reason));

                    $socket_room = SocketRoom::query()
                        ->where('id', $socket_room_id)
                        ->first();

                    $room_participants = SocketParticipant::query()
                        ->where('socket_room_id', '=', $socket_room_id)
                        ->whereIn('is_active', [ParticipantStates::INACTIVE, ParticipantStates::JOINED, ParticipantStates::REJOINED, ParticipantStates::DECLINED])
                        ->count();

                    $response =  response()->success(__('USER_SUCCESSFULY_KICKED'));

                    if ($room_participants === 1) {
                        $twilio->closeRoom($socket_room_id);

                        $kicked_participants = SocketParticipant::query()
                            ->where('socket_room_id', '=', $socket_room_id)
                            ->where('is_active', '=', ParticipantStates::KICKED)
                            ->count();

                        $socket_clients_participatns = SocketParticipant::query()
                            ->where('socket_room_id', '=', $socket_room_id)
                            ->where('user_id', '!=', $current_user->id)
                            ->count();

                        if ($kicked_participants === $socket_clients_participatns) {
                            $socket_room->state = RoomStates::ALL_CLIENTS_KICKED;
                        } else {
                            $socket_room->state = RoomStates::TEACHER_KICKED_LAST_PARTICIPANT;
                        }

                        $socket_room->save();

                        event(new EndCall(__('ALL_STUDENTS_KICKED'), $socket_room_id));

                        $response = response()->success(__('ALL_STUDENTS_KICKED'));
                    }

                    DB::commit();

                    return $response;
                }
            }
        } catch (Exception $exception) {
            DB::rollBack();

            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_8006, self::class, __FUNCTION__);

            return response()->error([
                'message' => 'User could not be kicked.',
                'data'    => [
                    'error' => $exception->getMessage(),
                ],
            ]);
        }
    }

    private function pickUpCall($payload, $participantState)
    {
        Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$request');
        Log::notice('payload: ');
        Log::notice($payload);
        Log::notice('participantState: ');
        Log::notice($participantState);
        DB::beginTransaction();

        try {
            $current_user   = $payload->user();
            $user_type      = $payload->user_type;
            $socket_room_id = $payload->socket_room_id;
            $room_info      = SocketRoom::query()
                ->where('id', $socket_room_id)
                ->first();

            if ($room_info) {
                if ($participantState == ParticipantStates::REJOINED) {
                    $room_participant            = SocketParticipant::query()
                        ->where('socket_room_id', '=', $socket_room_id)
                        ->where('user_id', '=', $current_user->id)
                        ->first();
                    $room_participant->is_active = $participantState;
                    $room_participant->save();
                } else {
                    // TODO: Pay attention to start time increase in case Supplier did not pick up until the very last moment. Supplier could end up with no time between calls.
                    $start_time = Carbon::now();
                    $end_time   = Carbon::now()->addminutes(intval($room_info->duration));
                    if ($user_type == UserTypes::PROVIDER) {
                        if ($room_info->teacher_joined == StateTypes::NO) {
                            SocketRoom::query()
                                ->where('id', '=', $socket_room_id)
                                ->update([
                                    'talk_start_time' => $start_time,
                                    'teacher_joined'  => StateTypes::YES,
                                    'talk_end_time'   => $end_time,
                                ]);

                            SocketParticipant::query()
                                ->where('socket_room_id', '=', $room_info->id)
                                ->where('user_id', '=', $current_user->id)
                                ->update([
                                    'room_joined' => $start_time,
                                    'is_active'   => $participantState,
                                ]);
                            SocketParticipant::query()
                                ->where('socket_room_id', '=', $room_info->id)
                                ->update([
                                    'room_end' => $end_time,
                                ]);
                        }
                    } else {
                        if ($user_type == UserTypes::CLIENT) {
                            SocketRoom::query()
                                ->where('id', '=', $socket_room_id)
                                ->update([
                                    'student_joined' => StateTypes::YES,
                                ]);

                            SocketParticipant::query()
                                ->where('socket_room_id', '=', $room_info->id)
                                ->where('user_id', '=', $current_user->id)
                                ->update([
                                    'is_active'   => $participantState,
                                    'room_joined' => $start_time,
                                ]);
                        }
                    }
                }
            }
            DB::commit();

            return response()->success('Call successfully picked up.');
        } catch (Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_8003, self::class, __FUNCTION__);

            return response()->error([
                'message' => 'Call could not be picked up.',
                'data'    => [
                    'error' => $exception->getMessage(),
                ],
            ]);
        }
    }

    private function declineTheCall(Request $payload)
    {
        Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$payload');
        Log::notice(json_encode($payload->all()));

        DB::beginTransaction();

        try {
            $room        = SocketRoom::query()->find($payload->get('socket_room_id'));
            $participant = SocketParticipant::query()->find($payload->get('socket_participant_id'));

            $data = [
                'user_id'            => $participant->user_id,
                'notification_value' => $room->booking_id,
                'action'             => Notifications::VALUE['call_declined'],
                'type'               => __('NOTIFICATION_CALL_DECLINED'),
                'notification_title' => __('NOTIFICATION_CALL_DECLINED_TITLE'),
                'notification_body'  => __('NOTIFICATION_CALL_DECLINED_BODY'),
            ];

            HelperModel::sendPushNotification($data);

            $participant->update([
                'is_active' => ParticipantStates::DECLINED,
            ]);

            DB::commit();

            return response()->success([
                'message' => 'Call successfully declined.',
                'data'    => [
                    'notification' => [
                        'type'  => __('NOTIFICATION_CALL_DECLINED'),
                        'title' => __('NOTIFICATION_CALL_DECLINED_TITLE'),
                        'body'  => __('NOTIFICATION_CALL_DECLINED_BODY'),
                    ],
                ],
            ]);
        } catch (Exception $exception) {
            DB::rollBack();

            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_8003, self::class, __FUNCTION__);
        }
    }

    private function hangUpCall($payload)
    {
        Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$request');
        Log::notice($payload);
        DB::beginTransaction();

        try {
            $twilio         = new Twilio();
            $current_user   = $payload->user();
            $user_type      = $payload->user_type;
            $socket_room_id = $payload->socket_room_id;
            $room_info      = SocketRoom::query()
                ->where('id', $socket_room_id)
                ->first();

            SocketParticipant::query()
                ->where('socket_room_id', '=', $socket_room_id)
                ->where('user_id', '=', $current_user->id)
                ->update([
                    'is_active' => ParticipantStates::HANGUP,
                ]);

            $room_participants = SocketParticipant::query()
                ->where('socket_room_id', '=', $socket_room_id)
                ->whereIn('is_active', [ParticipantStates::INACTIVE, ParticipantStates::JOINED, ParticipantStates::REJOINED, ParticipantStates::DECLINED])
                ->get();

            if (count($room_participants) <= 1 || $user_type == UserTypes::PROVIDER) {
                $twilio->closeRoom($socket_room_id);

                if ($user_type == UserTypes::PROVIDER) {
                    $room_info->state = RoomStates::TEACHER_CANCELLED;
                } else {
                    $room_info->state = RoomStates::ALL_STUDENTS_HANGUP;
                }
                $room_info->save();

                event(new EndCall($payload->reason, $socket_room_id));
                SocketParticipant::query()
                    ->where('socket_room_id', '=', $socket_room_id)
                    ->where('user_id', '!=', $current_user->id)
                    ->where('is_active', '!=', ParticipantStates::HANGUP)
                    ->update([
                        'is_active' => ParticipantStates::OTHER_PERSON_HANGUP,
                    ]);
            }
            DB::commit();

            return response()->success('Call successfully hanged.');
        } catch (Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_8004, self::class, __FUNCTION__);
        }
    }

    public function extendCallSuccess($payload)
    {
        Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$request');
        Log::notice($payload);
        DB::beginTransaction();

        try {
            $user                   = $payload->user();
            $socket_room_id         = $payload->socket_room_id;
            $extension_minutes      = $payload->extension_minutes;
            $extension_price        = $payload->extension_price;
            $client_name            = $payload->client_name;
            $client_profile_picture = $payload->client_profile_picture;
            $room_info              = SocketRoom::where('id', '=', $socket_room_id)
                ->first();
            $participant            = SocketParticipant::where('socket_room_id', '=', $socket_room_id)
                ->where('user_id', '=', $user->id)
                ->first();

            $current_end_time = $participant->room_end;

            // Because we are now extending talk on backend during payment,
            // this is not needed anymore to add minutes,
            // I am leaving variable because of compatibility with app
            $new_end_time = Carbon::parse($current_end_time)
                ->addMinutes(0);

            $new_minutes = Carbon::parse($participant->room_joined)
                ->diffInMinutes($new_end_time);

            $current_minutes = Carbon::now()
                ->diffInMinutes($new_end_time);

            event(
                new SingleUserExtension(
                    $current_minutes,
                    $new_minutes,
                    Carbon::parse($new_end_time)->addMinutes((int) $user->timezone)->toDateTimeString(),
                    $payload->supplier_id,
                    $client_name,
                    $client_profile_picture,
                    $extension_minutes,
                    $extension_price
                )
            );

            event(
                new SingleUserExtension(
                    $current_minutes,
                    $new_minutes,
                    Carbon::parse($new_end_time)->addMinutes((int) $user->timezone)->toDateTimeString(),
                    $user->id,
                    $client_name,
                    $client_profile_picture,
                    $extension_minutes,
                    $extension_price
                )
            );
            DB::commit();

            return response()->success('Call successfully extended.');
        } catch (Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_8005, self::class, __FUNCTION__);

            return response()->error([
                'message' => 'Call could extend the call.',
                'data'    => [
                    'error' => $exception->getMessage(),
                ],
            ]);
        }
    }

    public function roomStatus(Request $request)
    {
        Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$request');
        Log::notice($request);

        try {
            //TODO This need to be changed to get room based on user token as on user-rooms
            $socket_room_id = $request->socket_room_id;
            $user_id        = $request->user()->id;

            $room_info   = SocketRoom::where('id', '=', $socket_room_id)->first();
            $currentTime = date('Y-m-d H:i:s');
            $response    = [];

            if ($room_info) {
                $response["state"]         = $room_info->state;
                $response["redirect_url "] = $room_info->call_type === CallTypes::GROUP ? config('app.frontend_url') : null;
                if ($room_info->state == RoomStates::ROOM_DONE) {
                    return response()->error([
                        'message' => 'Room is done',
                        'data'    => [
                            'state' => $room_info->state,
                        ],
                    ]);
                }

                $participant = SocketParticipant::where('socket_room_id', '=', $socket_room_id)
                    ->where('user_id', '=', $user_id)
                    ->whereIn('is_active', [ParticipantStates::INACTIVE, ParticipantStates::JOINED, ParticipantStates::REJOINED, ParticipantStates::DECLINED])
                    ->first();

                if (!isset($participant->room_end) || $participant->room_end <= $currentTime) {
                    $response["state"] = RoomStates::ROOM_DONE;

                    return response()->error([
                        'message' => 'Room is done',
                        'data'    => $response,
                    ]);
                }

                $response["duration"]        = Carbon::now()->diffInMinutes(Carbon::parse($participant->room_end), false);
                $reqUserTimezone              = (int) $request->user()->timezone;
                $response["talk_start_time"] = Carbon::parse($room_info->talk_start_time)->addMinutes($reqUserTimezone)->format('Y-m-d H:i:s');
                $response["talk_end_time"]   = Carbon::parse($room_info->talk_end_time)->addMinutes($reqUserTimezone)->format('Y-m-d H:i:s');

                if ($room_info->teacher_joined == StateTypes::NO) {
                    $current_time                = Carbon::now()->addMinutes($reqUserTimezone)->toDateTimeString();
                    $end_time                    = Carbon::parse($current_time)->addMinutes((int) $room_info->duration)->toDateTimeString();
                    $response["talk_start_time"] = Carbon::now()->addMinutes($reqUserTimezone)->toDateTimeString();
                    $response["talk_end_time"]   = Carbon::parse($response["talk_start_time"])->addMinutes((int) $room_info->duration)->toDateTimeString();
                }

                $response["total_duration"] = Carbon::parse($room_info->talk_start_time)->diffInMinutes(Carbon::parse($participant->room_end), false);

                $voice_status_query_sub_query = SocketCallsProtocol::query()
                    ->selectRaw('socket_participant_id, max(created_at) as max_date')
                    ->whereIn('event', [Events::AUDIO_OFF, Events::AUDIO_ON, Events::GROUP_SUPPLIER_SET_ALL_AUDIO_OFF, Events::GROUP_SUPPLIER_SET_ALL_AUDIO_ON, Events::SUPPLIER_SET_CLIENT_AUDIO_OFF, Events::SUPPLIER_SET_CLIENT_AUDIO_ON])
                    ->groupBy('socket_participant_id');

                $voice_status_query = SocketCallsProtocol::query()
                    ->selectRaw('event AS voice_status, socket_calls_protocol.socket_participant_id')
                    ->whereIn('event', [Events::AUDIO_OFF, Events::AUDIO_ON, Events::GROUP_SUPPLIER_SET_ALL_AUDIO_OFF, Events::GROUP_SUPPLIER_SET_ALL_AUDIO_ON, Events::SUPPLIER_SET_CLIENT_AUDIO_OFF, Events::SUPPLIER_SET_CLIENT_AUDIO_ON])
                    ->joinSub($voice_status_query_sub_query, 'voice_status_query_sub_query', function ($join) {
                        $join->on('socket_calls_protocol.socket_participant_id', '=', 'voice_status_query_sub_query.socket_participant_id');
                        $join->on('socket_calls_protocol.created_at', '=', 'voice_status_query_sub_query.max_date');
                    });

                $video_status_query_sub_query = SocketCallsProtocol::query()
                    ->selectRaw('socket_participant_id, max(created_at) as max_date')
                    ->whereIn('event', [Events::VIDEO_ON, Events::VIDEO_OFF, Events::GROUP_SUPPLIER_SET_ALL_VIDEO_ON, Events::GROUP_SUPPLIER_SET_ALL_VIDEO_OFF, Events::SUPPLIER_SET_CLIENT_VIDEO_ON, Events::SUPPLIER_SET_CLIENT_VIDEO_OFF])
                    ->groupBy('socket_participant_id');

                $video_status_query = SocketCallsProtocol::query()
                    ->selectRaw('event AS video_status, socket_calls_protocol.socket_participant_id')
                    ->whereIn('event', [Events::VIDEO_ON, Events::VIDEO_OFF, Events::GROUP_SUPPLIER_SET_ALL_VIDEO_ON, Events::GROUP_SUPPLIER_SET_ALL_VIDEO_OFF, Events::SUPPLIER_SET_CLIENT_VIDEO_ON, Events::SUPPLIER_SET_CLIENT_VIDEO_OFF])
                    ->joinSub($video_status_query_sub_query, 'video_status_query_sub_query', function ($join) {
                        $join->on('socket_calls_protocol.socket_participant_id', '=', 'video_status_query_sub_query.socket_participant_id');
                        $join->on('socket_calls_protocol.created_at', '=', 'video_status_query_sub_query.max_date');
                    });

                $room_participants = SocketParticipant::where('socket_room_id', '=', $socket_room_id)
                    ->whereIn('is_active', [ParticipantStates::INACTIVE, ParticipantStates::JOINED, ParticipantStates::REJOINED, ParticipantStates::DECLINED])
                    ->leftJoinSub($voice_status_query, 'voice_status_query', function ($join) {
                        $join->on('socket_participants.id', '=', 'voice_status_query.socket_participant_id');
                    })
                    ->leftJoinSub($video_status_query, 'video_status_query', function ($join) {
                        $join->on('socket_participants.id', '=', 'video_status_query.socket_participant_id');
                    })
                    ->get();

                foreach ($room_participants as $participant) {
                    if (is_null($participant['voice_status'])) {
                        $participant['voice_status'] = Events::AUDIO_ON;
                    }
                    if (is_null($participant['video_status'])) {
                        $participant['video_status'] = Events::VIDEO_ON;
                    }

                    $participant->user_image = $participant->user_image ?: '/assets/images/avatar.png';
                }

                $response["active_users"] = $room_participants;
                $status                   = true;
            } else {
                $status            = false;
                $response["error"] = "Room not found.";
            }

            return response()->json([
                'success' => $status,
                'message' => 'Room Status.',
                'data'    => $response,
            ]);
        } catch (Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_8002, self::class, __FUNCTION__);
        }
    }

    public function userRooms(Request $payload)
    {
        Log::notice("\n\n" . self::class . '::' . __FUNCTION__ . '::$request');
        Log::notice($payload);

        try {
            $user_id = $payload->user()->id ?? 0;

            if (!$user_id) {
                $data = [
                    'success' => false,
                    'message' => 'User is not logged',
                ];
                Log::notice($data);

                return response()->error([
                    'message' => 'User is not logged in.',
                ], 403);
            }

            $currentTime = date('Y-m-d H:i:s');

            $socketRooms = SocketRoom::query()
                ->select('id as room_id', 'talk_id', 'talk_start_time', 'talk_end_time', 'room_name', 'state', 'call_type', 'talk_type')
                ->where('talk_start_time', '<=', $currentTime)
                ->where('talk_end_time', '>=', $currentTime)
                ->whereIn('state', [RoomStates::ROOM_PENDING, RoomStates::ROOM_IN_PROGRESS]);

            $socketParticipant = SocketParticipant::query()
                ->joinSub($socketRooms, 'socket_rooms', function ($join) {
                    $join->on('socket_rooms.room_id', '=', 'socket_participants.socket_room_id');
                })
                ->where('user_id', $user_id)
                ->where(function ($query) use ($currentTime) {
                    $query->where('socket_rooms.talk_start_time', '<=', $currentTime);
                    $query->where('socket_participants.room_end', '>=', $currentTime);
                })
                ->whereIn('is_active', [ParticipantStates::INACTIVE, ParticipantStates::JOINED, ParticipantStates::REJOINED, ParticipantStates::DECLINED])
                ->first();


            $response = [];

            if ($socketParticipant) {
                $userTimezone                                   = (int) $payload->user()->timezone;
                $socketParticipant->room_end                    = Carbon::parse($socketParticipant->room_end)->addMinutes($userTimezone)->format('Y-m-d H:i:s');
                $socketParticipant->talk_end_time               = Carbon::parse($socketParticipant->talk_end_time)->addMinutes($userTimezone)->format('Y-m-d H:i:s');
                $socketParticipant->talk_start_time             = Carbon::parse($socketParticipant->talk_start_time)->addMinutes($userTimezone)->format('Y-m-d H:i:s');
                $socketParticipant->user_image                  = $socketParticipant->user_image ?: '/assets/images/avatar.svg';
                $response['room']                               = $socketParticipant;
                $redirectUrl                                    = config('app.frontend_url') . "/talk/join?token={$socketParticipant->user->talk_token}";
                $response['room']['redirect_url']               = SocketRoom::find($response['room']['room_id'])->call_type === CallTypes::GROUP ? $redirectUrl : null;
                $waitingForSupplier                             = (int) (SocketRoom::find($response['room']['room_id'])->duration <= 15 ? config('duration.room.short') : config('duration.room.long'));
                $response['room']['waiting_for_supplier_until'] = Carbon::parse($socketParticipant->talk_start_time)->addMinutes($waitingForSupplier)->toDateTimeString();
                $response['room']['interactive_mode']           = Talk::find($response['room']['talk_id'])->interactive_mode ?? null;
                $response['room']['room_state']                 = $socketParticipant->state;

                if ($socketParticipant->user_type == UserTypes::CLIENT) {
                    $provider = SocketParticipant::where('socket_room_id', '=', $socketParticipant->socket_room_id)
                        ->where('user_type', '=', UserTypes::PROVIDER)
                        ->first();

                    $socketParticipant->user_image = $provider->user_image ?: '/assets/images/avatar.png';

                    $response['room']['provider_id']   = $provider->user_id;
                    $response['room']['provider_name'] = $provider->name_of_user;
                } else {
                    $response['room']['provider_name'] = 'Talkila';
                    $response['room']['provider_id']   = $socketParticipant->user_id;
                }

                $response['other_people'] = SocketParticipant::where('socket_room_id', '=', $socketParticipant->socket_room_id)
                    ->where('user_id', '!=', $socketParticipant->user_id)
                    ->get();

                $talk                          = Talk::query()->select('headline')->find($socketParticipant->talk_id);
                $response['room']['room_name'] = $talk->headline;
            } else {
                return response()->error('No room', 200);
            }

            return response()->success([
                'message' => 'Socket Rooms.',
                'data'    => $response,
            ]);
        } catch (Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_8007, self::class, __FUNCTION__);
        }
    }

    /**
     * Return the Voice/Video action, depending on the Event.
     *
     * @param $event
     *
     * @return string|null
     */
    protected function getEventAction($event): ?string
    {
        if (in_array($event, [
            Events::AUDIO_OFF,
            Events::AUDIO_ON,
            Events::GROUP_SUPPLIER_SET_ALL_AUDIO_OFF,
            Events::GROUP_SUPPLIER_SET_ALL_AUDIO_ON,
            Events::SUPPLIER_SET_CLIENT_AUDIO_OFF,
            Events::SUPPLIER_SET_CLIENT_AUDIO_ON,
        ])) {
            $action = 'voice';
        }

        if (in_array($event, [
            Events::VIDEO_ON,
            Events::VIDEO_OFF,
            Events::GROUP_SUPPLIER_SET_ALL_VIDEO_OFF,
            Events::GROUP_SUPPLIER_SET_ALL_VIDEO_ON,
            Events::SUPPLIER_SET_CLIENT_VIDEO_OFF,
            Events::SUPPLIER_SET_CLIENT_VIDEO_ON,
        ])) {
            $action = 'video';
        }

        return $action ?? null;
    }

    /**
     * Return the Voice/Video state, depending on the Event.
     *
     * @param $event
     *
     * @return string|null
     */
    protected function getEventState($event): ?string
    {
        if (in_array($event, [
            Events::AUDIO_ON,
            Events::VIDEO_ON,
            Events::GROUP_SUPPLIER_SET_ALL_AUDIO_ON,
            Events::GROUP_SUPPLIER_SET_ALL_VIDEO_ON,
            Events::SUPPLIER_SET_CLIENT_AUDIO_ON,
            Events::SUPPLIER_SET_CLIENT_VIDEO_ON,
        ])) {
            $state = 'on';
        }

        if (in_array($event, [
            Events::AUDIO_OFF,
            Events::VIDEO_OFF,
            Events::GROUP_SUPPLIER_SET_ALL_AUDIO_OFF,
            Events::GROUP_SUPPLIER_SET_ALL_VIDEO_OFF,
            Events::SUPPLIER_SET_CLIENT_AUDIO_OFF,
            Events::SUPPLIER_SET_CLIENT_VIDEO_OFF,
        ])) {
            $state = 'off';
        }

        return $state ?? null;
    }
}
