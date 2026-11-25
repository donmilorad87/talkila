<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Admin\TalkCategoriesApiController;
use App\Http\Controllers\Api\V1\Admin\LanguagesApiController;
use App\Http\Controllers\Api\V1\Admin\JoinTheClubApiController;

use App\Models\Partner;
use App\Http\Requests\PartnerSaveRequest;
use App\Http\Controllers\Api\V1\Auth\PartnerController;


class Jtc2Controller extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function partner_start(Request $request, $partner = false)
    {

        if (auth()->user()) {

            return redirect()->route('home');
        }

        if ($partner) {

            if ($request->has('te')) {

                $qyeryParameters =  '?te=' . $request->get('te');

                if ($request->has('tu')) {
                    $qyeryParameters = $qyeryParameters . '&tu=' . $request->get('tu');
                }

                if ($request->has('ti')) {
                    $qyeryParameters = $qyeryParameters . '&ti=' . $request->get('ti');
                }

                if ($request->has('td')) {
                    $qyeryParameters = $qyeryParameters . '&td=' . $request->get('td');
                }

                return redirect()->route('partner_create_profile', $partner . $qyeryParameters);
            }
        }

        return redirect()->route('jtc2_create_profile', [
            'email'                 => null,
            'image'                 => '/assets/images/avatar.svg',

        ]);
    }
    public function partner_create_profile(Request $request, PartnerSaveRequest $pRequest, Partner $partner)
    {



        $savePartner            = new PartnerController();
        $savePartnerData        = $savePartner->save($pRequest, $partner)->getData(true);



        if ($savePartnerData['success']) {

            if (isset($savePartnerData['data']['type'])) {
                $type = $savePartnerData['data']['type'];
                if ($type === 1 || $type === 2) {
                    return redirect()->route('login', [
                        'email' => $request->has('email') ? $request->get('email') : '',
                        'message'   => __('YOU_ALLREADY_HAVE_ACCOUNT')
                    ]);
                } else {
                    //set
                    if (!isset($_COOKIE['partner_affiliate_started'])) {
                        setcookie('partner_affiliate_started', base64_encode(
                            json_encode(
                                [
                                    'savePartnerData'       => $savePartnerData,
                                    'pratnerData'           => $partner->toArray(),
                                    'requestParams'         => $request->all()
                                ]
                            )
                        ), time() + 30 * 24 * 3600 * 30, '/');
                    }
                }
            }

        } else {

            $errorMesage = $savePartnerData['message'];

        }

        return redirect()->route('jtc2_create_profile', [

            'image'                 => $_GET['image'] ?? false,
            'error_message'         => $errorMesage ?? null,
            'pratnerData'           => json_encode($partner->toArray()),
            'savePartnerData'       => base64_encode(json_encode($savePartnerData)),
            'requestParams'         => base64_encode(json_encode($request->all()))
        ]);
    }

    public function create_profile(Request $request)
    {


        if (auth()->user()) {
            if (auth()->user()->jtc?->state) {
                return redirect()->route('home');
            }
        }

        return view('frontend.pages.jtc2_create_profile', [

            'image'                 => $_GET['image'] ?? null,
            'error_mesage'          => $request->get('error_message') ?? null,
            'pratnerData'           => json_decode($request->get('pratnerData')),
            'savePartnerData'       => json_decode(base64_decode($request->get('savePartnerData'))),
            'requestParams'         => json_decode(base64_decode($request->get('requestParams'))),
        ]);
    }

    public function verify_email(Request $request)
    {
        return view('frontend.pages.jtc2_email_verification');
    }

    public function add_your_first_talk(Request $request)
    {

        $request->headers->set('Application-Language', session('language') ?? 'de');

        $talkCategoriesObject = new TalkCategoriesApiController();
        $talkCategoriesData   = $talkCategoriesObject->getTalkCategories($request)->getData(true);

        $languagesObject = new LanguagesApiController();
        $languagesData   = $languagesObject->index($request)->getData(true);

        return view('frontend.pages.jtc2_add_your_first_talk', [
            'userPrivateTalkData'  => auth()->user()->talks()->paginate(5) ?? [],
            'talkCategoriesData'   => $talkCategoriesData['data'] ?? [],
            'languagesData'        => $languagesData['data'] ?? []

        ]);
    }


    public function set_availabilities(Request $request)
    {

        $userAvailabilityObject = new JoinTheClubApiController();
        $userAvailability       = $userAvailabilityObject->getUserAvailability($request, auth()->user()->id)->getData(true);

        $userAvailabilityObject = new JoinTheClubApiController();
        $userAvailability2 = $userAvailabilityObject->getUserAvailability($request, auth()->user()->id)->getData(true);


        return view('frontend.pages.jtc2_set_availabilities', [
            'userAvailability'      => $userAvailability['data'] ?? [],
            'userAvailability2' => $userAvailability2['data'] ?? [],
        ]);
    }


    public function verify_account(Request $request)
    {
        if (auth()->user()) {
            if (auth()->user()->pendingProfileVerificationRequest) {
                return redirect()->route('home');
            }
        }

        return view('frontend.pages.jtc2_verify_account');
    }


    public function account_created(Request $request)
    {
        return view('frontend.pages.jtc2_account_created');
    }
}
