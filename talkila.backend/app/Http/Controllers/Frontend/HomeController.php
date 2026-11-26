<?php

namespace App\Http\Controllers\Frontend;


use App\Entity\CallTypes;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Api\V1\Admin\BillingAddressApiController;
use App\Http\Controllers\Api\V1\Admin\CalendarController;
use App\Http\Controllers\Api\V1\Admin\CreditCardController;
use App\Http\Controllers\Api\V1\Admin\JoinTheClubApiController;
use App\Http\Controllers\Api\V1\Admin\LanguagesApiController;
use App\Http\Controllers\Api\V1\Admin\PaymentMethodController;

use App\Http\Controllers\Api\V1\Admin\ProfileVerificationApiController;
use App\Http\Controllers\Api\V1\Admin\TalkCategoriesApiController;
use App\Http\Controllers\Api\V1\Admin\TalksApiController;
use App\Http\Controllers\Api\V1\Admin\VATController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\FrontendApiCalls\UserProfileApiController;
use App\Http\Controllers\Controller;

use App\Http\Requests\ApiRequests\UpdateTalkRequest;
use App\Models\Booking;

use App\ModelsApi\Talk;
use App\ModelsApi\User;
use Curl\Curl;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    /**
     * A User model.
     */
    public User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function faq()
    {

        return view('frontend.pages.faq',[
                'page_name'      => __('FAQ')
            ]
        );
    }

    public function verificationEmail(Request $request)
    {
        $request->merge(['api_call' => true]);
        $sendVerificationObject = new UsersController();
        $sendVerification       = $sendVerificationObject->registrationVerification($request)->getData(true);
        Session::flash('alert-success', $sendVerification['message']);
        $route = 'courses';

        if (!$sendVerification['success']) {
            $route = 'login';
        }

        return redirect()->route($route)->with('user_email', $request->input('user_email'));
    }


    public function jtc_welcome(Request $request)
    {
        if (auth()->user()->jtc?->state) {
            return redirect()->route('home');
        }


        if (auth()->user()->jtc?->jtc_started === true) {

            $array = [
                'step_1' => auth()->user()->jtc?->step_1,
                'step_2' => auth()->user()->jtc?->step_2,
                'step_3' => auth()->user()->jtc?->step_3,
                'step_4' => auth()->user()->jtc?->step_4
            ];


            $step = '';
            foreach ($array as $key => $value) {

                if (!$array[$key]) {
                    $step = $key;
                    break;
                }
            }


            switch ($step) {
                case 'step_1':

                    if(auth()->user()->parnter_id){

                        return redirect()->route('jtc2_add_your_first_talk');
                    }else{
                        return redirect()->route('jtc2_create_profile');
                    }

                    break;
                case 'step_2':
                    return redirect()->route('jtc2_add_your_first_talk');
                    break;
                case 'step_3':
                    return redirect()->route('jtc2_set_availabilities');
                    break;
                case 'step_4':
                    return redirect()->route('jtc2_verify_account');
                    break;

            }
        }

        return view('frontend.pages.jtc_welcome', [
            'page_name'    => __('JOIN_THE_CLUB')
        ]);
    }

    public function jtc_start()
    {
        $this->user->current()->startJTC();

        return response()->success(__('SUCCESSFULLY_STARTED_JTC_PROCESS'));
    }


    public function teacherTalks(Request $request)
    {
        $teacherId = $request->input('teacherId');
        $talk_type = $request->input('talk_type');
        $offset    = $request->input('offset');
        $limit     = $request->input('limit');

        $request->request->add(['call_type' => $talk_type]);
        $request->request->add(['offset' => $offset]);
        $request->request->add(['limit' => $limit]);



        if (!empty(auth()->user()->id)) {

            $userPrivateTalksObject = new UserProfileApiController();
            $userPrivateTalks       = $userPrivateTalksObject->teacherTalks($request, $teacherId)->getData(true);
        } else {

            $userPrivateTalksObject = new TalksApiController();
            $userPrivateTalks       = $userPrivateTalksObject->teacherTalks($request, $teacherId)->getData(true);
        }

        if ($talk_type == 1) {

            $teacher_username = $request->input('teacher_username', '');

            $userObject = new UserProfileApiController();
            $userData   = $userObject->show($request, $teacher_username)->getData(true);

            return [
                'html'    => view('frontend.partials.pages.profile.courses_profile', [
                    'userPrivateTalks'     => $userPrivateTalks['data'] ?? [],
                ])->render(),
                'htmlMobile'    => view('frontend.partials.pages.profile.course_mobile_overview', [
                    'userPrivateTalks'  => $userPrivateTalks['data'] ?? [],
                    'userData'          => $userData['data'] ?? [],
                ])->render(),
                'success' => true,
            ];
        } elseif ($talk_type == 2) {
            return [
                'html'    => view('frontend.partials.pages.courses.profile_show_more_talks', [
                    'request'              => $request,
                    'type'                 => $talk_type,
                    'bookTalk'             => true,
                    'supervisor'           => $offset,
                    'totalDowntownAbsents' => $limit,
                    'userPrivateTalks'     => $userPrivateTalks['data'] ?? [],
                ])->render(),
                'poruka'  => true,
                '$offset' => $offset,
                '$limit'  => $limit,
                'success' => true,
            ];
        } else {
            return [
                'message' => __('ATTRIBUTE_REQUIRED', ['attribute' => 'Talk type']),
                'type'    => $talk_type,
                'success' => true,
            ];
        }
    }

    public function index(Request $request)
    {




        if ($request->has('code')) {

            if (session()->get('addCalendarFromHome') == 1) {

                session()->forget('addCalendarFromHome');

                $addCalendar      = new CalendarController();
                $addCalendarData  = $addCalendar->connect($request)->getData(true);

                /* if ($addCalendarData['success']) {
                    Session::flash('alert-info', $addCalendarData['message']  . ' Calendar provider: Google');
                } */
            }
        } else {
            session()->forget('addCalendarFromHome');
        }


        $loggedUser = auth()->user();

        if (!empty($loggedUser) && $loggedUser->userRole() == 'Admin') {
            return redirect()->route('admin.home');
        }

        if (!isset($loggedUser->id)) {
            return view('frontend.pages.home');
        }else{
            if(isset($_COOKIE['partner_affiliate_started']) && !empty($_COOKIE['partner_affiliate_started'])){

                unset($_COOKIE['partner_affiliate_started']);
                setcookie('partner_affiliate_started', null, -1, '/');

            }
        }



        if ($request->user()->type != User::TYPE['supplier']) {
            return redirect()->route('courses');
        }


        /* Call Type Change */


        $userPrivateTalksObject = new TalksApiController();
        $userPrivateTalks       = $userPrivateTalksObject->teacherTalks($request, auth()->user()->id)->getData(true);

        $request->headers->set('Time-Zone-Offset-UTC', getLocalTimeZone());
        $userAvailabilityObject = new JoinTheClubApiController();
        $userAvailability       = $userAvailabilityObject->getUserAvailability($request, auth()->user()->id)->getData(true);

        $calendars     = new CalendarController();
        $calendarsData = $calendars->calendars($request)->getData(true);



        return view('frontend.pages.home_logged', [


            'userPrivateTalks'      => $userPrivateTalks['data'] ?? [],

            'userAvailability'      => $userAvailability['data'] ?? [],

            'page_name'             => __('HOME'),
            'calendrsData'          => $calendarsData['data'] ?? []
        ]);
    }

    public function add_jtc_calendar(Request $request, $from)
    {

        if ($from === 'addCalendarFromJtc') {
            session()->put('addCalendarFromJtc', 1);
        } else if ($from === 'addCalendarFromHome') {
            session()->put('addCalendarFromHome', 1);
        }

        return redirect('https://accounts.google.com/o/oauth2/v2/auth?scope=https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/calendar.readonly https://www.googleapis.com/auth/calendar.app.created&access_type=offline&include_granted_scopes=true&response_type=code&state=state_parameter_passthrough_value&redirect_uri=' . config('services.google.calendar_redirect') . '&client_id=' . config('services.google.client_id'));
    }

    public function getUserAvailability(Request $request, $userId = null)
    {
        $request->request->add(['user_id' => auth()->user()->id]);
        $request->headers->set('Time-Zone-Offset-UTC', getLocalTimeZone());
        $userAvailabilityObject = new UserProfileApiController();
        $userAvailability       = $userAvailabilityObject->getUserAvailability($request)->getData(true);

        $start       = strtotime('00:00');
        $end         = strtotime('23:45');
        $lowestTime  = null;
        $highestTime = null;
        $takenTime   = [];

        if (!empty($userAvailability['data'])) {
            foreach ($userAvailability['data'] as $availability) {
                $weekday = [];
                if (!$availability['state']) {
                    continue;
                }
                if (empty($takenTime[$availability['weekday']])) {
                    for ($i = $start; $i <= $end; $i = $i + 15 * 60) {
                        $time = date('H:i:s', $i);
                        array_push($weekday, $time);
                    }
                    $takenTime[$availability['weekday']] = $weekday;
                }
                if (empty($lowestTime)) {
                    $lowestTime = $availability['start_time'];
                } else {
                    if (strtotime($availability['start_time']) < strtotime($lowestTime)) {
                        $lowestTime = $availability['start_time'];
                    }
                }

                if (empty($highestTime)) {
                    $highestTime = $availability['end_time'];
                } else {
                    if (strtotime($availability['end_time']) > strtotime($highestTime)) {
                        $highestTime = $availability['end_time'];
                    }
                }
                foreach ($takenTime[$availability['weekday']] as $key => $day) {
                    if (strtotime($day) >= strtotime($availability['start_time']) && strtotime($day) <= strtotime(
                        $availability['end_time']
                    )) {
                        unset($takenTime[$availability['weekday']][$key]);
                    }
                }
            }
        }

        return response()->json([
            'availability' => $userAvailability['data'] ?? [],
            'takenTime'    => $takenTime,
            'lowestTime'   => $lowestTime != '00:00:00' ? date(
                'H:i',
                strtotime("-15 minutes", strtotime($lowestTime))
            ) : date('H:i', strtotime($lowestTime)),
            'highestTime'  => $highestTime != '00:00:00' ? date(
                'H:i',
                strtotime("+15 minutes", strtotime($highestTime))
            ) : date('H:i', strtotime($highestTime)),
        ]);
    }

    public function deleteAvailability($availability)
    {
        $deleteAvailabilityObject = new JoinTheClubApiController();
        $deleteAvailability       = $deleteAvailabilityObject->joinTheClubDeleteAvailability($availability)->getData(
            true
        );

        return $deleteAvailability->json();
    }

    public function affiliateRefereeHash(Request $request, $affiliateRefereeHash)
    {
        $loggedUser = $request->user();

        if (!isset($_COOKIE['affiliateRefereeHash']) && empty($_COOKIE['affiliateRefereeHash']) && !isset($loggedUser->id)) {
            setcookie("affiliateRefereeHash", $affiliateRefereeHash, time() + (24 * 3600 * 30), "/lp");
            setcookie("affiliateRefereeHash", $affiliateRefereeHash, time() + (24 * 3600 * 30), "/account/signup");
            setcookie("affiliateRefereeHash", $affiliateRefereeHash, time() + (24 * 3600 * 30), "/account/login");
            setcookie(
                "affiliateRefereeHash",
                $affiliateRefereeHash,
                time() + (24 * 3600 * 30),
                "/login/facebook/callback"
            );
            setcookie(
                "affiliateRefereeHash",
                $affiliateRefereeHash,
                time() + (24 * 3600 * 30),
                "/login/google/callback"
            );
        }

        return redirect()->route('home');
    }

    public function updateTalk(UpdateTalkRequest $request, Talk $talk)
    {

        if (!$request->has('talkId')) {
             return response()->json([
                'message' => __('ATTRIBUTE_REQUIRED', ['attribute' => 'Talk ID']),
                'success' => false,
            ]);
        }


        $updateTalkDataObject = new TalksApiController();
        $updateTalkData       = $updateTalkDataObject->update($request, $talk)->getData(true);



        return response()->json([
            'message' => $updateTalkData['message'],
            'success' => $updateTalkData['success'],
        ]);
    }


    public function account_verification(Request $request)
    {
        if (!auth()->user()->id) {
            return redirect()->route('login');
        }

        $userVerificationsObject = new ProfileVerificationApiController();
        $userVerifications       = $userVerificationsObject->profileVerification($request)->getData(true);

        return view('frontend.pages.account_verification', [
            'page_name'         => __('BOOKINGS'),
            'userVerifications' => $userVerifications['data'] ?? [],
        ]);
    }

    public function video_conference(Request $request)
    {
        $loggedUserData = UserController::loggedUserData($request);

        $user_id       = auth()->user()->id;
        $feedback_time = date('Y-m-d H:i:s');

        $booking = Booking::query()
            ->where(function ($query) use ($user_id) {
                $query->where('participant_user_id', $user_id);
                $query->orWhere('teacher_user_id', $user_id);
            })
            ->where(function ($query) use ($feedback_time) {
                $query->where('start_call', '<=', $feedback_time);
                $query->where('end_call', '>=', $feedback_time);
            })
            ->join('billing_addresses', 'bookings.supplier_billing_address_id', '=', 'billing_addresses.id')
            ->join('countries', 'bookings.vat_id', '=', 'countries.id')
            ->select(['bookings.*', 'billing_addresses.pays_vat', 'countries.vat_value'])
            ->orderBy('id', 'DESC')
            ->first();

        $countriesDataObject = new VATController();
        $countriesData       = $countriesDataObject->index($request)->getData(true);

        $userAccountingObject = new BillingAddressApiController();
        $userAccounting       = $userAccountingObject->userAccounting($request)->getData(true);

        $newCards       = new PaymentMethodController();
        $newCardsData   = $newCards->index($request)->getData(true);

        return view(
            'frontend.pages.video_conference',
            [
                'userAccounting'  => $userAccounting['data'] ?? [],
                'countries'       => $countriesData['data'] ?? [],
                'loggedUserData'  => $loggedUserData['data'] ?? [],
                'walletBalance'   => auth()->user()->wallet_balance ?? 0,
                'defaultCardData' => $defaultCardData['data'] ?? [],
                'booking'         => $booking,
                'cards_data'      => $newCardsData['data'] ?? [],
                'fromApp'         => $request->has('fromApp') ? '1' : null
            ]
        );
    }

    public function joinVideoViaToken(Request $request): RedirectResponse
    {
        $user = (new User())->findViaToken($request->get('token'));

        if (!$user) {
            return redirect()->route('login');
        }

        $user->update([
            'talk_token_used_at' => now(),
        ]);

        auth()->loginUsingId($user->id);
        $token = $user->createToken('Personal Access Token')->accessToken;
        session()->put('access_token', 'Bearer ' . $token);

        return redirect()->route('video_conference', [
            'fromApp' => true,
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        return redirect()->route('logout-admin');


        if (!auth()->user()->id) {
            return redirect()->route('login');
        }


        $logoutUserObject = new AuthController();
        $logoutUser       = $logoutUserObject->logout($request)->getData(true);

        return view('frontend.pages.login');
    }

    public function signup()
    {

        if(isset($_COOKIE['partner_affiliate_started']) && !empty($_COOKIE['partner_affiliate_started'])){

            $decodedCookie = json_decode(base64_decode($_COOKIE['partner_affiliate_started']));

            return redirect()->route('jtc2_create_profile', [

                'image'                 => isset($decodedCookie->requestParams->ti) ? $decodedCookie->requestParams->ti : false,
                'error_message'         => isset($savePartnerData['message']) ? $savePartnerData['message'] : null,
                'pratnerData'           => json_encode($decodedCookie->pratnerData),
                'savePartnerData'       => base64_encode(json_encode($decodedCookie->savePartnerData)),
                'requestParams'         => base64_encode(json_encode($decodedCookie->requestParams))

            ]);
        }

        return view('frontend.pages.signup');
    }

    public function forgot_password()
    {
        return view('frontend.pages.forgot_password');
    }

    //this is used for gettig talk details when edit talk
    public function categorySubcategories(Request $request)
    {
        $talkCategoriesDataObject = new TalkCategoriesApiController();
        $talkCategoriesData       = $talkCategoriesDataObject->getTalkCategories($request)->getData(true);





        return response()->json([
            'talk_categories' => $talkCategoriesData ?? [],


        ]);
    }

    public function legal(Request $request, $slug)
    {
        if (empty($request->input('language'))) {
            $request->request->add(['lang' => App::getLocale()]);
        }

        $contentObject = new PageController();
        $content       = $contentObject->dynamic_page($request, $slug)->getData(true);

        if (empty($content['content']['page'])) {
            throw new NotFoundHttpException();
        }

        $content = $content['content']['page'];

        return view('frontend.pages.dynamic-page', compact('content'));
    }

    public function login()
    {
        $loggedUser = auth()->user();


        if(isset($_COOKIE['partner_affiliate_started']) && !empty($_COOKIE['partner_affiliate_started'])){
            $decodedCookie = json_decode(base64_decode($_COOKIE['partner_affiliate_started']));

        }


        if (!empty($loggedUser)) {
            return redirect()->route('home');
        }

        return view('frontend.pages.login',['decodedCookie' => $decodedCookie ?? null]);
    }

    public function guzzleRegister(Request $request)
    {
        $contentObject = new AuthController();
        $content       = $contentObject->register($request)->getData(true);

        if ($content['success']) {
            $message = 'User successfully registered, please verify on received email.';

            // Set Verification Message cookie, so it can be caught and displayed on frontend.
            setcookie('registrationMessage', 'Please check your mails', time() + 3000, '/account/login');

            return [
                "path"    => 'login',
                "success" => true,
                "message" => $message,
            ];
        } else {
            if (!empty($content['message'])) {
                $message = $content['message'];
            } else {
                $message = 'Wrong form structure, please check and try again';
            }
            return [
                "success" => false,
                "message" => $message,
            ];
        }
    }

    public function forgotPassword(Request $request)
    {
        $request->request->add([
            'lang'  => strtolower(App::getLocale()),
            'email' => $request->input('email'),
        ]);

        $contentObject = new AuthController();
        $content       = $contentObject->sendResetLinkEmail($request)->getData(true);

        return [
            "path"    => route('login'),
            "success" => true,
            "message" => __('RESET_PASSWORD_RESPONSE'),
        ];

        /* $content = Http::post(config('app.appBackendServerUrl', '').'/forgot-password', [
            'lang'      => strtolower(App::getLocale()),
            'email'     => $request->input('email')
        ]); */

        if (!isset($content) && empty($content)) {
            throw new NotFoundHttpException();
        }

        if ($content['success'] ?? false) {
            //Session::flash('alert-success', 'Successfully requested new password.');

            //return redirect()->route('login');
            return [
                "path"    => route('login'),
                "success" => true,
                "message" => 'Successfully requested new password. Mail has been send to your email account.',
            ];
        } else {
            if (!empty($content['message'])) {
                $message = $content['message'] ? 'Successfully requested new password. Mail has been send to your email account.' : 'Successfully requested new password. Mail has been send to your email account.';
            } else {
                $message = 'Successfully requested new password. Mail has been send to your email account.';
            }
            //Session::flash('alert-danger', $message);
            //return redirect()->back();
            return [
                "success" => false,
                "message" => $message,
            ];
        }
    }

    //used for adding stripe cards
    public function addStripeCard(Request $request)
    {


        $request->request->add(['user_id' => auth()->user()->id]);

        $userCardsObject = new CreditCardController();
        $userCards       = $userCardsObject->cardList($request)->getData(true);

        return [
            'html' => view('frontend.partials.pages.settings.cardpopup', [
                'user_cards' => $userCards ?? [],
            ])->render(),
        ];
    }


}
