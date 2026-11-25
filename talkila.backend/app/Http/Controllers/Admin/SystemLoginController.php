<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySystemLoginRequest;
use App\Http\Requests\StoreSystemLoginRequest;
use App\Http\Requests\UpdateSystemLoginRequest;
use App\Models\SystemLogin;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SystemLoginController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('system_login_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SystemLogin::with(['user'])->select(sprintf('%s.*', (new SystemLogin)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'system_login_show';
                $editGate      = 'system_login_edit';
                $deleteGate    = 'system_login_delete';
                $crudRoutePart = 'system-logins';

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

            $table->editColumn('login_type', function ($row) {
                return $row->login_type ? $row->login_type : "";
            });
            $table->editColumn('type', function ($row) {
                return $row->type ? $row->type : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'user']);

            return $table->make(true);
        }

        $users = User::get()->pluck('email')->toArray();

        return view('admin.systemLogins.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('system_login_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.systemLogins.create', compact('users'));
    }

    public function store(StoreSystemLoginRequest $request)
    {
        $systemLogin = SystemLogin::create($request->all());

        return redirect()->route('admin.system-logins.index');
    }

    public function edit(SystemLogin $systemLogin)
    {
        abort_if(Gate::denies('system_login_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $systemLogin->load('user');

        return view('admin.systemLogins.edit', compact('users', 'systemLogin'));
    }

    public function update(UpdateSystemLoginRequest $request, SystemLogin $systemLogin)
    {
        $systemLogin->update($request->all());

        return redirect()->route('admin.system-logins.index');
    }

    public function show(SystemLogin $systemLogin)
    {
        abort_if(Gate::denies('system_login_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $systemLogin->load('user');

        return view('admin.systemLogins.show', compact('systemLogin'));
    }

    public function destroy(SystemLogin $systemLogin)
    {
        abort_if(Gate::denies('system_login_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $systemLogin->delete();

        return back();
    }

    public function massDestroy(MassDestroySystemLoginRequest $request)
    {
        SystemLogin::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
