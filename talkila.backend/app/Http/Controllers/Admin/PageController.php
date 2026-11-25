<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pages;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPagesRequest;
use App\Http\Requests\StorePagesRequest;
use App\Http\Requests\UpdatePagesRequest;
use App\Models\StaticProfession;
use App\ModelsApi\Language;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Yajra\DataTables\Facades\DataTables;

class PageController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('page_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Pages::query()->select(sprintf('%s.*', (new Pages)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'page_show';
                $editGate      = 'page_edit';
                $deleteGate    = 'page_delete';
                $crudRoutePart = 'cms';

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
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : "";
            });
            $table->editColumn('slug', function ($row) {
                return $row->slug ? $row->slug : "";
            });
            $table->editColumn('body', function ($row) {
                return $row->body ? $row->body : "";
            });
            $table->editColumn('meta_data', function ($row) {
                return $row->meta_data ? $row->meta_data : "";
            });
            $table->editColumn('language', function ($row) {
                return $row->language ? StaticProfession::DATABASE_LANGUAGE[$row->language] : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.pages.index');
    }

    public function create()
    {
        abort_if(Gate::denies('page_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pages.create');
    }

    public function store(StorePagesRequest $request)
    {
        $pages = Pages::create($request->all());

        return redirect()->route('admin.cms.index');
    }

    public function edit(Pages $pages, $id)
    {
        abort_if(Gate::denies('page_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pages = Pages::find($id);

        return view('admin.pages.edit', compact( 'pages'));
    }

    public function update(UpdatePagesRequest $request, Pages $pages, $id)
    {
        $pages = Pages::find($id);

        $pages->update($request->all());

        return redirect()->route('admin.cms.index');
    }

    public function show(Pages $pages, $id)
    {
        abort_if(Gate::denies('page_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pages = Pages::find($id);

        return view('admin.pages.show', compact('pages'));
    }

    public function destroy(Pages $pages, $id)
    {
        abort_if(Gate::denies('page_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pages = Pages::find($id);

        $pages->delete();

        return back();
    }

    public function massDestroy(MassDestroyPagesRequest $request)
    {
        Pages::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function dynamic_page(Request $request, $slug)
    {
        try {
            $content['page'] = Pages::query()->select('id', 'title', 'slug', 'body', 'meta_data')
                ->where('slug', $slug)
                ->where('language', $request->input('lang'))
                ->first();

            $content['links'] = Pages::query()->select('title', 'slug')
                ->where('language', $request->input('lang'))
                ->get()->toArray();

            return response()->json([
                'content'   => $content,
                'success'    => true
            ], 200);
        } catch (\Exception $e) {
            Log::error(var_export($e, true));

            return response()->json([
                'message'   => 'Page not found',
                'success'   => false
            ], 400);
        }
    }
}
