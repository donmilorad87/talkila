<?php

namespace App\Http\Controllers\Admin;

use App\Entity\CallTypes;
use App\Entity\StateTypes;
use App\Entity\TalkTypes;
use App\Entity\UserTypes;
use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyBookingsPayoutRequest;
use App\Http\Requests\UpdateBookingsPayoutRequest;
use App\Mail\BookingConfirmationClient;
use App\Mail\BookingConfirmationSupplier;
use App\Models\Booking;
use App\Models\BookingsPaymentDetails;
use App\Models\BookingsPayout;
use App\Models\Payout;
use App\Models\SocketParticipant;
use App\Models\SocketRoom;
use App\ModelsApi\StaticMetric;
use App\ModelsApi\Talk;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BookingsPaymentDetailsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        //dd('tu');
//        abort_if(Gate::denies('bookings_payout_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = BookingsPaymentDetails::with(['payouts', 'calls'])->select(sprintf('%s.*', (new BookingsPaymentDetails)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'bookings_payout_show';
                $editGate      = 'bookings_payout_edit';
                $deleteGate    = 'bookings_payout_delete';
                $crudRoutePart = 'bookings-payout-invoices';

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
            $table->addColumn('payouts_invoice_number', function ($row) {
                return $row->payouts ? $row->payouts->invoice_number : '';
            });

            $table->editColumn('calls.price', function ($row) {
                return $row->calls ? (is_string($row->calls) ? $row->calls : $row->calls->price) : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'payouts', 'calls']);

            return $table->make(true);
        }

        return view('admin.bookingsPayouts.index');
    }

    public function create()
    {
        abort_if(Gate::denies('bookings_payout_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payouts = Payout::all()->pluck('invoice_number', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.bookingsPayouts.create', compact('payouts'));
    }

    public function paymentStore($requestBookingPayment)
    {
        BookingsPaymentDetails::create($requestBookingPayment);
        $bookingState = null;
        $exception    = false;

        if ($requestBookingPayment['event_code'] == 'AUTHORISATION' && $requestBookingPayment['status'] == 1) {
            // MARK BOOKING AS PAID
            $bookingState = Booking::STATE['paid'];

            // Increment booked hours in static metrics
            $booking = Booking::query()->find($requestBookingPayment['booking_id']);
            $talk    = Talk::query()->find($booking->talk_id)->toArray();
            StaticMetric::query()->where('user_id', $booking->teacher_user_id)->increment('received_booked_hours', $booking->duration);
            StaticMetric::query()->where('user_id', $booking->participant_user_id)->increment('my_booked_hours', $booking->duration);

            $teacherData = \App\Models\User::query()->find($booking->teacher_user_id);
            $clientData  = \App\Models\User::query()->find($booking->participant_user_id);

            // Create socket room if not exist
            $socketRoom = SocketRoom::query()->where('talk_id', $talk['id'])
                ->where('state', Booking::STATE['paid'])
                ->first();

            if (empty($socketRoom)) {
                if ($talk['call_type'] == CallTypes::ONE_TO_ONE) {
                    $room_name = 'tkp_room_' . $talk['id'] . '_' . $booking->id . '_' . date('Y-m-d');
                } else {
                    $room_name = 'tkg_room_' . $talk['id'] . '_' . $booking->id . '_' . date('Y-m-d');
                }

                $socketRoomRequest = $requestBookingPayment;

                $socketRoomRequest['talk_id']   = $talk['id'];
                $socketRoomRequest['room_name'] = $room_name;
                $socketRoomRequest['duration']  = $talk['duration'];
                /* Call Type Change */
                $socketRoomRequest['call_type']       = $talk['talk_type'];
                $socketRoomRequest['talk_start_time'] = $booking->start_call;
                $socketRoomRequest['talk_end_time']   = $booking->end_call;
                $socketRoomRequest['state']           = StateTypes::YES;
                $socketRoomRequest['booking_id']      = $booking->id;

                $socketRoom = SocketRoom::create($socketRoomRequest);

                //Populate Socket Room with Teacher
                $socketParticipantRequest                        = $requestBookingPayment;
                $socketParticipantRequest['socket_room_id']      = $socketRoom->id;
                $socketParticipantRequest['booking_id']          = $booking->id;
                $socketParticipantRequest['user_id']             = $teacherData->id;
                $socketParticipantRequest['name_of_user']        = $teacherData->name;
                $socketParticipantRequest['user_image']          = $teacherData->profile_picture;
                $socketParticipantRequest['firebase_id']         = $teacherData->firebase_id;
                $socketParticipantRequest['twilio_access_token'] = $teacherData->profile_picture;
                $socketParticipantRequest['is_active']           = StateTypes::YES;
                $socketParticipantRequest['is_anonym']           = $talk['anonym_call'];
                $socketParticipantRequest['user_type']           = UserTypes::PROVIDER;

                SocketParticipant::create($socketParticipantRequest);
            }

            //Populate Socket Room with participant
            $socketParticipantTwoRequest                        = $requestBookingPayment;
            $socketParticipantTwoRequest['socket_room_id']      = $socketRoom->id;
            $socketParticipantTwoRequest['booking_id']          = $booking->id;
            $socketParticipantTwoRequest['user_id']             = $clientData->id;
            $socketParticipantTwoRequest['name_of_user']        = $talk['anonym_call'] ? $clientData->name : 'Anonym';
            $socketParticipantTwoRequest['user_image']          = $talk['anonym_call'] ? $clientData->profile_picture : '';
            $socketParticipantTwoRequest['firebase_id']         = $clientData->firebase_id;
            $socketParticipantTwoRequest['twilio_access_token'] = $clientData->profile_picture;
            $socketParticipantTwoRequest['is_active']           = StateTypes::YES;
            $socketParticipantTwoRequest['is_anonym']           = $talk['anonym_call'];
            $socketParticipantTwoRequest['user_type']           = UserTypes::CLIENT;

            SocketParticipant::create($socketParticipantTwoRequest);

            Mail::to($teacherData->email)->queue(
                new BookingConfirmationSupplier(
                    $teacherData->last_language,
                    $teacherData->email,
                    $teacherData->username,
                    $talk['id'],
                    $talk['headline'],
                    convertToUserTimezone($booking->start_call, 'd.m.Y'),
                    convertToUserTimezone($booking->start_time, 'H:i'),
                    convertToUserTimezone($booking->end_time, 'H:i'),
                    $talk['duration'],
                    $talk['price'],
                    $talk['talk_type'] == TalkTypes::VOICE_CALL ? 'Phone-Talk' : 'Video-Talk',
                    $booking->id,
                    $teacherData->billing,
                    $booking->vat
                )
            );

            Mail::to($clientData->email)->queue(
                new BookingConfirmationClient(
                    $clientData->last_language,
                    $clientData->email,
                    $teacherData->username,
                    $talk['id'],
                    $talk['headline'],
                    convertToUserTimezone($booking->start_call,'d.m.Y'),
                    convertToUserTimezone($booking->start_time,'H:i'),
                    convertToUserTimezone($booking->end_time,'H:i'),
                    $talk['duration'],
                    $talk['price'],
                    $talk['talk_type'] == TalkTypes::VOICE_CALL ? 'Phone-Talk' : 'Video-Talk',
                    $booking->id,
                    $teacherData->billing,
                    $booking->vat
                )
            );

            StaticMetric::query()->where('user_id', $booking->teacher_user_id)->increment('received_emails');
            StaticMetric::query()->where('user_id', $booking->participant_user_id)->increment('received_emails');
        } elseif ($requestBookingPayment['event_code'] == 'AUTHORISATION' && $requestBookingPayment['status'] == 0) {
            // MARK BOOKING AS REJECTED
            $bookingState = Booking::STATE['rejected'];

            Log::notice('::adyenCapturePayment (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_5006, self::class, __FUNCTION__, [$requestBookingPayment['booking_id']]);
        } elseif ($requestBookingPayment['event_code'] == 'CAPTURE' && $requestBookingPayment['event_code'] == 1) {
            // MARK BOOKING AS CAPTURED
            $bookingState = Booking::STATE['captured'];
        } elseif ($requestBookingPayment['event_code'] == 'CAPTURE' && $requestBookingPayment['event_code'] == 0) {
            // MARK BOOKING AS FAILED TO CAPTURE AND SEND MAIL TO JURE
            $bookingState = Booking::STATE['rejected_capture'];

            Log::notice('::adyenCapturePayment (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_5007, self::class, __FUNCTION__, [$requestBookingPayment['booking_id']]);
        } elseif ($requestBookingPayment['event_code'] == 'CANCELLATION' && $requestBookingPayment['event_code'] == 1) {
            // MARK BOOKING AS CANCELED
            $bookingState = Booking::STATE['canceled'];
        } elseif ($requestBookingPayment['event_code'] == 'CANCELLATION' && $requestBookingPayment['event_code'] == 0) {
            // MARK BOOKING AS FAILED TO CANCEL AND SEND MAIL TO JURE
            $bookingState = Booking::STATE['rejected_cancellation'];

            Log::notice('::adyenCapturePayment (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_5008, self::class, __FUNCTION__, [$requestBookingPayment['booking_id']]);
        } elseif ($requestBookingPayment['event_code'] == 'CANCEL_OR_REFUND' && $requestBookingPayment['event_code'] == 1) {
            // MARK BOOKING AS CANCEL_OR_REFUND
            if ($requestBookingPayment['additionalData']['modification.action'] == 'refund') {
                $bookingState = Booking::STATE['refunded'];
            } else {
                $bookingState = Booking::STATE['canceled'];
            }
        } elseif ($requestBookingPayment['event_code'] == 'CANCEL_OR_REFUND' && $requestBookingPayment['event_code'] == 0) {
            // MARK BOOKING AS FAILED TO CANCEL_OR_REFUND AND SEND MAIL TO JURE
            $bookingState = Booking::STATE['rejected_cancellation_or_refund'];

            Log::notice('::adyenCapturePayment (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_5009, self::class, __FUNCTION__, [$requestBookingPayment['booking_id']]);
        } elseif (($requestBookingPayment['event_code'] == 'REFUND' || $requestBookingPayment['event_code'] == 'REFUND_WITH_DATA') && $requestBookingPayment['event_code'] == 1) {
            // MARK BOOKING AS REFUNDED
            $bookingState = Booking::STATE['refunded'];
        } elseif (($requestBookingPayment['event_code'] == 'REFUND' || $requestBookingPayment['event_code'] == 'REFUND_WITH_DATA') && $requestBookingPayment['event_code'] == 0) {
            // MARK BOOKING AS FAILED TO REFUND AND SEND MAIL TO JURE
            $bookingState = Booking::STATE['rejected_refund'];

            Log::notice('::adyenCapturePayment (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['PAYMENT'], Handler::TYPE_EXCEPTION_5010, self::class, __FUNCTION__, [$requestBookingPayment['booking_id']]);
        }

        if (! empty($bookingState)) {
            BookingsController::createBookingProtocolEvent($requestBookingPayment['booking_id'], $bookingState);

            Booking::query()->find($requestBookingPayment['booking_id'])->update(['state' => $bookingState]);
        }
    }

    public function edit(BookingsPayout $bookingsPayout)
    {
        abort_if(Gate::denies('bookings_payout_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payouts = Payout::all()->pluck('invoice_number', 'id')->prepend(trans('global.pleaseSelect'), '');

        $bookingsPayout->load('payouts', 'calls');

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
