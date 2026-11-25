<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyProfilCvRequest;
use App\Http\Requests\StoreProfilCvRequest;
use App\Http\Requests\UpdateProfilCvRequest;
use App\Models\ProfilCv;
use App\Models\StaticProfession;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ProfilCvController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('profil_cv_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ProfilCv::with(['user', 'profession'])->select(sprintf('%s.*', (new ProfilCv)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'profil_cv_show';
                $editGate      = 'profil_cv_edit';
                $deleteGate    = 'profil_cv_delete';
                $crudRoutePart = 'profile-cvs';

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

            $table->editColumn('type', function ($row) {
                return $row->type ? $row->type : "";
            });

            $table->editColumn('company_name', function ($row) {
                return $row->company_name ? $row->company_name : "";
            });
            $table->addColumn('profession_english', function ($row) {
                return $row->profession ? $row->profession->english : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'profession']);

            return $table->make(true);
        }

        $users              = User::get()->pluck('email')->toArray();
        $static_professions = StaticProfession::get()->pluck('english')->toArray();

        return view('admin.profilCvs.index', compact('users', 'static_professions'));
    }

    public function create()
    {
        abort_if(Gate::denies('profil_cv_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $professions = StaticProfession::all()->pluck('english', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.profilCvs.create', compact('users', 'professions'));
    }

    public function store(StoreProfilCvRequest $request)
    {
            $profilCv       = ProfilCv::create($request->all());

        return redirect()->route('admin.profile-cvs.index');
    }

    public function edit(ProfilCv $profilCv)
    {
        abort_if(Gate::denies('profil_cv_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $professions = StaticProfession::all()->pluck('english', 'id')->prepend(trans('global.pleaseSelect'), '');

        $profilCv->load('user', 'profession');

        return view('admin.profilCvs.edit', compact('users', 'professions', 'profilCv'));
    }

    public function update(UpdateProfilCvRequest $request, ProfilCv $profilCv)
    {
        $profilCv->update($request->all());

        return redirect()->route('admin.profile-cvs.index');
    }

    public function show(ProfilCv $profilCv)
    {
        abort_if(Gate::denies('profil_cv_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $profilCv->load('user', 'profession');

        return view('admin.profilCvs.show', compact('profilCv'));
    }

    public function userProfilCvs(Request $request, $id)
    {
        if ($request->ajax()) {

            $query = ProfilCv::where('user_id', $id)->get();

            $table = Datatables::of($query);

            $table->editColumn('actions', function ($row) {
                $viewGate      = '';
                $editGate      = '';
                $deleteGate    = 'profil_cv_delete';
                $crudRoutePart = 'profile-cvs';

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

    public function destroy(ProfilCv $profilCv)
    {
        abort_if(Gate::denies('profil_cv_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $profilCv->delete();

        return back();
    }

    public function massDestroy(MassDestroyProfilCvRequest $request)
    {
        ProfilCv::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
