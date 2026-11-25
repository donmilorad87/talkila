<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserReportedRequest;
use App\Http\Requests\StoreUserReportedRequest;
use App\Http\Requests\UpdateUserReportedRequest;
use App\Models\HelperModel;
use App\Models\User;
use App\Models\UserReported;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UserReportedController extends Controller
{

    public function index(Request $request)
    {
        abort_if(Gate::denies('user_reported_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UserReported::with(['user', 'reporter_user'])->select(sprintf('%s.*', (new UserReported)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = '';
                $editGate      = '';
                $deleteGate    = 'user_reported_delete';
                $crudRoutePart = 'user-reporteds';

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

            $table->addColumn('reporter_user_email', function ($row) {
                return $row->reporter_user ? $row->reporter_user->email : '';
            });

            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : "";
            });
            $table->editColumn('state', function ($row) {
                return $row->state ? $row->state : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'reporter_user']);

            return $table->make(true);
        }

        $users = User::limit(10)->get()->pluck('email')->toArray();

        return view('admin.userReporteds.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_reported_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::limit(10)->get()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

      //  $reporter_users = User::all()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.userReporteds.create', compact('users'));
    }

    public function store(StoreUserReportedRequest $request)
    {
        $userReported = UserReported::create($request->all());

        return redirect()->route('admin.user-reporteds.index');
    }

    public function edit(UserReported $userReported)
    {
        abort_if(Gate::denies('user_reported_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

       /* $users = User::all()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $reporter_users = User::all()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');*/

        $userReported->load('user', 'reporter_user');

        return view('admin.userReporteds.edit', compact('userReported'));
    }

    public function update(UpdateUserReportedRequest $request, UserReported $userReported)
    {
        $userReported->update($request->all());

        return redirect()->route('admin.user-reporteds.index');
    }

    public function show(UserReported $userReported)
    {
        abort_if(Gate::denies('user_reported_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userReported->load('user', 'reporter_user');

        return view('admin.userReporteds.show', compact('userReported'));
    }

    public function userReporteds(Request $request, $id)
    {
        if ($request->ajax()) {
           $query = UserReported::with('user', 'reporter_user')->where('user_id', $id)->get();

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '');

            return $table->make(true);
        }
    }

    public function destroy(UserReported $userReported)
    {
        abort_if(Gate::denies('user_reported_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userReported->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserReportedRequest $request)
    {
        UserReported::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
