<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyBillingAddressRequest;
use App\Http\Requests\StoreBillingAddressRequest;
use App\Http\Requests\UpdateBillingAddressRequest;
use App\Mail\BillingInformationChanged;
use App\Models\BillingAddress;
use App\Models\Country;
use App\ModelsApi\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BillingAddressController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('billing_address_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = BillingAddress::with(['countries'])->select(sprintf('%s.*', (new BillingAddress)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'billing_address_show';
                $editGate      = 'billing_address_edit';
                $deleteGate    = 'billing_address_delete';
                $crudRoutePart = 'billing-addresses';

                return view(
                    'partials.datatablesActions',
                    compact(
                        'viewGate',
                        'editGate',
                        'deleteGate',
                        'crudRoutePart',
                        'row'
                    )
                );
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });

            $table->editColumn('street', function ($row) {
                return $row->street ? $row->street : "";
            });
            $table->editColumn('zipcode', function ($row) {
                return $row->zipcode ? $row->zipcode : "";
            });
            $table->editColumn('city', function ($row) {
                return $row->city ? $row->city : "";
            });
            $table->editColumn('company_name', function ($row) {
                return $row->company_name ? $row->company_name : "";
            });
            $table->editColumn('tax_number', function ($row) {
                return $row->tax_number ? $row->tax_number : "";
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : "";
            });
            $table->editColumn('tel_number', function ($row) {
                return $row->tel_number ? $row->tel_number : "";
            });
            $table->addColumn('countries_name', function ($row) {
                return $row->countries ? $row->countries->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'countries']);

            return $table->make(true);
        }

        $countries = Country::get()->pluck('name')->toArray();

        return view('admin.billingAddresses.index', compact('countries'));
    }

    public function create()
    {
        abort_if(Gate::denies('billing_address_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countries = Country::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.billingAddresses.create', compact('countries'));
    }

    public function store(StoreBillingAddressRequest $request)
    {
        $billingAddress = BillingAddress::create($request->all());

        return redirect()->route('admin.billing-addresses.index');
    }

    public function edit(BillingAddress $billingAddress)
    {
        abort_if(Gate::denies('billing_address_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countries = Country::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $billingAddress->load('countries');

        return view('admin.billingAddresses.edit', compact('countries', 'billingAddress'));
    }

    public function update(UpdateBillingAddressRequest $request, BillingAddress $billingAddress)
    {
        $billingAddress->update($request->all());

        if ($billingAddress->created_at != $billingAddress->updated_at) {
            $billingAddress->update(['state' => BillingAddress::STATE['not_valid']]);

            $newBilling = BillingAddress::create($request->all());

            $addressUser            = User::query()->where('id', $billingAddress->user_id)->first();
            $originalBillingAddress = \App\ModelsApi\BillingAddress::query()->where('id', $billingAddress->id)->with('countries')->first();
            $newBillingAddress      = BillingAddress::query()->where('id', $newBilling->id)->with('countries')->first();

            Mail::to($addressUser->email)->queue(
                new BillingInformationChanged(
                    $request->header('Application-Language', 'en'),
                    $addressUser->email,
                    $originalBillingAddress->company_name,
                    $newBillingAddress->company_name, $originalBillingAddress->street,
                    $newBillingAddress->street, $originalBillingAddress->city,
                    $newBillingAddress->city, $originalBillingAddress->zipcode,
                    $newBillingAddress->zipcode, $originalBillingAddress->pays_vat,
                    $newBillingAddress->pays_vat, $originalBillingAddress->countries->name,
                    $newBillingAddress->countries->name,
                    // $newBillingAddress->created_at
                    convertToUserTimezone($newBillingAddress->updated_at)
                )
            );
        }

        return redirect()->route('admin.billing-addresses.index');
    }

    public function show(BillingAddress $billingAddress)
    {
        abort_if(Gate::denies('billing_address_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $billingAddress->load('countries', 'billingAddressTalks');

        return view('admin.billingAddresses.show', compact('billingAddress'));
    }

    public function userBillingAddresses(Request $request, $id)
    {
        if ($request->ajax()) {
            $query = BillingAddress::select(sprintf('%s.*', (new BillingAddress)->table))->where('user_id', $id);

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '');

            $table->editColumn('actions', function ($row) {
                $editGate      = 'billing_addresses_edit';
                $crudRoutePart = 'billing_addresses';

                return view(
                    'partials.datatablesActionsEdit',
                    compact(
                        'editGate',
                        'crudRoutePart',
                        'row'
                    )
                );
            });

            return $table->make(true);
        }
    }

    public function destroy(BillingAddress $billingAddress)
    {
        abort_if(Gate::denies('billing_address_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $billingAddress->delete();

        return back();
    }

    public function massDestroy(MassDestroyBillingAddressRequest $request)
    {
        BillingAddress::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
