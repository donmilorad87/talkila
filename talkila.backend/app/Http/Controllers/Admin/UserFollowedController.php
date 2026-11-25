<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyUserFollowedRequest;
use App\Http\Requests\StoreUserFollowedRequest;
use App\Http\Requests\UpdateUserFollowedRequest;
use App\Models\User;
use App\Models\UserFollowed;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UserFollowedController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('user_followed_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UserFollowed::with(['user', 'follower_user'])->select(sprintf('%s.*', (new UserFollowed)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'user_followed_show';
                $editGate      = 'user_followed_edit';
                $deleteGate    = 'user_followed_delete';
                $crudRoutePart = 'users-followed';

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

            $table->addColumn('follower_user_email', function ($row) {
                return $row->follower_user ? $row->follower_user->email : '';
            });

            $table->editColumn('state', function ($row) {
                return $row->state ? $row->state : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'follower_user']);

            return $table->make(true);
        }

        return view('admin.userFolloweds.index');
    }

    public function create()
    {
        abort_if(Gate::denies('user_followed_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::limit(10)->get()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

      //  $follower_users = User::all()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.userFolloweds.create', compact('users'));
    }

    public function store(StoreUserFollowedRequest $request)
    {
        $userFollowed = UserFollowed::create($request->all());

        return redirect()->route('admin.users-followed.index');
    }

    public function edit(UserFollowed $userFollowed)
    {
        abort_if(Gate::denies('user_followed_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    /*    $users = User::limit(10)->get()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $follower_users = User::limit(10)->get()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');*/

        $userFollowed->load('user', 'follower_user');

        return view('admin.userFolloweds.edit', compact('userFollowed'));
    }

    public function update(UpdateUserFollowedRequest $request, UserFollowed $userFollowed)
    {
        $input = $request->all();
        //$input['state'] = 0;
        $userFollowed->update($input);

        return redirect()->route('admin.users-followed.index');
    }

    public function show(UserFollowed $userFollowed)
    {
        abort_if(Gate::denies('user_followed_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userFollowed->load('user', 'follower_user');

        return view('admin.userFolloweds.show', compact('userFollowed'));
    }

    public function userFolloweds(Request $request, $id)
    {
      //  if ($request->ajax()) {
            
            $query = UserFollowed::with('user', 'follower_user')->where('user_id', $id)->get();

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '');

            $table->editColumn('follower', function ($row) {
                if($row->follower_user !== null){
                    return $row->follower_user->username ? $row->follower : '';
                }
                return "";
            });

            return $table->make(true);
       // }
    }

    public function destroy(UserFollowed $userFollowed)
    {
        abort_if(Gate::denies('user_followed_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userFollowed->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserFollowedRequest $request)
    {
        UserFollowed::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
