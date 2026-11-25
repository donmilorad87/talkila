<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\V1\Admin\BookingsApiController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyBookingRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Availability;
use App\Models\Booking;
use App\Models\BookingsProtocol;
use App\Models\CallsCancellationReason;
use App\Models\FinanceCurrency;
use App\Models\Talk;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletHistory;
use Exception;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BookingsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Booking::query()
                ->with(['teacher_user', 'participant_user', 'finance_currencies', 'payment'])
                ->leftJoin('users as supplier', 'supplier.id', '=', 'bookings.teacher_user_id')
                ->leftJoin('users as client', 'client.id', '=', 'bookings.participant_user_id')
                ->leftJoin('wallet_ledgers as payment', 'payment.booking_id', '=', 'bookings.id')
                ->leftJoin('wallet_ledgers', function ($query) {
                    $query->on('wallet_ledgers.booking_id', '=', 'bookings.id')
                        ->where('wallet_ledgers.source', '!=', '0');
                })
                ->select(['bookings.id', 'bookings.start_call', 'bookings.duration', 'bookings.price', 'bookings.state', 'wallet_ledgers.transaction_id', 'supplier.name as supplier', 'supplier.id as supplier_id', 'client.name as client', 'client.id as client_id'])
                ->distinct()
                ->get();

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'booking_show';
                $editGate      = 'booking_edit';
                $deleteGate    = 'booking_delete';
                $hardDelete    = false;
                $crudRoutePart = 'bookings';

                return view('partials.datatablesActions', compact('viewGate', 'editGate', 'hardDelete', 'deleteGate', 'crudRoutePart', 'row'));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ?: "";
            });

            $table->editColumn('supplier', function ($row) {
                return $row->supplier ?: "";
            });

            $table->editColumn('client', function ($row) {
                return $row->client ?: "";
            });

            $table->editColumn('date', function ($row) {
                return $row->date ?: "";
            });

            $table->editColumn('duration', function ($row) {
                return $row->duration ?: "";
            });

            $table->editColumn('price', function ($row) {
                return $row->price ?: "";
            });

            $table->editColumn('payment', function ($row) {
                return $row->transaction_id ? (\Str::startsWith($row->transaction_id, ['ch', 'pi']) ? 'Credit Card' : 'PayPal') : 'Coins';
            });

            $table->editColumn('state', function ($row) {
                return $row->state ?: "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.bookings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('booking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $participant_users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $talks             = Talk::all()->pluck('headline', 'id')->prepend(trans('global.pleaseSelect'), '');

        $finance_currencies = FinanceCurrency::all()->pluck('symbol', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cancellation_reasons = CallsCancellationReason::all()->pluck('english', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.bookings.create', compact('participant_users', 'talks', 'finance_currencies', 'cancellation_reasons'));
    }

    public function store(StoreBookingRequest $request)
    {
        $bookingData                       = $request->all();
        $bookingData['billing_address_id'] = $request->user()->billing_user_id;

        $teacher = User::find($request->input('teacher_user_id'));
        $bookingData['supplier_billing_address_id'] = $teacher->billing_address_id ?? 0;
        $bookingData['client_billing_address_id']   = $request->user()->billing_address_id ?? 0;

        $booking = Booking::create($bookingData);

        BookingsController::createBookingProtocolEvent($booking->id, Booking::STATE['waiting']);

        return redirect()->route('admin.bookings.index');
    }

    public function storeBooking(Request $request)
    {
        try {
            DB::beginTransaction();
            $bookingApiController     = new BookingsApiController();
            $callBookingApiController = $bookingApiController->store($request, true)->getData(true);
            DB::commit();
            if ($callBookingApiController['success']) {
                Session::flash('alert-success', $callBookingApiController['message']);

                return redirect()->route('admin.socket-rooms.index');
            } else {
                Session::flash('alert-danger', $callBookingApiController['message']);

                return redirect()->back();
            }
        } catch (Exception $exception) {
            DB::rollBack();
            Session::flash('alert-danger', $exception->getMessage());
        }

        return redirect()->route('index');
    }

    public function edit(Booking $booking)
    {
        abort_if(Gate::denies('booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $participant_users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $talks             = Talk::all()->pluck('headline', 'id')->prepend(trans('global.pleaseSelect'), '');

        $finance_currencies = FinanceCurrency::all()->pluck('symbol', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cancellation_reasons = CallsCancellationReason::all()->pluck('english', 'id')->prepend(trans('global.pleaseSelect'), '');

        $booking->load('participant_user', 'finance_currencies', 'cancellation_reason');

        return view('admin.bookings.edit', compact('participant_users', 'talks', 'finance_currencies', 'cancellation_reasons', 'booking'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $booking->update($request->all());

        return redirect()->route('admin.bookings.index');
    }

    public function show(Request $request, Booking $booking)
    {
        abort_if(Gate::denies('booking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        $booking->load('participant_user', 'teacher_user_with_trashed', 'finance_currencies', 'cancellation_reason', 'talksBookingsPayouts', 'talk', 'talksFeedback');

        $extensions = $booking->where('booking_type', 1)->count();

        return view('admin.bookings.show', compact('booking', 'extensions'));
    }

    public function userBookings(Request $request, $id)
    {
        if ($request->ajax()) {
            $query = Booking::with(['participant_user', 'talk', 'finance_currencies', 'cancellation_reason', 'talksBookingsPayouts', 'talksFeedback', 'teacher_user_with_trashed'])->select(sprintf('%s.*', (new Booking)->table))->where('participant_user_id', $id);

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '');

            return $table->make(true);
        }
    }

    public function destroy(Booking $booking)
    {
        abort_if(Gate::denies('booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking->delete();

        return back();
    }

    public function massDestroy(MassDestroyBookingRequest $request)
    {
        Booking::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getAvailableExtensions($nBookingId)
    {
        $return = [
            'extension_of_15' => $this->makeCallExtension($nBookingId, 15),
            'extension_of_30' => $this->makeCallExtension($nBookingId, 30),
            'extension_of_45' => $this->makeCallExtension($nBookingId, 45),
            'extension_of_60' => $this->makeCallExtension($nBookingId, 60),
        ];

        return response()->json($return, 200);
    }

    public function makeCallExtension($nBookingId, $nRequestedExtension)
    {
        // Add 15 minutes on requested time to make pause between next call
        $nRequestedExtension = $nRequestedExtension + 15;

        $oBooking = Booking::query()->where('id', $nBookingId)->first();

        $sRequestedExtensionTime     = date('H:i', strtotime($oBooking->end_call . '+' . $nRequestedExtension . ' minutes'));
        $sRequestedExtensionTimeFull = date('Y-m-d H:i:0', strtotime($oBooking->end_call . '+' . $nRequestedExtension . ' minutes'));
        $aTeacherTalks               = Talk::query()->where('teacher_user_id', $oBooking->teacher_user_id)->pluck('id')->toArray();

        $iNextBooking = Booking::query()->whereIn('talk_id', $aTeacherTalks)
            ->whereDate('start_call', date('Y-m-d', strtotime($oBooking->end_call)))
            ->where('end_call', '>', $sRequestedExtensionTimeFull)
            ->where('start_call', '<', $sRequestedExtensionTimeFull)
            ->exists();

        $iStudentBooking = Booking::query()->where('id', '!=', $oBooking->id)
            ->whereDate('start_call', '>', $sRequestedExtensionTimeFull)
            ->where('participant_user_id', $oBooking->participant_user_id)
            ->exists();

        $iAvailability = Availability::query()->whereRaw("end_time > '$sRequestedExtensionTime' AND start_time < '$sRequestedExtensionTime'")
            ->where('user_id', $oBooking->teacher_user_id)
            ->where('weekday', date('N', strtotime($sRequestedExtensionTimeFull)))
            ->exists();

        if ($iNextBooking && $iStudentBooking && ! $iAvailability) {
            return true;
        } else {
            return false;
        }
    }

    public static function createBookingProtocolEvent($bookingId, $state)
    {
        $bookingProtocol             = new BookingsProtocol();
        $bookingProtocol->booking_id = $bookingId;
        $bookingProtocol->state      = $state;
        $bookingProtocol->save();
    }


    public static function wallet(Request $request)
    {
        $wallet = Wallet::query()->get()->toArray();

        return view('frontend.pages.display-wallet', [
            'wallet' => $wallet,
        ]);
    }

    public static function walletLedgers(Request $request)
    {
        $wallets = WalletHistory::query()->get()->toArray();

        return view('frontend.pages.display-wallet-ledgers', [
            'wallets' => $wallets,
        ]);
    }
}
