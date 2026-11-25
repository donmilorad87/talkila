<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SocketParticipantRequest;
use App\Models\SocketParticipant;
use Exception;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SocketParticipantController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('socket_room_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $room_id = $_GET['room_id'];

            $query = SocketParticipant::with('user')->where('socket_room_id', $room_id)->select(sprintf('%s.*', (new SocketParticipant)->table));

            $table = Datatables::of($query);

            $table->editColumn('user_id', function ($row) {
                return $row->user_id ?: "";
            });

            $table->editColumn('name_of_user', function ($row) {
                return optional($row->user)->name ?: "";
            });

            $table->editColumn('username', function ($row) {
                return optional($row->user)->username ?: "No username";
            });

            $table->editColumn('firebase_id', function ($row) {
                return $row->firebase_id ?: "";
            });

            $table->editColumn('is_active', function ($row) {
                return $row->is_active;
            });

            $table->editColumn('is_anonym', function ($row) {
                return $row->is_anonym;
            });

            $table->editColumn('device_type', function ($row) {
                return optional($row->user)->device_type ? 'Phone' : 'Desktop';
            });

            $table->editColumn('device_model', function ($row) {
                return optional($row->user)->device_type ?: '';
            });

            $table->editColumn('room_joined', function ($row) {
                return $row->room_joined ?: "";
            });

            $table->editColumn('room_end', function ($row) {
                return $row->room_end ?: "";
            });

            return $table->make(true);
        }
    }

    public function store(SocketParticipantRequest $request)
    {
        try {
            DB::beginTransaction();
            $socketParticipant = SocketParticipant::create($request->all());
            DB::commit();

            return $socketParticipant;
        } catch(Exception $exception) {
            DB::rollBack();
        }
        return redirect()->route('index');
    }
}
