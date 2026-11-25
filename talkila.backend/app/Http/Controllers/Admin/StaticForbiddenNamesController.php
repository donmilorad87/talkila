<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyStaticForbiddenNameRequest;
use App\Http\Requests\StoreStaticForbiddenNameRequest;
use App\Http\Requests\UpdateStaticForbiddenNameRequest;
use App\Models\StaticForbiddenName;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class StaticForbiddenNamesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('static_forbidden_name_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = StaticForbiddenName::query()->select(sprintf('%s.*', (new StaticForbiddenName)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = '';
                $editGate      = '';
                $deleteGate    = 'static_forbidden_name_delete';
                $crudRoutePart = 'static-forbidden-names';

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

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });

            $table->editColumn('statistics', function ($row) {
                return $row->statistics ? $row->statistics : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.staticForbiddenNames.index');
    }

    public function create()
    {
        abort_if(Gate::denies('static_forbidden_name_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.staticForbiddenNames.create');
    }

    public function store(StoreStaticForbiddenNameRequest $request)
    {
        $staticForbiddenName = StaticForbiddenName::create($request->all());

        return redirect()->route('admin.static-forbidden-names.index');
    }

    public function edit(StaticForbiddenName $staticForbiddenName)
    {
        abort_if(Gate::denies('static_forbidden_name_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.staticForbiddenNames.edit', compact('staticForbiddenName'));
    }

    public function update(UpdateStaticForbiddenNameRequest $request, StaticForbiddenName $staticForbiddenName)
    {
        $staticForbiddenName->update($request->all());

        return redirect()->route('admin.static-forbidden-names.index');
    }

    public function show(StaticForbiddenName $staticForbiddenName)
    {
        abort_if(Gate::denies('static_forbidden_name_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.staticForbiddenNames.show', compact('staticForbiddenName'));
    }

    public function destroy(StaticForbiddenName $staticForbiddenName)
    {
        abort_if(Gate::denies('static_forbidden_name_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $staticForbiddenName->delete();

        return back();
    }

    public function massDestroy(MassDestroyStaticForbiddenNameRequest $request)
    {
        StaticForbiddenName::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
