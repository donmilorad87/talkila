<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Models\BookingsPayout;
use App\Models\Payout;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyBookingsPayoutRequest;
use App\Http\Requests\StoreBookingsPayoutRequest;
use App\Http\Requests\UpdateBookingsPayoutRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BookingsPayoutsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('bookings_payout_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = BookingsPayout::with(['payouts', 'calls'])->select(sprintf('%s.*', (new BookingsPayout)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'bookings_payout_show';
                $editGate      = 'bookings_payout_edit';
                $deleteGate    = 'bookings_payout_delete';
                $crudRoutePart = 'bookings-payout-invoices';

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
            $table->addColumn('payouts_invoice_number', function ($row) {
                return $row->payouts ? $row->payouts->invoice_number : '';
            });

            $table->editColumn('calls.price', function ($row) {
                return $row->calls ? (is_string($row->calls) ? $row->calls : $row->calls->price) : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'payouts', 'calls']);

            return $table->make(true);
        }

        $payouts = Payout::get()->pluck('invoice_number')->toArray();

        return view('admin.bookingsPayouts.index', compact('payouts'));
    }

    public function create()
    {
        abort_if(Gate::denies('bookings_payout_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payouts = Payout::all()->pluck('invoice_number', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.bookingsPayouts.create', compact('payouts'));
    }

    public function store(StoreBookingsPayoutRequest $request)
    {
        $bookingsPayout = BookingsPayout::create($request->all());

        return redirect()->route('admin.bookings-payout-invoices.index');
    }

    public function edit(BookingsPayout $bookingsPayout)
    {
        abort_if(Gate::denies('bookings_payout_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payouts = Payout::all()->pluck('invoice_number', 'id')->prepend(trans('global.pleaseSelect'), '');

        $bookingsPayout->load('payouts');

        return view('admin.bookingsPayouts.edit', compact('payouts', 'bookingsPayout'));
    }

    public function update(UpdateBookingsPayoutRequest $request, BookingsPayout $bookingsPayout)
    {
        $bookingsPayout->update($request->all());

        return redirect()->route('admin.bookings-payout-invoices.index');
    }

    public function show(BookingsPayout $bookingsPayout)
    {
        abort_if(Gate::denies('bookings_payout_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookingsPayout->load('payouts', 'calls');

        return view('admin.bookingsPayouts.show', compact('bookingsPayout'));
    }

    public function destroy(BookingsPayout $bookingsPayout)
    {
        abort_if(Gate::denies('bookings_payout_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookingsPayout->delete();

        return back();
    }

    public function massDestroy(MassDestroyBookingsPayoutRequest $request)
    {
        BookingsPayout::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
