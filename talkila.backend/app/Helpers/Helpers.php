<?php

namespace App\Helpers;


use App\Http\Controllers\Api\V1\Admin\TalkCategoriesApiController;
use App\Http\Controllers\Api\V1\FrontendApiCalls\UserProfileApiController;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Jorenvh\Share\ShareFacade;

class Helpers
{
    public static function convertServerTimeToUTC($date, $format, $returnFormat)
    {
        $time = DateTime::createFromFormat($format, $date);

        $timezone = $_COOKIE['timezone'];

        if ($timezone > 0) {
            $time->add(new DateInterval('PT' . $timezone . 'M'));
        } else {
            $time->sub(new DateInterval('PT' . abs($timezone) . 'M'));
        }

        $date = $time->format($returnFormat);
        return $date;
    }

    public static function createAffiliateReferralLink(Request $request) {
        return env('APP_URL_STRING') . '/lp/'. $request->user()->affiliate->subaffiliates->first()->tracking_id;
    }

    public static function isLoggedIn()
    {

        if(!isset(\auth()->user()->id)) {
            return false;
        }
        return true;
    }

    public static function getShareLinks()
    {

        $loggedUserData = \auth()->user();

        $shareLinks = ShareFacade::page(env('APP_URL').'/'.($loggedUserData->username ?? null))
            ->facebook()
            ->twitter()
            ->linkedin('Extra linkedin summary can be passed here')
            ->whatsapp()
            ->getRawLinks();

        return $shareLinks;

    }

    public static function getCategories(Request $request){

        /* $tokenType      = session('token_type');
        $accessToken    = session('access_token'); */

        if(!auth()->user()) {
            return redirect()->route('login');
        }

        $talkCategoriesDataObject = new TalkCategoriesApiController();
        $talkCategoriesData = $talkCategoriesDataObject->getTalkCategories($request)->getData(true);

        /* $talkCategoriesData = Http::withHeaders([
            'Accept'                => 'application/json',
            'Authorization'         => "$tokenType $accessToken",
            'Application-Language'  => strtolower(App::getLocale()),

        ])->get(env('APP_BACKEND_URL', '') . '/talk-categories', [

        ]); */

        return $talkCategoriesData;
    }


    public static function getUserAvailability(Request $request)
    {

        $userAvailabilityObject = new UserProfileApiController();
        $userAvailability = $userAvailabilityObject->getUserAvailability($request)->getData(true);


        $start      = strtotime('00:00');
        $end        = strtotime('23:45');
        $lowestTime = null;
        $highestTime= null;
        $takenTime  = [];

        if(!empty($userAvailability['data'])) {
            foreach ($userAvailability['data'] as $availability) {

                $weekday = [];
                if(!$availability['state']) {
                    continue;
                }
                if(empty($takenTime[$availability['weekday']])) {
                    for ($i = $start; $i <= $end; $i = $i + 15 * 60) {
                        $time = date('H:i:s', $i);
                        array_push($weekday, $time);
                    }
                    $takenTime[$availability['weekday']] = $weekday;
                }
                if(empty($lowestTime)) {
                    $lowestTime = $availability['start_time'];
                } else {
                    if(strtotime($availability['start_time']) < strtotime($lowestTime)) {
                        $lowestTime = $availability['start_time'];
                    }
                }

                if(empty($highestTime)) {
                    $highestTime = $availability['end_time'];
                } else {
                    if(strtotime($availability['end_time']) > strtotime($highestTime)) {
                        $highestTime = $availability['end_time'];
                    }
                }
                foreach($takenTime[$availability['weekday']] as $key => $day) {
                    if(strtotime($day) >= strtotime($availability['start_time']) && strtotime($day) <= strtotime($availability['end_time'])) {
                        unset($takenTime[$availability['weekday']][$key]);

                    }
                }
            }
        }

        return response()->json([
           'availability'   => $userAvailability['data'] ?? [],
           'takenTime'      => $takenTime,
           'lowestTime'     => $lowestTime != '00:00:00' ? date('H:i', strtotime("-15 minutes", strtotime($lowestTime))) : date('H:i', strtotime($lowestTime)),
           'highestTime'    => $highestTime != '00:00:00' ? date('H:i', strtotime("+15 minutes", strtotime($highestTime))) : date('H:i', strtotime($highestTime)),
        ]);
    }

}
