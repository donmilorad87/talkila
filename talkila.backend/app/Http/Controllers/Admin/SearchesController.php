<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySearchRequest;
use App\Http\Requests\StoreSearchRequest;
use App\Http\Requests\UpdateSearchRequest;
use App\Models\Search;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SearchesController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('search_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Search::with(['user'])->select(sprintf('%s.*', (new Search)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'search_show';
                $editGate      = 'search_edit';
                $deleteGate    = 'search_delete';
                $crudRoutePart = 'searches';

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

            $table->editColumn('term', function ($row) {
                return $row->term ? $row->term : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'user']);

            return $table->make(true);
        }

        $users = User::get()->pluck('email')->toArray();

        return view('admin.searches.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('search_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.searches.create', compact('users'));
    }

    public function store(StoreSearchRequest $request)
    {
        $search = Search::create($request->all());

        return redirect()->route('admin.searches.index');
    }

    public function edit(Search $search)
    {
        abort_if(Gate::denies('search_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $search->load('user');

        return view('admin.searches.edit', compact('users', 'search'));
    }

    public function update(UpdateSearchRequest $request, Search $search)
    {
        $search->update($request->all());

        return redirect()->route('admin.searches.index');
    }

    public function show(Search $search)
    {
        abort_if(Gate::denies('search_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $search->load('user');

        return view('admin.searches.show', compact('search'));
    }

    public function userSearches(Request $request, $id)
    {
        if ($request->ajax()) {
           $query = Search::with('user')->where('user_id', $id)->get();

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '');

            return $table->make(true);
        }
    }

    public function destroy(Search $search)
    {
        abort_if(Gate::denies('search_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $search->delete();

        return back();
    }

    public function massDestroy(MassDestroySearchRequest $request)
    {
        Search::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
