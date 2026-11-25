<?php


namespace App\Http\Controllers\Frontend;



use App\Http\Controllers\Api\V1\Admin\AvailabilityApiController;
use App\Http\Controllers\Api\V1\Admin\BillingAddressApiController;
use App\Http\Controllers\Api\V1\Admin\BookingsApiController;
use App\Http\Controllers\Api\V1\Admin\CalendarController;
use App\Http\Controllers\Api\V1\Admin\CreditCardController;
use App\Http\Controllers\Api\V1\Admin\PaymentMethodController;
use App\Http\Controllers\Api\V1\Admin\VATController;
use App\Http\Controllers\Api\V1\Admin\WalletController;
use App\Http\Controllers\Api\V1\FrontendApiCalls\UserProfileApiController;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Country;
use App\ModelsApi\Feedback;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

use Illuminate\Support\Carbon;

class BookingController extends Controller
{


    public function booking(Request $request)
    {
        $userBookingsListDataObject = new UserProfileApiController();
        $userBookingsListData       = $userBookingsListDataObject->getLoggedUserBookings($request)->getData(true);

        return view('frontend.pages.booking', [
            'page_name'        => __('BOOKINGS'),
            'userBookingsList' => $userBookingsListData['data'] ?? [],

        ]);
    }


    public static function compareBookingTime($start_time)
    {
        $date = new DateTime($start_time);
        $now  = new DateTime();
        $now->add(new DateInterval('PT' . abs((int)(auth()->user()->timezone)) . 'M'));

        if ($date < $now) {
            return true;
        } else {
            return false;
        }
    }

    public static function showPostpone($start_time)
    {
        $now = new DateTime();

        $now->add(new DateInterval('PT' . abs((int)(auth()->user()->timezone)) . 'M'));

        if (floatval(env('POSTPONE_TIME')) < round((strtotime($start_time) - strtotime($now->format('Y-m-d H:i:s'))) / 3600, 2)) {
            return true;
        } else {
            return false;
        }
    }


    public static function activePointer($start_call, $end_call)
    {
        $now = new DateTime();

        $start = strtotime($start_call);
        $end   = strtotime($end_call);

        $now->add(new DateInterval('PT' . abs((int)(auth()->user()->timezone)) . 'M'));
        $userTimeZoneTime = strtotime($now->format('Y-m-d H:i:s'));

        if ($userTimeZoneTime >= $start && $userTimeZoneTime <= $end) {
            return true;
        }

        return false;
    }


    public static function bookingSwitchBadge($bookingStatus)
    {
        switch ($bookingStatus) {
            case 7:
                return [
                    'badgePointer' => 7,
                    'itemClass'    => 'canceledBookingStudent',
                    'itemText'     => __('CANCELED_BY_CLIENT') //'Canceled By Student. Refund:true.'
                ];
                break;
            case 11:
                return [
                    'badgePointer' => 11,
                    'itemClass'    => 'canceledBookingStudent',
                    'itemText'     => __('CANCELED_BY_CLIENT') //'Canceled By Student. Refund:false.'
                ];
                break;
            case 12:
                return [
                    'badgePointer' => 12,
                    'itemClass'    => 'canceledBookingProfesor',
                    'itemText'     => __('CANCELED_BY_SUPPLIER'),
                ];
                break;
            case 13:
                return [
                    'badgePointer' => 13,
                    'itemClass'    => 'canceledBookingStudent',
                    'itemText'     => __('CANCELED_BY_CLIENT'),
                ];
                break;
            case 19:
                return [
                    'badgePointer' => 19,
                    'itemClass'    => 'postponedBooking',
                    'itemText'     => __('POSTPONED'),
                ];
                break;
            case 23:
                return [
                    'badgePointer' => 23,
                    'itemClass'    => 'canceledBookingProfesor',
                    'itemText'     => __('CANCELED_BY_SUPPLIER'),
                ];
                break;
            case 24:
                return [
                    'badgePointer' => 24,
                    'itemClass'    => 'canceledBookingStudent',
                    'itemText'     => __('CANCELED_BY_CLIENT'),
                ];
                break;
            default:
                return [
                    'badgePointer' => 1,
                ];
        }
    }


    public function getBookingDetail(Request $request, $date)
    {

        $userBookingDataByDateObject = new BookingsApiController();
        $userBookingDataByDate       = $userBookingDataByDateObject->getBookings($request, $date)->getData(true);

        return view('frontend.partials.pages.booking.booking-render', [

            'page_name'             => __('BOOKINGS'),
            'userBookingDataByDate' => $userBookingDataByDate,
        ]);
    }

    public function setBookingNotification(Request $request)
    {
        if (!empty($request->input('booking_id'))) {
            $request->request->add(['booking_id' => $request->input('booking_id')]);
        }

        if (!empty($request->input('notification_state'))) {
            $request->request->add(['notification_state' => $request->input('notification_state')]);
        }

        $setBookingNotificationObject = new BookingsApiController();
        $setBookingNotification       = $setBookingNotificationObject->setBookingNotification($request)->getData(true);

        return response()->json($setBookingNotification);
    }

    public function cancelBooking(Request $request)
    {
        $data = $request->all();

        $cancelBookingObject = new BookingsApiController();
        $cancelBooking       = $cancelBookingObject->cancelBooking($request, $data['booking_id'])->getData(true);

        return $cancelBooking ?? [];
    }

    public function getRating(Request $request, $user_id)
    {
        $loggedUserData = UserController::loggedUserData($request);
        $request->request->add(['user_id' => $loggedUserData['data']['id']]);


        if (!$request->has('limit')) {
            $request->request->add(['limit' => 2]);
        }
        if (!$request->has('offset')) {
            $request->request->add(['offset' => 0]);
        }

        if (!$request->has('stars_rating')) {
            $request->request->add(['stars_rating' => 5]);
        }
        $request->request->add(['user_id' => $user_id]);
        $request->request->add(['feedback_type' => Feedback::TYPE['received']]);

        $teacherFeedbackObject = new UserProfileApiController();
        $teacherFeedback       = $teacherFeedbackObject->getTeacherRating($request)->getData(true);

        return view('frontend.partials.pages.profile.wrapper-review2', [
            'teacherFeedback' => $teacherFeedback['data'] ?? [],
        ])->render();
    }

    public function bookSlot(Request $request, $talkId)
    {
        if (isset($_COOKIE['postponeDateTime']) && !empty($_COOKIE['postponeDateTime'])) {
            $postponeTime = $_COOKIE['postponeDateTime'];
        }

        $teacherUserObject = new UserProfileApiController();
        $teacherUser       = $teacherUserObject->getTalkUserData($request, $talkId)->getData(true);

        if (!auth()->user()) {
            return redirect()->route('courses');
        }

        if (auth()->user()->id === $teacherUser['data']['id']) {
            //ovde treba da postoji stranica koja kaze korisniku da funneluje svoje kurseve
            return redirect()->route('courses');
        }


        $userObject = new UserProfileApiController();
        $user       = $userObject->show($request, $teacherUser['data']['id'])->getData(true);

        $request->headers->set('Time-Zone-Offset-UTC', getLocalTimeZone());

        $request->request->add(['talk_id' => $talkId]);
        $teacherAvailabilityObject = new UserProfileApiController();
        $teacherAvailability       = $teacherAvailabilityObject->getTeacherAvailability($request, $talkId)->getData(true);


        $bookingObj = [];

        if (!empty($teacherUser['data']['talk'])) {
            $talkData   = $teacherUser['data']['talk'];
            $bookingObj = [
                'bookingDate'      => $talkData['start_call_date'] ?? null,
                'bookingTime'      => [
                    'start_time' => $talkData['start_time_call'],
                    'end_time'   => $talkData['end_time_call'],
                ],
                'bookingPrice'     => $talkData['price'],
                'anonymousMeeting' => $talkData['anonym_call'],
                'id'               => $talkData['id'],
                'bookingDateTime'  => $talkData['start_call_date'] ?? null . " " . $talkData['start_time_call'] . ":00",
            ];
        }

        if ($request->input('id')) {
            $booking_postpone_pointer = $request->input('id');
        }


        $talkData = $teacherUser['data']['talk'] ?? [];

        if (request()->route()->getName() === 'booking') {
            $availabilityTimes = $teacherAvailability['data'] ?? [];
        } elseif (request()->route()->getName() === 'book_slot') {
            /* Call Type Change */
           if ($talkData['call_type'] === 2) {

                switch ($talkData['weekday']) {
                    case 1:
                        $availabilityTimes = $this->getTimeAvailabilites('Monday', $talkData['start_time_call']);
                        break;
                    case 2:
                        $availabilityTimes = $this->getTimeAvailabilites('Tuesday', $talkData['start_time_call']);
                        break;
                    case 3:
                        $availabilityTimes = $this->getTimeAvailabilites('Wednesday', $talkData['start_time_call']);
                        break;
                    case 4:
                        $availabilityTimes = $this->getTimeAvailabilites('Thursday', $talkData['start_time_call']);
                        break;
                    case 5:
                        $availabilityTimes = $this->getTimeAvailabilites('Friday', $talkData['start_time_call']);
                        break;
                    case 6:
                        $availabilityTimes = $this->getTimeAvailabilites('Saturday', $talkData['start_time_call']);
                        break;
                    case 7:
                        $availabilityTimes = $this->getTimeAvailabilites('Sunday', $talkData['start_time_call']);
                        break;
                }
            }
        }


        $newTeacherAvailability         = new AvailabilityApiController();
        $newTeacherAvailabilityData     = $newTeacherAvailability->getSupplierAvailability($request, $talkId)->getData(true);

        $calendars        = new CalendarController();
        $calendarsData    = $calendars->calendars($request)->getData(true);

        return view('frontend.pages.book_slot', [
            'bookingObj'               => $bookingObj,
            'userData'                 => $user['data'] ?? [],
            'talkData'                 => $teacherUser['data']['talk'] ?? [],
            'page_name'                => __('SUMMARY'),
            'teacherAvailability'      => $availabilityTimes ?? [],
            'newTeacherAvailability'   => $talkData['call_type'] ===  1 ? ($newTeacherAvailabilityData['data'] ?? []) : $availabilityTimes['data'] ?? [],
            'booking_id'               => $request->input('id', null),
            'booking_postpone_pointer' => $booking_postpone_pointer ?? 0,
            'postponeTime'             => $postponeTime ?? false,
            'calendarsData'            => $calendarsData['data'] ?? []
        ]);
    }



    public function getTimeAvailabilites($day, $startTime)
    {

        if ($day === date('l')) {

            $to = Carbon::createFromFormat('H:i:s', date("H:i:s",time()));
            $from = Carbon::createFromFormat('H:i:s', $startTime);

            $checkToday = true;
            if($to < $from){
                if($to->diffInMinutes($from) > 120){
                    $checkToday = false;
                }
            }

            $availabilityTimesArray = $this->getTimeAvailabilitesHelper(date('Y-m-d'), $startTime);

            if($checkToday){
                array_shift($availabilityTimesArray);
            }

            return [
                "success"   => true,
                "message"   => __('SUPPLIER_AVAILABILITIES'),
                "data"      => [
                    "availabilities" => $availabilityTimesArray
                ]
            ];

        } else {

            $nextDay = date('Y-m-d', strtotime('next ' . $day));
            $availabilityTimesArray = $this->getTimeAvailabilitesHelper($nextDay, $startTime);

            return [
                "success"   => true,
                "message"   => __('SUPPLIER_AVAILABILITIES'),
                "data"      => [
                    "availabilities" => $availabilityTimesArray
                ]
            ];
        }
    }

    public function getTimeAvailabilitesHelper($nextDay, $startTime){
        return [
            [
                "date"  =>  $nextDay,
                "time_slots" => [
                    [
                        "time"  => $nextDay . ' ' . $startTime
                    ]
                ],
            ],
            [
                "date"  =>  date('Y-m-d', strtotime('+7 day', strtotime($nextDay))),
                "time_slots" => [
                    [
                        "time"  => date('Y-m-d', strtotime('+7 day', strtotime($nextDay))) . ' ' . $startTime
                    ]
                ],
            ],
            [
                "date"  =>  date('Y-m-d', strtotime('+14 day', strtotime($nextDay))),
                "time_slots" => [
                    [
                        "time"  => date('Y-m-d', strtotime('+14 day', strtotime($nextDay))) . ' ' . $startTime
                    ]
                ],
            ],
            [
                "date"  =>  date('Y-m-d', strtotime('+21 day', strtotime($nextDay))),
                "time_slots" => [
                    [
                        "time"  => date('Y-m-d', strtotime('+21 day', strtotime($nextDay))) . ' ' . $startTime
                    ]
                ],
            ],
        ];
    }

    public function bookSlotPayment(Request $request)
    {
        $request->headers->set('Time-Zone-Offset-UTC', getLocalTimeZone());
        $request->headers->set('Application-Language', strtolower(App::getLocale()));

        if (!auth()->user()->id) {
            return redirect()->route('login');
        }

        if (session()->has('extension_time')) {
            $request->request->add([
                'order_id'       => session()->get('order_id'),
                'payment_type'   => session()->get('payment_type'),
                'amount'            => session()->get('amount'),
                'start_call'     => session()->get('start_call'),
                'extension_time' => session()->get('extension_time')
            ]);

            session()->forget('extension_time');

            return (new BookingsApiController())->bookExtension($request)->getData(true);
        }

        $bookingObj = [];
        $realBO     = [];

        // kreiramo booking objekat na prethodnoj booking summery stranici i snimamo ga u cookie
        // snimljeni objekat se koristi na payment stranici za ispisivanje vremena i bookinga

        if (isset($_COOKIE['bookingObj']) && !empty($_COOKIE['bookingObj'])) {
            $bookingObj = json_decode($_COOKIE['bookingObj']);

            $realBO = [
                'bookingDate'      => $bookingObj->bookingDate ?? 0,
                'bookingTime'      => [
                    'start_time' => $bookingObj->bookingTime[0] ?? '10:00',
                    'end_time'   => $bookingObj->bookingTime[1] ?? '11:00',
                ],
                'bookingPrice'     => $bookingObj->bookingPrice ?? 0,
                'anonymousMeeting' => $bookingObj->anonymousMeeting ?? 0,
                'id'               => $bookingObj->id ?? 0,
                'bookingDateTime'  => $bookingObj->bookingDate ?? "1987-25-07" . " " . $bookingObj->bookingTime[0] ?? '10:00' . ":00",
            ];
        } else {
            //ukoliko ne postoji objekat koji je potrebno kreirati na prethodnoj sranici, redirektujemo korisnika na search stranicu
            return redirect()->route('courses');
        }

        if ($request->has('token') && $request->has('PayerID')) {
            $request->request->add([
                'order_id'     => $request->input('token'),
                'amount'       => $realBO['bookingPrice'],
                'payment_type' => 'paypal',
                'start_call'   => $realBO['bookingDateTime'] . ' ' . $realBO['bookingTime']['start_time'],
                'talk_id'      => $realBO['id'],
                'vat_id'       => $request->input('vat_id') ?: Country::GERMANY,
            ]);

            $bookingsPayObject = new BookingsApiController();
            $bookingsPay       = $bookingsPayObject->store($request)->getData(true);

            if ($bookingsPay['success']) {
                return redirect('/booking-thank-you'); //Redirect to thank you page
            };
        }

        $teacherUserObject = new UserProfileApiController();
        $teacherUser       = $teacherUserObject->getTalkUserData($request, $bookingObj->id)->getData(true);
        $userObject = new UserProfileApiController();
        $user       = $userObject->show($request, $teacherUser['data']['id'])->getData(true);

        $request->request->add(['talk_id' => $bookingObj->id]);
        $userTalkDataObject = new UserProfileApiController();
        $userTalkData       = $userTalkDataObject->teacherTalks($request, $user['data']['id'])->getData(true);
        if (!isset($userTalkData['data'])) {
            return redirect()->route('courses');
        }

        $userID = auth()->user()->id;

        $message = $request->get('message');

        if ($message != "") {
            $bookingData               = [
                'talk_id'           => $realBO['id'],
                'teacher_id'        => $teacherUser['data']['id'],
                'booking_date_time' => $realBO['bookingDateTime'],
                'anonym'            => $realBO['anonymousMeeting'],
            ];
            $bookingData['user']['id'] = $userID;

            $request->merge($bookingData);

            $bookingResponse           = $this->bookingTransactionProcess($request);

            if ($bookingResponse->original['success']) {
                return redirect('/booking-thank-you'); //Redirect to thank you page
            }
        }

        $countriesDataObject = new VATController();
        $countriesData       = $countriesDataObject->index($request)->getData(true);

        $userAccountingObject = new BillingAddressApiController();
        $userAccounting       = $userAccountingObject->userAccounting($request)->getData(true);

        $newCards       = new PaymentMethodController();
        $newCardsData   = $newCards->index($request)->getData(true);

        $userCardsObject = new CreditCardController();
        $userCards        = $userCardsObject->cardList($request)->getData(true);

        $threeDSuccessPointer = false;

        if ($request->has('success')) {
            if ($request->get('success') === "true") {
                $threeDSuccessPointer = true;
            } else {
                $threeDSuccessPointer = false;
            }
        }

        return view('frontend.pages.book_slot_payment', [
            'userAccounting'        => $userAccounting['data'] ?? [],
            'countries'             => $countriesData['data'] ?? [],
            'taxes'                 => Country::whereHasVAT()->get(),
            'userData'              => $user['data'] ?? [],
            'talkData'              => $userTalkData['data'][0] ?? [],
            'page_name'             => __('SETTINGS'),
            'bookingObj'            => $realBO,
            'walletData'            => auth()->user()->wallet_balance,
            'threeDSuccessPointer'  => $threeDSuccessPointer,
            'user_id'               => $userID,
            'teacher_id'            => $teacherUser['data']['id'] ?? [],
            'teacher'               => $teacherUser['data'],
            'cards_data'            => $newCardsData['data'] ?? [],
            'user_cards'            => $userCards ?? [],
        ]);
    }

    public function bookingPostpone(Request $request)
    {

        if (!auth()->user()->id) {
            return redirect()->route('login');
        }

        //get cookie

        $realBO         = [];
        $bookingSuccess = false;
        $errMessage     = '';

        if (isset($_COOKIE['bookingObj']) && !empty($_COOKIE['bookingObj'])) {
            $bookingObj = json_decode($_COOKIE['bookingObj']);
            $realBO     = [
                'bookingDate'      => $bookingObj->bookingDate,
                'bookingTime'      => [
                    'start_time' => $bookingObj->bookingTime[0],
                    'end_time'   => $bookingObj->bookingTime[1],
                ],
                'bookingPrice'     => $bookingObj->bookingPrice,
                'anonymousMeeting' => $bookingObj->anonymousMeeting,
                'id'               => $bookingObj->id,
                'bookingDateTime'  => $bookingObj->bookingDate . " " . $bookingObj->bookingTime[0] . ":00",
                'bookingId'        => $bookingObj->bookingId,
            ];
        }

        $request->headers->set('Time-Zone-Offset-UTC', getLocalTimeZone());
        $request->request->add([
            'start_call' => $realBO['bookingDateTime'],
            'anonym'     => $realBO['anonymousMeeting'] ? 1 : 0,
            'talk_id'    => $realBO['id'],
            'booking_id' => $realBO['bookingId'],
        ]);

        $bookingDataObject = new BookingsApiController();
        $bookingData       = $bookingDataObject->store($request)->getData(true);

        if ($bookingData['success'] && isset($bookingData['data']['booking_id'])) {
            $bookingData['data']['booking_id'];

            $request->request->add([
                'user_id'    => auth()->user()->id,
                'booking_id' => $bookingData['data']['booking_id'],
            ]);
            $request->headers->set('Time-Zone-Offset-UTC', getLocalTimeZone());

            $transactionDataObject = new WalletController();
            $transactionData       = $transactionDataObject->addBookTransaction($request)->getData(true);

            if ($transactionData['success']) {
                $bookingSuccess = true;
            }
        } else {
            $errMessage = $bookingData['message'];
        }

        if ($bookingSuccess) {
            return redirect()->route('booking_thank_you', ['id' => auth()->user()->id]);
        } else {
            Session::flash('alert-danger', $errMessage);
            return redirect()->back();
        }
    }

    public function bookingTransaction(Request $request)
    {
        return $this->bookingTransactionProcess($request);
    }

    public function bookingTransactionProcess($request)
    {
        $data = $request->all();

        $talkId = $data['talk_id'];

        $startTime = $data['booking_date_time'];
        $anonym    = ($data['anonym'] == 1 ? 1 : 0);

        $request->request->add(['talk_id' => $talkId]);
        $userTalkDataObject = new UserProfileApiController();
        $userTalkData       = $userTalkDataObject->teacherTalks($request, $data['teacher_id'])->getData(true);

        $bookingPrice   = $userTalkData['data'][0]['price'];
        $loggedUserData = UserController::loggedUserData($request);

        $availableBalance = floatval(preg_replace('/[^\d.]/', '', $loggedUserData['data']['wallet_balance']));

        if ($bookingPrice > $availableBalance) {
            return response()->json([
                'success' => false,
                'message' => __('INSUFFICIENT_BALANCE_IN_YOUR_WALLET4'),
            ]);
        }

        $request->request->add([
            'start_call' => $startTime,
            'anonym'     => $anonym,
            'talk_id'    => $talkId,
            'booking_id' => '',
        ]);

        $bookingDataObject = new BookingsApiController();

        $bookingData = $bookingDataObject->store($request)->getData(true);
        return response()->json([
            'success' => true,
            'message' => $bookingData['message'],
        ]);
    }

    public function depositCoins(Request $request)
    {
        $data        = $request->all();
        $tokenType   = session('token_type');
        $accessToken = session('access_token');
        $userId      = $data['user']['id'];
        $amount      = $data['coins'];
        $webURL      = $data['web_url'];

        $depositData = Http::withHeaders([
            'Accept'               => 'application/json',
            'Authorization'        => "$tokenType $accessToken",
            'Application-Language' => strtolower(App::getLocale()),
            'Time-Zone-Offset-UTC' => getLocalTimeZone(),
        ])->post(env('APP_BACKEND_URL', '') . '/deposite-in-wallet', [
            'user_id'  => $userId,
            'amount'   => $amount,
            'currency' => 'eur',
            'web_url'  => $webURL,
        ]);

        return response()->json($depositData->json());
    }

    public function bookingThankYou(Request $request)
    {
        if (!auth()->user()->id) {
            return redirect()->route('login');
        }

        $request->request->add(['user_id' => auth()->user()->id]);
        $lastBookingDataObject = new BookingsApiController();
        $lastBookingData       = $lastBookingDataObject->getUserLastBooking($request)->getData(true);

        $lastBooking = $lastBookingData['data'];

        if (empty($lastBooking)) {
            return redirect()->route('home');
        }

        if (!empty($lastBooking['bookingData'])) {
            $bookingData = $lastBooking['bookingData'];

            $bookingObj = [
                'bookingDate'                       => $bookingData['start_date'],
                'bookingTime'                       => [
                    'start_time' => $bookingData['start_time'],
                    'end_time'   => $bookingData['end_time'],
                ],
                'bookingPrice'                      => $bookingData['price'],
                'anonymousMeeting'                  => $bookingData['anonym'],
                'id'                                => $bookingData['id'],
                'bookingDateTime'                   => $bookingData['start_date'] . " " . $bookingData['start_time'],
                'postpone_pointer'                  => $lastBooking['parentBooking'] ? true : false,
                'talk_name_from_last_booking'       => $lastBooking['talkData']['headline'] ?? false,
                'talk_start_date_from_last_booking' => $lastBooking['parentBooking']['start_date'] ?? false,
                'talk_start_time_from_last_booking' => $lastBooking['parentBooking']['start_time'] ?? false,
            ];
        }

        return view(
            'frontend.pages.book_slot_thankyou',
            [
                'bookingObj' => $bookingObj,
                'talkData'   => $lastBooking['talkData'] ?? [],
            ]
        );
    }

    public function booking_details(Request $request, $bookingId)
    {
        $booking = Booking::find($bookingId);

        if (!(in_array(auth()->id(), [$booking->participant_user_id, $booking->teacher_user_id]))) {
            return abort(403);
        }

        $bookingPaymentTypeObject = $booking->payment()->whereNotNull('transaction_id')->first();
        $bookingPaymentType       = Str::startsWith($bookingPaymentTypeObject->transaction_id, ['ch', 'pi']) ? 'Credit Card' : 'PayPal';



        // requested booking data
        $bookingDetailsObject = new BookingsApiController();
        $bookingDetails       = $bookingDetailsObject->getBookingData($request, $bookingId);

        $paymentDate = changeDateFormatLocale('Y-m-d H:i:s', $bookingDetails['data'][0]['paid_at'], true) . ' ' . strtolower(__('AT')) . ' ' . date(
            'H:i',

            strtotime($bookingDetails['data'][0]['paid_at'])

        );
        return view('frontend.pages.booking_details', [

            'bookingDetails'      => $bookingDetails['data'][0] ?? [],
            'page_name'           => __('BOOKINGS'),
            'bookingPaymentType'  => $bookingPaymentType,
            'paymentDate'         => $paymentDate

        ]);
    }
}
