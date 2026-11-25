<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyProfilPayoutMethodRequest;
use App\Http\Requests\StoreProfilPayoutMethodRequest;
use App\Http\Requests\UpdateProfilPayoutMethodRequest;
use App\Models\ProfilPayoutMethod;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PayoutsMethodsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('profil_payout_method_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ProfilPayoutMethod::with(['user'])->select(sprintf('%s.*', (new ProfilPayoutMethod)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'profil_payout_method_show';
                $editGate      = 'profil_payout_method_edit';
                $deleteGate    = 'profil_payout_method_delete';
                $crudRoutePart = 'profile-payout-methods';

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
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->editColumn('method', function ($row) {
                return $row->method ? $row->method : "";
            });
            $table->editColumn('value', function ($row) {
                return $row->value ? $row->value : "";
            });
            $table->editColumn('state', function ($row) {
                return $row->state ? $row->state : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'user']);

            return $table->make(true);
        }

//        $users = User::get()->pluck('name')->toArray();

        $adyenPayment = new AdyenPaymentController();
        $paymentMethods = json_encode($adyenPayment->adyenPaymentMethods());
//        dd($paymentMethods);

        return view('admin.payoutsMethods.index', compact( 'paymentMethods'));
    }

    public function create()
    {
        abort_if(Gate::denies('profil_payout_method_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.payoutsMethods.create', compact('users'));
    }

    public function store(StoreProfilPayoutMethodRequest $request)
    {
        $profilPayoutMethod = ProfilPayoutMethod::create($request->all());

        return redirect()->route('admin.profile-payout-methods.index');
    }

    public function edit(ProfilPayoutMethod $profilPayoutMethod)
    {
        abort_if(Gate::denies('profil_payout_method_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $profilPayoutMethod->load('user');

        return view('admin.payoutsMethods.edit', compact('users', 'profilPayoutMethod'));
    }

    public function update(UpdateProfilPayoutMethodRequest $request, ProfilPayoutMethod $profilPayoutMethod)
    {
        $profilPayoutMethod->update($request->all());

        return redirect()->route('admin.profile-payout-methods.index');
    }

    public function show(ProfilPayoutMethod $profilPayoutMethod)
    {
        abort_if(Gate::denies('profil_payout_method_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $profilPayoutMethod->load('user');

        return view('admin.payoutsMethods.show', compact('profilPayoutMethod'));
    }

    public function userPayoutMethod(Request $request, $id)
    {
        if ($request->ajax()) {
            $query = ProfilPayoutMethod::with(['user'])->where('user_id', $id)->get();

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '');

            return $table->make(true);
        }
    }

    public function destroy(ProfilPayoutMethod $profilPayoutMethod)
    {
        abort_if(Gate::denies('profil_payout_method_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $profilPayoutMethod->delete();

        return back();
    }

    public function massDestroy(MassDestroyProfilPayoutMethodRequest $request)
    {
        ProfilPayoutMethod::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
