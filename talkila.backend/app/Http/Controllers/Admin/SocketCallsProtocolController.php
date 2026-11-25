<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Events;
use App\Http\Controllers\Controller;
use App\Http\Requests\SocketCallsProtocolRequest;
use App\Models\SocketCallsProtocol;
use Carbon\Carbon;
use Exception;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SocketCallsProtocolController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('socket_room_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $room_id = $_GET['room_id'];

            $query = SocketCallsProtocol::with('participant', 'participant.booking', 'participant.user')->where('socket_calls_protocol.socket_room_id', $room_id)->select(sprintf('%s.*', (new SocketCallsProtocol)->table));

            $table = Datatables::of($query);

            $table->addColumn('supplier_user_id', function ($row) {
                return $this->isSupplier($row) ? $row->participant->user_id : '';
            });

            $table->addColumn('client_user_id', function ($row) {
                return $this->isClient($row) ? $row->participant->user_id : '';
            });

            $table->addColumn('supplier_username', function ($row) {
                return $this->isSupplier($row) ? ($row->participant->user ? $row->participant->user->username : 'No username') : '';
            });

            $table->addColumn('client_username', function ($row) {
                return $this->isClient($row) ? ($row->participant->user ? $row->participant->user->username : 'No username') : '';
            });

            $table->addColumn('supplier_event', function ($row) {
                return $this->isSupplier($row) ? $this->getEvent($row->event) : '';
            });

            $table->addColumn('client_event', function ($row) {
                return $this->isClient($row) ? $this->getEvent($row->event) : '';
            });

            $table->addColumn('supplier_data', function ($row) {
                return $this->isSupplier($row) ? $row->support_data : '';
            });

            $table->addColumn('client_data', function ($row) {
                return $this->isClient($row) ? $row->support_data : '';
            });

            $table->addColumn('supplier_received', function ($row) {
                return $this->isSupplier($row) ? Carbon::parse($row->created_at)->subHours(2) : '';
            });

            $table->addColumn('client_received', function ($row) {
                return $this->isClient($row) ? Carbon::parse($row->created_at)->subHours(2) : '';
            });

            // $table->editColumn('participant.user_id', function ($row) {
            //     return $row->participant ? $row->participant->user_id : "";
            // });
            //
            // $table->editColumn('participant.name_of_user', function ($row) {
            //     return $row->participant ? $row->participant->name_of_user : "";
            // });
            //
            // $table->editColumn('event', function ($row) {
            //     return $row->event ? $row->event : "";
            // });
            //
            // $table->editColumn('support_data', function ($row) {
            //     return $row->support_data ? $row->support_data : "";
            // });
            //
            // $table->editColumn('created_at  ', function ($row) {
            //     return $row->created_at ? $row->created_at : "";
            // });

            return $table->addIndexColumn()->make(true);
        }
    }

    public static function store(SocketCallsProtocolRequest $request)
    {
        try {
            DB::beginTransaction();
            $socketCallProtocol = SocketCallsProtocol::create($request->all());
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
        }
        return redirect()->route('index');
    }

    /**
     * Determine whether the user data belongs to a Supplier.
     *
     * @param $row
     *
     * @return bool
     */
    function isSupplier($row): bool
    {
        return $row->participant->user_id == $row->participant->booking->teacher_user_id;
    }

    /**
     * Determine whether the user data belongs to a Client.
     *
     * @param $row
     *
     * @return bool
     */
    function isClient($row): bool
    {
        return $row->participant->user_id != $row->participant->booking->teacher_user_id;
    }

    /**
     * @param $event
     *
     * @return string
     */
    function getEvent($event)
    {
        switch ($event) {
            case Events::UNDEFINED:
                return 'Undefined';
            case Events::PICKUP:
                return 'Pickup';
            case Events::HANGUP:
                return 'Hangup';
            case Events::REDIAL:
                return 'Redial';
            case Events::CLIENT_WAITING:
                return 'Client Waiting';
            case Events::SUPPLIER_WAITING:
                return 'Provider Waiting';
            case Events::TALK_END:
                return 'Talk End';
            case Events::SUPPLIER_LEFT_ROOM:
                return 'Teacher Left Room';
            case Events::CLIENT_LEFT_ROOM:
                return 'User Left Room';
            case Events::AUDIO_OFF:
                return 'Mute On';
            case Events::AUDIO_ON:
                return 'Mute Off';
            case Events::VIDEO_ON:
                return 'Video On';
            case Events::VIDEO_OFF:
                return 'Video Off';
            case Events::SPEAKER_ON:
                return 'Speaker On';
            case Events::SPEAKER_OFF:
                return 'Speaker Off';
            case Events::EXTEND_CALL_TAB:
                return 'Extend Call Tab';
            case Events::EXTEND_CALL_TIME_SELECTED:
                return 'Extend Call Time Selected';
            case Events::EXTEND_CALL_SWIPED:
                return 'Extend Call Swiped';
            case Events::EXTEND_CALL_SUCCESSFUL:
                return 'Extend Call Successful';
            case Events::EXTEND_CALL_FAILURE:
                return 'Extend Call Failure';
            case Events::EXTEND_CALL_ACCEPT:
                return 'Extend Call Accept';
            case Events::EXTEND_CALL_REJECT:
                return 'Extend Call Reject';
            case Events::EXTEND_CALL_REQUEST:
                return 'Extend Call Request';
            case Events::CONNECTION_LOST:
                return 'Connection Lost';
            case Events::APP_CRASH_CLIENT:
                return 'App Crash Client';
            case Events::APP_CRASH_PROVIDER:
                return 'App Crash Provider';
            case Events::GROUP_SUPPLIER_SET_ALL_AUDIO_OFF:
                return 'Group Provider Set All Mute';
            case Events::GROUP_SUPPLIER_SET_ALL_AUDIO_ON:
                return 'Group Provider Set All Unmute';
            case Events::GROUP_SUPPLIER_SET_ALL_VIDEO_OFF:
                return 'Group Provider Set All Video Off';
            case Events::GROUP_SUPPLIER_SET_ALL_VIDEO_ON:
                return 'Group Provider Set All Video On';
            case Events::SUPPLIER_SET_CLIENT_AUDIO_OFF:
                return 'Group Provider Set Client To Mute';
            case Events::SUPPLIER_SET_CLIENT_TO_AUDIO_ON:
                return 'Group Provider Set Client To Unmute';
            case Events::SUPPLIER_SET_CLIENT_VIDEO_OFF:
                return 'Group Provider Set Client Video Off';
            case Events::SUPPLIER_SET_CLIENT_VIDEO_ON:
                return 'Group Provider Set Client Video On';
            case Events::KICK_PARTICIPANT:
                return 'Kick Participant';
            case Events::SUPPLIER_ON_HOLD:
                return 'Provider On Hold';
            case Events::SUPPLIER_ON_HOLD_BACK:
                return 'Provider On Hold Back';
            case Events::CLIENT_ON_HOLD:
                return 'Client On Hold';
            case Events::CLIENT_ON_HOLD_BACK:
                return 'Client On Hold Back';
            case Events::SCREEN_SHARE_ON:
                return 'Screen Share On';
            case Events::SCREEN_SHARE_OFF:
                return 'Screen Share Off';
            case Events::RECONNECT_TO_ROOM:
                return 'Reconnect To Room';
            default:
                return '';
        }
    }
}
