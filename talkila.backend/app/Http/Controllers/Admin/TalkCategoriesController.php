<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyTalkCategoriesRequest;
use App\Http\Requests\StoreTalkCategoriesRequest;
use App\Http\Requests\UpdateTalkCategoriesRequest;
use App\Models\TalkCategories;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TalkCategoriesController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('talk_categories_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = TalkCategories::query()->with('talks')->select(sprintf('%s.*', (new TalkCategories)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = '';
                $editGate      = '';
                $deleteGate    = 'talk_categories_delete';
                $crudRoutePart = 'talk-categories';

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
            $table->editColumn('talks', function ($row) {
                if ($row->talks->count()) {
                    return $row->talks->count();
                }
                return "";
            });
            $table->editColumn('croatian', function ($row) {
                return $row->croatian ?: "";
            });
            $table->editColumn('german', function ($row) {
                return $row->german ?: "";
            });
            $table->editColumn('english', function ($row) {
                return $row->english ?: "";
            });
            $table->editColumn('polish', function ($row) {
                return $row->polish ?: "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.talksCategories.index');
    }

    public function create()
    {
        abort_if(Gate::denies('talk_categories_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.talksCategories.create');
    }

    public function store(StoreTalkCategoriesRequest $request)
    {
        $talkCategories = TalkCategories::create($request->all());

        return redirect()->route('admin.talk-categories.index');
    }

    public function edit(TalkCategories $talkCategories, $id)
    {
        abort_if(Gate::denies('talk_categories_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $talksCategories  = TalkCategories::query()->find($id);

        return view('admin.talksCategories.edit', compact('talksCategories'));
    }

    public function update(UpdateTalkCategoriesRequest $request, TalkCategories $talkCategories, $id)
    {
        TalkCategories::query()->find($id)->update($request->all());

        return redirect()->route('admin.talk-categories.index');
    }

    public function show(TalkCategories $talkCategories, $id)
    {
        abort_if(Gate::denies('talk_categories_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $talkCategories = TalkCategories::query()->find($id);
        return view('admin.talksCategories.show', compact('talkCategories'));
    }

    public function destroy(TalkCategories $talkCategories, $id)
    {
        abort_if(Gate::denies('talk_categories_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        TalkCategories::query()->find($id)->delete();

        return back();
    }

    public function massDestroy(MassDestroyTalkCategoriesRequest $request)
    {
        TalkCategories::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
