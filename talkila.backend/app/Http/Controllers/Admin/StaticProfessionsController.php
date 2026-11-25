<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyStaticProfessionRequest;
use App\Http\Requests\StoreStaticProfessionRequest;
use App\Http\Requests\UpdateStaticProfessionRequest;
use App\Models\StaticProfession;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class StaticProfessionsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('static_profession_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = StaticProfession::query()->select(sprintf('%s.*', (new StaticProfession)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = '';
                $editGate      = '';
                $deleteGate    = 'static_profession_delete';
                $crudRoutePart = 'static-professions';

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
            $table->editColumn('croatian', function ($row) {
                return $row->croatian ? $row->croatian : "";
            });
            $table->editColumn('german', function ($row) {
                return $row->german ? $row->german : "";
            });
            $table->editColumn('english', function ($row) {
                return $row->english ? $row->english : "";
            });
            $table->editColumn('spanish', function ($row) {
                return $row->spanish ? $row->spanish : "";
            });
            $table->editColumn('french', function ($row) {
                return $row->french ? $row->french : "";
            });
            $table->editColumn('italien', function ($row) {
                return $row->italien ? $row->italien : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.staticProfessions.index');
    }

    public function create()
    {
        abort_if(Gate::denies('static_profession_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.staticProfessions.create');
    }

    public function store(StoreStaticProfessionRequest $request)
    {
        $staticProfession = StaticProfession::create($request->all());

        return redirect()->route('admin.static-professions.index');
    }

    public function edit(StaticProfession $staticProfession)
    {
        abort_if(Gate::denies('static_profession_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.staticProfessions.edit', compact('staticProfession'));
    }

    public function update(UpdateStaticProfessionRequest $request, StaticProfession $staticProfession)
    {
        $staticProfession->update($request->all());

        return redirect()->route('admin.static-professions.index');
    }

    public function show(StaticProfession $staticProfession)
    {
        abort_if(Gate::denies('static_profession_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $staticProfession->load('professionProfilCvs');

        return view('admin.staticProfessions.show', compact('staticProfession'));
    }

    public function destroy(StaticProfession $staticProfession)
    {
        abort_if(Gate::denies('static_profession_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $staticProfession->delete();

        return back();
    }

    public function massDestroy(MassDestroyStaticProfessionRequest $request)
    {
        StaticProfession::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
