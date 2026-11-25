<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPayoutRequest;
use App\Http\Requests\PayoutPaymentRequest;
use App\Http\Requests\StorePayoutRequest;
use App\Http\Requests\UpdatePayoutRequest;
use App\Models\Booking;
use App\Models\FinanceCurrency;
use App\Models\Payout;
use App\Models\User;
use Exception;
use Gate;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;

class PayoutsController extends Controller
{
    use CsvImportTrait;

    /**
     * @var User A User model.
     */
    public User $user;

    /**
     * @var Booking A Booking model.
     */
    public Booking $booking;

    /**
     * @var Payout A Payout model.
     */
    public Payout $payout;

    /**
     * Create a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user    = new User();
        $this->booking = new Booking();
        $this->payout  = new Payout();
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     *
     * @return View
     */
    public function index(Request $request): View
    {
        return view('admin.payout.index', [
            'revenue'     => $this->getNumberFormat($this->payout->getRevenue()),
            'commission'  => $this->getNumberFormat($this->payout->getCommission()),
            'payout'      => $this->getNumberFormat($this->payout->getPayout()),
            'transaction' => $this->payout->getTransactionsCount(),
        ]);
    }

    public function create()
    {
        abort_if(Gate::denies('payout_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $finance_currencies = FinanceCurrency::all()->pluck('symbol', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.payouts.create', compact('finance_currencies'));
    }

    public function store(StorePayoutRequest $request)
    {
        $payout = Payout::create($request->all());

        return redirect()->route('admin.payout-invoices.index');
    }

    public function edit(Payout $payout, $id)
    {
        abort_if(Gate::denies('payout_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $finance_currencies = FinanceCurrency::all()->pluck('symbol', 'id')->prepend(trans('global.pleaseSelect'), '');

        $payout = Payout::query()->find($id);

        $payout->load('finance_currencies');

        return view('admin.payouts.edit', compact('finance_currencies', 'payout'));
    }

    public function update(UpdatePayoutRequest $request, Payout $payout)
    {
        $payout->update($request->all());

        return redirect()->route('admin.payout-invoices.index');
    }

    public function details()
    {
        return view('admin.payout.details', [
            'revenue'     => $this->getNumberFormat($this->payout->getRevenue()),
            'commission'  => $this->getNumberFormat($this->payout->getCommission()),
            'payout'      => $this->getNumberFormat($this->payout->getPayout()),
            'transaction' => $this->payout->getTransactionsCount(),
        ]);
    }

    public function show(Payout $payout): View
    {
        return view('admin.payout.show', [
            'user'            => auth()->user(),
            'payout'          => $payout,
            'bookings'        => $payout->getBookingsForAdminPage(),
            'user_payouts'    => $payout->getPayoutData(),
            'user_revenue'    => $this->getNumberFormat($payout->getPayoutRevenue()),
            'user_commission' => $this->getNumberFormat($payout->getPayoutCommission()),
            'user_payout'     => $this->getNumberFormat($payout->getBookingsPayout()),
            'transaction'     => $payout->getBookingsCount(),
        ]);
    }

    public function destroy(Payout $payout)
    {
        abort_if(Gate::denies('payout_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payout->delete();

        return back();
    }

    public function massDestroy(MassDestroyPayoutRequest $request)
    {
        Payout::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function pay(PayoutPaymentRequest $request, Payout $payout)
    {
        try {
            DB::transaction(function () use ($payout, $request) {
                // TODO: Transfer funds to the Supplier.
                // TODO: Generate Invoice.
                // TODO: Send an email.
                // Update the Database.

                $payout->update([
                    'paid_with' => $request->input('paid_with'),
                ]);
            });
        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'Payout failed.');
        }

        return redirect()->back()->with('success', 'Payout completed.');
    }

    /**
     * Returns formatted number in EU format.
     *
     * @param $number
     *
     * @return string
     */
    protected function getNumberFormat($number): string
    {
        return number_format($number, 2, ',', '.');
    }

    /**
     * Returns JSON of all Payouts grouped by Month.
     *
     * @param  Request  $request
     *
     * @return void
     * @throws Exception
     */
    public function fetchPayoutsByMonth(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->payout->getPayoutsByMonth();

            $table = Datatables::of($query);

            $table->editColumn('id', function ($row) {
                return $row->id;
            });

            $table->editColumn('invoice_number', function ($row) {
                return $row->invoice_number;
            });

            $table->editColumn('reference', function ($row) {
                return $row->reference;
            });

            $table->editColumn('revenue', function ($row) {
                return $row->revenue ?: 0;
            });

            $table->editColumn('commission', function ($row) {
                return $row->commission ?: 0;
            });

            $table->editColumn('bookings', function ($row) {
                return $row->bookings ?: 'No bookings';
            });

            $table->editColumn('paid_bookings', function ($row) {
                return $row->paid_bookings ?: 'No bookings';
            });

            $table->editColumn('cancelled_bookings', function ($row) {
                return $row->cancelled_bookings ?: 'No bookings';
            });

            $table->editColumn('actions', function ($row) {
                return view('partials.datatablesPayoutActions', [
                    'row' => $row,
                ]);
            });

            return $table->addIndexColumn()->make(true);
        }
    }

    /**
     * Returns JSON of all Suppliers
     *
     * @param  Request  $request
     *
     * @return void
     * @throws Exception
     */
    public function fetchSuppliers(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->payout->getSuppliers();

            $table = Datatables::of($query);

            $table->editColumn('id', function ($row) {
                return $row->id;
            });

            $table->editColumn('username', function ($row) {
                return $row->username;
            });

            $table->editColumn('revenue', function ($row) {
                return $row->revenue ?: 0;
            });

            $table->editColumn('commission', function ($row) {
                return $row->commission ?: 0;
            });

            $table->editColumn('payout_date', function ($row) {
                return Carbon::parse($row->payout_date)->format('d.m.Y');
            });

            $table->editColumn('payout_method', function ($row) {
                return $row->payout_method;
            });

            $table->editColumn('actions', function ($row) {
                return view('partials.datatablesPayoutDetailsActions', [
                    'row' => $row,
                ]);
            });

            return $table->addIndexColumn()->make(true);
        }
    }

    /**
     * Returns JSON of all Suppliers
     *
     * @param  Request  $request
     *
     * @return void
     * @throws Exception
     */
    public function fetchSuppliersByMonth(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->payout->getSuppliersByMonth($request->input('month'));

            $table = Datatables::of($query);

            $table->editColumn('id', function ($row) {
                return $row->id;
            });

            $table->editColumn('username', function ($row) {
                return $row->username;
            });

            $table->editColumn('revenue', function ($row) {
                return $row->revenue ?: 0;
            });

            $table->editColumn('commission', function ($row) {
                return $row->commission ?: 0;
            });

            $table->editColumn('payout_date', function ($row) {
                return Carbon::parse($row->payout_date)->format('d.m.Y');
            });

            $table->editColumn('payout_method', function ($row) {
                return $row->payout_method;
            });

            $table->editColumn('actions', function ($row) {
                return view('partials.datatablesPayoutDetailsActions', [
                    'row' => $row,
                ]);
            });

            return $table->addIndexColumn()->make(true);
        }
    }

    /**
     * Returns JSON of Supplier Payouts by Country.
     *
     * @param  Payout   $payout
     * @param  Request  $request
     *
     * @return void
     * @throws Exception
     */
    public function fetchSupplierPayoutsByCountry(Payout $payout, Request $request)
    {
        if ($request->ajax()) {
            $query = $payout->getPayoutData();

            $table = Datatables::of($query);

            $table->editColumn('country_of_residence', function ($row) {
                return $row['country_of_residence'];
            });

            $table->editColumn('vat_value', function ($row) {
                return $row['vat_value'] . '%';
            });

            $table->editColumn('bookings_count', function ($row) {
                return $row['bookings_count'];
            });

            $table->editColumn('revenue', function ($row) {
                return $row['revenue'];
            });

            $table->editColumn('payout', function ($row) {
                return $row['payout'];
            });

            $table->editColumn('tax', function ($row) {
                return $row['tax'];
            });

            $table->editColumn('net', function ($row) {
                return $row['net'];
            });

            // $table->editColumn('actions', function ($row) {
            //     return view('partials.datatablesPayoutActions', [
            //         'row' => $row,
            //     ]);
            // });

            return $table->addIndexColumn()->make(true);
        }
    }

    /**
     * Returns JSON of all Supplier Bookings.
     *
     * @param  Payout   $payout
     * @param  Request  $request
     *
     * @return void
     * @throws Exception
     */
    public function fetchSupplierBookings(Payout $payout, Request $request)
    {
        if ($request->ajax()) {
            $query = $payout->getBookingsForAdminPage();

            $table = Datatables::of($query);

            $table->editColumn('date', function ($row) {
                return $row->date;
            });

            $table->editColumn('talk', function ($row) {
                return $row->talk . ($row->parent_id ? " - Extend ({$row->parent_id})" : '');
            });

            $table->editColumn('revenue', function ($row) {
                return $row->revenue;
            });

            $table->editColumn('payout', function ($row) {
                return $row->payout;
            });

            $table->editColumn('country_of_residence', function ($row) {
                return $row->country_of_residence;
            });

            $table->editColumn('state', function ($row) {
                return Str::of($row->booking_state)->title()->replace('_', ' ');
            });

            // $table->editColumn('actions', function ($row) {
            //     return view('partials.datatablesPayoutActions', [
            //         'row' => $row,
            //     ]);
            // });

            return $table->addIndexColumn()->make(true);
        }
    }
}
