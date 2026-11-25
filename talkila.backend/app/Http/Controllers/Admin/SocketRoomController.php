<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SocketRoomRequest;
use App\Models\SocketParticipant;
use App\Models\SocketRoom;
use App\Models\Talk;
use App\Models\User;
use App\Models\UserVerificationRequests;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class SocketRoomController extends Controller
{
    public function index(Request $request)
    {
        // abort_if(Gate::denies('socket_room_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $query = SocketRoom::select(sprintf('%s.*', (new SocketRoom)->table))->get();
        $durations = $query->pluck('duration')->unique()->sort()->values()->all();

        if ($request->ajax()) {
            $table = Datatables::of($query);

            $table->editColumn('id', function ($row) {
                return $row->id ?: "";
            });

            $table->editColumn('talk_id', function ($row) {
                return $row->talk_id ?: "";
            });

            $table->editColumn('room_name', function ($row) {
                return $row->room_name ?: "";
            });

            $table->editColumn('talk_start_time', function ($row) {
                return Carbon::parse($row->talk_start_time)->format('Y-m-d h:i') ?: "";
            });

            $table->editColumn('talk_end_time', function ($row) {
                return Carbon::parse($row->talk_end_time)->format('Y-m-d h:i') ?: "";
            });

            $table->editColumn('duration', function ($row) {
                return $row->duration . ' minutes' ?: "";
            });

            $table->editColumn('call_type', function ($row) {
                return $row->call_type ?: "";
            });

            $table->editColumn('teacher_joined', function ($row) {
                return $row->teacher_joined ?: 0;
            });

            $table->editColumn('student_joined', function ($row) {
                return $row->student_joined ?: 0;
            });

            $table->editColumn('state', function ($row) {
                return $row->state ?: "";
            });

            return $table->addIndexColumn()->make(true);
        }

        return view('admin.socketRooms.index', [
            'durations' => $durations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $currentTime  = Carbon::now()->format('Y-m-d\TH:i');
        $talks        = Talk::all();
        $participants = User::query()
            ->where('id', '>', 1)
            ->get();
        $suppliers    = User::query()
            ->select('id', 'name', 'username', 'email')
            ->where('type', User::TYPE['supplier'])
            ->whereHas('talks', function ($query) {
                return $query->where('state', Talk::STATE['valid']);
            })
            ->whereHas('profileVerificationRequests', function ($query) {
                return $query->where('state', UserVerificationRequests::STATE['approved']);
            })
            ->get()
            ->toArray();

        return view('admin.socketRooms.create', [
            'currentTime'  => $currentTime,
            'talks'        => $talks,
            'participants' => $participants,
            'suppliers'    => $suppliers,
        ]);
    }

    public function talksSelectList(Request $request)
    {
        $authorised = auth()->user();

        if ($authorised) {
            $teacherId = $request->input('teacherId');

            $talks = Talk::query()
                ->where('teacher_user_id', $teacherId)
                ->where('state', Talk::STATE['valid'])
                ->get()
                ->toArray();

            return response()->json([
                'html' => view('admin.includes._pick_teacher_select', [
                    'talks' => $talks,
                ])->render(),
            ]);
        }
    }

    public function store(SocketRoomRequest $request)
    {
        try {
            DB::beginTransaction();
            $socketRoom = SocketRoom::create($request->all());
            DB::commit();
        } catch (Exception $exception) {
            Log::error($exception);

            DB::rollBack();
        }
        return redirect()->route('index');
    }

    public function show(SocketRoom $socketRoom)
    {
        // abort_if(Gate::denies('socket_room_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $socketRoom->load('talk', 'participants.user', 'call_protocols');

        $totalParticipiants = $socketRoom->participants->count();

        $totalEvents = $socketRoom->call_protocols->count();

        $users = SocketParticipant::where('socket_room_id', $socketRoom->id)->select('name_of_user')->distinct()->get();

        return view('admin.socketRooms.show', compact('socketRoom', 'totalParticipiants', 'users', 'totalEvents'));
    }
}
