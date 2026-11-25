<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyUserBookmarkedTalksRequest;
use App\Http\Requests\StoreUserBookmarkedTalksRequest;
use App\Http\Requests\UpdateUserBookmarkedTalksRequest;
use App\Models\UserBookmarkedTalks;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UserBookmarkedTalksController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('user_bookmarked_talks_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UserBookmarkedTalks::query()->select(sprintf('%s.*', (new UserBookmarkedTalks)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'user_bookmarked_talks_show';
                $editGate      = 'user_bookmarked_talks_edit';
                $deleteGate    = 'user_bookmarked_talks_delete';
                $crudRoutePart = 'user-bookmarked-talks';

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
            $table->editColumn('user_id', function ($row) {
                return $row->user_id ? $row->user_id : "";
            });
            $table->editColumn('talks_id', function ($row) {
                return $row->talks_id ? $row->talks_id : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.userBookmarkedTalks.index');
    }

    public function create()
    {
        abort_if(Gate::denies('user_bookmarked_talks_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.userBookmarkedTalks.create');
    }

    public function store(StoreUserBookmarkedTalksRequest $request)
    {
        $userBookmarkedTalks = UserBookmarkedTalks::create($request->all());

        return redirect()->route('admin.user-bookmarked-talks.index');
    }

    public function edit(UserBookmarkedTalks $userBookmarkedTalks)
    {
        abort_if(Gate::denies('user_bookmarked_talks_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.userBookmarkedTalks.edit', compact('userBookmarkedTalks'));
    }

    public function update(UpdateUserBookmarkedTalksRequest $request, UserBookmarkedTalks $userBookmarkedTalks)
    {
        $userBookmarkedTalks->update($request->all());

        return redirect()->route('admin.user-bookmarked-talks.index');
    }

    public function show(UserBookmarkedTalks $userBookmarkedTalks)
    {
        abort_if(Gate::denies('user_bookmarked_talks_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.userBookmarkedTalks.show', compact('userBookmarkedTalks'));
    }

    public function destroy(UserBookmarkedTalks $userBookmarkedTalks)
    {
        abort_if(Gate::denies('user_bookmarked_talks_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userBookmarkedTalks->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserBookmarkedTalksRequest $request)
    {
        UserBookmarkedTalks::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function userBookmarkedTalks(Request $request, $id)
    {
        if ($request->ajax()) {
            $query = UserBookmarkedTalks::with('user', 'talk')->where('user_id', $id)->get();

            $table = Datatables::of($query);

            // $table->addColumn('placeholder', '');

            return $table->make(true);
        }
    }
}
