<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserBlockedRequest;
use App\Http\Requests\StoreUserBlockedRequest;
use App\Http\Requests\UpdateUserBlockedRequest;
use App\Models\User;
use App\Models\UserBlocked;
use Auth;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UserBlockedController extends Controller
{

    public function index(Request $request)
    {
        abort_if(Gate::denies('user_blocked_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UserBlocked::with(['user', 'blocked_user'])->select(sprintf('%s.*', (new UserBlocked)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = '';
                $editGate      = '';
                $deleteGate    = 'user_blocked_delete';
                $crudRoutePart = 'users-blocked';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->addColumn('user_email', function ($row) {
                return $row->user ? $row->user->email : '';
            });

            $table->addColumn('blocked_user_email', function ($row) {
                return $row->blocked_user ? $row->blocked_user->email : '';
            });

            $table->editColumn('state', function ($row) {
                return $row->state ? $row->state : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'blocked_user']);

            return $table->make(true);
        }

        return view('admin.userBlockeds.index');
    }

    public function create()
    {
        abort_if(Gate::denies('user_blocked_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::get()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        // $blocked_users = User::limit(10)->get()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.userBlockeds.create', compact('users'));
    }

    public function store(StoreUserBlockedRequest $request)
    {
        $userBlocked = UserBlocked::create($request->all());

        return redirect()->route('admin.users-blocked.index');
    }

    public function edit(UserBlocked $userBlocked)
    {
        abort_if(Gate::denies('user_blocked_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

       /* $users = User::all()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $blocked_users = User::all()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');*/

        $userBlocked->load('user', 'blocked_user');

        return view('admin.userBlockeds.edit', compact('userBlocked'));
    }

    public function update(UpdateUserBlockedRequest $request, UserBlocked $userBlocked)
    {
        $input = $request->all();
        $input['state'] = 0;

        $userBlocked->update($input);

        return redirect()->route('admin.users-blocked.index');
    }

    public function show(UserBlocked $userBlocked)
    {
        abort_if(Gate::denies('user_blocked_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userBlocked->load('user', 'blocked_user');

        return view('admin.userBlockeds.show', compact('userBlocked'));
    }

    public function userBlocked(Request $request, User $user)
    {
        if ($request->ajax()) {
            $timezone               = $user->timezone ?: 0;
            $requestTimezoneHour    = abs($timezone / 60);
            $requestTimezoneMinutes = abs($timezone % 60);
            $requestTimezoneSign    = $timezone < 0 ? '+' : '-';
            $timezoneDifference     = "{$requestTimezoneSign}{$requestTimezoneHour}:{$requestTimezoneMinutes}";

            $query = $user->blockedUsers()
                ->join('users', 'user_blockeds.blocked_user_id', '=', 'users.id')
                ->select([
                    'user_blockeds.id',
                    'users.username',
                    'users.name',
                    'user_blockeds.blocked_user_id',
                    'user_blockeds.state',
                ])
                ->selectRaw("TO_CHAR(user_blockeds.created_at + INTERVAL '{$timezoneDifference}', 'DD.MM.YYYY HH24:MI:SS') AS created_at")
                ->get();

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '');

            return $table->make(true);
        }
    }

    public function blockUser(Request $request, $id)
    {
        dd($id);
        $userBlocked = UserBlocked::create([
            'user_id' => Auth::user()->id,
            'blocked_user_id' => $id
        ]);

        return redirect()->back();
    }

    public function destroy(UserBlocked $userBlocked)
    {
        abort_if(Gate::denies('user_blocked_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userBlocked->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserBlockedRequest $request)
    {
        UserBlocked::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
