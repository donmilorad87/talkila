<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyStaticBlockedUserRequest;
use App\Http\Requests\StoreStaticBlockedUserRequest;
use App\Http\Requests\UpdateStaticBlockedUserRequest;
use App\Models\StaticBlockedUser;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class StaticBlockedUserController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('static_blocked_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = StaticBlockedUser::query()->select(sprintf('%s.*', (new StaticBlockedUser)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'static_blocked_user_show';
                $editGate      = 'static_blocked_user_edit';
                $deleteGate    = 'static_blocked_user_delete';
                $crudRoutePart = 'static-blocked-users';

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
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.staticBlockedUsers.index');
    }

    public function create()
    {
        abort_if(Gate::denies('static_blocked_user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.staticBlockedUsers.create');
    }

    public function store(StoreStaticBlockedUserRequest $request)
    {
        $staticBlockedUser = StaticBlockedUser::create($request->all());

        return redirect()->route('admin.static-blocked-users.index');
    }

    public function edit(StaticBlockedUser $staticBlockedUser)
    {
        abort_if(Gate::denies('static_blocked_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.staticBlockedUsers.edit', compact('staticBlockedUser'));
    }

    public function update(UpdateStaticBlockedUserRequest $request, StaticBlockedUser $staticBlockedUser)
    {
        $staticBlockedUser->update($request->all());

        return redirect()->route('admin.static-blocked-users.index');
    }

    public function show(StaticBlockedUser $staticBlockedUser)
    {
        abort_if(Gate::denies('static_blocked_user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.staticBlockedUsers.show', compact('staticBlockedUser'));
    }

    public function destroy(StaticBlockedUser $staticBlockedUser)
    {
        abort_if(Gate::denies('static_blocked_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $staticBlockedUser->delete();

        return back();
    }

    public function massDestroy(MassDestroyStaticBlockedUserRequest $request)
    {
        StaticBlockedUser::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
