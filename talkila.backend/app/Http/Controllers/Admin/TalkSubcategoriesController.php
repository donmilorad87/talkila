<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyTalkSubcategoriesRequest;
use App\Http\Requests\StoreTalkSubcategoriesRequest;
use App\Http\Requests\UpdateTalksSubcategoriesRequest;
use App\Models\TalkCategories;
use App\Models\TalksSubcategories;
use App\Models\TalkSubcategories;
use App\ModelsApi\StaticProfession;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TalkSubcategoriesController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('talk_subcategories_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = TalkSubcategories::query()->with(['category:id,english','talks'])->leftJoin('talk_categories', 'talk_subcategories.talk_categories_id', '=',  'talk_categories.id')->select(['talk_subcategories.*', 'talk_categories.english as category'])->get();
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = '';
                $editGate      = '';
                $deleteGate    = 'talk_subcategories_delete';
                $crudRoutePart = 'talk-subcategories';

                return view('partials.datatablesActions', compact('viewGate', 'editGate', 'deleteGate', 'crudRoutePart', 'row'));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ?: "";
            });
            $table->editColumn('category', function ($row) {
                // if ($row->category) {
                    return $row->category ?: "";
                // }
            });
            $table->editColumn('talks', function ($row) {
                if ($row->talks->count()) {
                    return $row->talks->count();
                }
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

        $categories = TalkCategories::select('english')
            ->groupBy('english')
            ->get();

        return view('admin.talksSubcategories.index', compact('categories'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('talk_subcategories_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $talks = TalkCategories::query()
            ->select('id', StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', 'en')] . ' as headline')
            ->get()
            ->pluck('headline', 'id')
            ->toArray();

        return view('admin.talksSubcategories.create', compact('talks'));
    }

    public function store(StoreTalkSubcategoriesRequest $request)
    {
        $talkSubcategories = TalkSubcategories::create($request->all());

        return redirect()->route('admin.talk-subcategories.index');
    }

    public function edit(Request $request, $id)
    {
        abort_if(Gate::denies('talk_subcategories_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $talksSubcategories = TalkSubcategories::query()->find($id);
        $talks              = TalkCategories::query()
            ->select('id', StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', 'en')] . ' as headline')
            ->get()
            ->pluck('headline', 'id')
            ->toArray();

        return view('admin.talksSubcategories.edit', compact('talksSubcategories', 'talks'));
    }

    public function update(UpdateTalksSubcategoriesRequest $request, TalksSubcategories $talksSubcategories, $id)
    {
        TalkSubcategories::query()->find($id)->update($request->all());

        return redirect()->route('admin.talks-subcategories.index');
    }

    public function show(TalkSubcategories $talksSubcategories, $id)
    {
        abort_if(Gate::denies('talk_subcategories_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $talkSubcategories = TalkSubcategories::query()->find($id);

        return view('admin.talksSubcategories.show', compact('talkSubcategories'));
    }

    public function destroy(TalkSubcategories $talkSubcategories, $id)
    {
        abort_if(Gate::denies('talk_subcategories_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        TalkSubcategories::query()->find($id)->delete();

        return back();
    }

    public function massDestroy(MassDestroyTalkSubcategoriesRequest $request)
    {
        TalkSubcategories::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
