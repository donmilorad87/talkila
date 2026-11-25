<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyUserDontShowAgainRequest;
use App\Http\Requests\StoreUserDontShowAgainRequest;
use App\Http\Requests\UpdateUserDontShowAgainRequest;
use App\Models\User;
use App\Models\UserDontShowAgain;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UserDontShowAgainController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('user_dont_show_again_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $query = UserDontShowAgain::with(['user', 'dont_show_again_user'])->select(sprintf('%s.*', (new UserDontShowAgain)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'user_dont_show_again_show';
                $editGate      = 'user_dont_show_again_edit';
                $deleteGate    = 'user_dont_show_again_delete';
                $crudRoutePart = 'user-dont-show-against';

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

            $table->addColumn('dont_show_again_user_email', function ($row) {
                return $row->dont_show_again_user ? $row->dont_show_again_user->email : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'dont_show_again_user']);

            return $table->make(true);
        }

        $users = User::limit(10)->get()->pluck('email')->toArray();

        return view('admin.userDontShowAgains.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_dont_show_again_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::limit(10)->get()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        //$dont_show_again_users = User::all()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.userDontShowAgains.create', compact('users'));
    }

    public function store(StoreUserDontShowAgainRequest $request)
    {
        $userDontShowAgain = UserDontShowAgain::create($request->all());

        return redirect()->route('admin.user-dont-show-against.index');
    }

    public function edit(UserDontShowAgain $userDontShowAgain)
    {
        abort_if(Gate::denies('user_dont_show_again_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::limit(10)->get()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $dont_show_again_users = User::limit(10)->get()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $userDontShowAgain->load('user', 'dont_show_again_user');

        return view('admin.userDontShowAgains.edit', compact('users', 'dont_show_again_users', 'userDontShowAgain'));
    }

    public function update(UpdateUserDontShowAgainRequest $request, UserDontShowAgain $userDontShowAgain)
    {
        $userDontShowAgain->update($request->all());

        return redirect()->route('admin.user-dont-show-against.index');
    }

    public function show(UserDontShowAgain $userDontShowAgain)
    {
        abort_if(Gate::denies('user_dont_show_again_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userDontShowAgain->load('user', 'dont_show_again_user');

        return view('admin.userDontShowAgains.show', compact('userDontShowAgain'));
    }

    public function userDontShowAgains(Request $request, $id)
    {
        if ($request->ajax()) {
           $query = UserDontShowAgain::with('user', 'dont_show_again_user')->where('user_id', $id)->get();

            $table = Datatables::of($query);

            $table->editColumn('actions', function ($row) {
                $viewGate      = '';
                $editGate      = '';
                $deleteGate    = 'user_dont_show_again_delete';
                $crudRoutePart = 'user-dont-show-against';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->addColumn('placeholder', '');

            return $table->make(true);
        }
    }

    public function destroy(UserDontShowAgain $userDontShowAgain)
    {
        abort_if(Gate::denies('user_dont_show_again_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userDontShowAgain->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserDontShowAgainRequest $request)
    {
        UserDontShowAgain::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
