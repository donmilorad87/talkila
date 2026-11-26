<?php


namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Api\V1\Admin\NotificationsApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{

    public function settingsNotifications(Request $request)
    {

        if (empty($request->input('offset'))) {
            $request->request->add(['offset' => 0]);
        }

        if (empty($request->input('limit'))) {
            $request->request->add(['limit' => config('app.default_notifications_count_show_more')]);
        }

        $notificationsDataObject = new NotificationsApiController();
        $notificationsData = $notificationsDataObject->getNotifications($request)->getData(true);

        $haveRedirects = ['101', '102', '103', '104', '105', '111' , '201', '202', '302', '401', '402', '501', '502', '503', '504', '601', '602', '701', '702', '703', '704', '801'];

        if($request->ajax()) {
            return [
                'html' => view('frontend.partials.pages.setting._teacher_notifications', [
                    'haveRedirects'     => $haveRedirects,
                    'notificationsData' => $notificationsData['data'] ?? [],
                ])->render(),
                'success' => true
            ];
        }

        return view('frontend.pages.settings_notifications', [
            'page_name'          => __('SETTINGS'),
            'haveRedirects'      => $haveRedirects,
            'notificationsData'  => $notificationsData['data'] ?? []
        ]);
    }

    public function redirectNotification(Request $request)
    {
        $tokenType      = session('token_type');
        $accessToken    = session('access_token');
        $item = $request->input('notification');

        if($item['values'] == '101' ||
            $item['values'] == '102' ||
            $item['values'] == '103' ||
            $item['values'] == '104' ||
            $item['values'] == '105' ||
            $item['values'] == '111' ||
            $item['values'] == '504'
        ) {
            return redirect()->route('booking_details', $item['payload']['name_of_talk_id']);

        } elseif($item['values'] == '201' || $item['values'] == '503') {
            $user = Http::withHeaders([
                'Accept'                => 'application/json',
                'Authorization'         => "$tokenType $accessToken",
                'Application-Language'  => strtolower(App::getLocale())

            ])->get(config('app.appBackendServerUrl', '') . '/users/' . $item['payload']['username_of_teacher_id'], [

            ]);

            if($user->json()['success']) {
                return redirect()->route('profile', $user->json()['data']['user']['username']);
            }

        } elseif($item['values'] == '202' || $item['values'] == '501' || $item['values'] == '502' || $item['values'] == '601' || $item['values'] == '602') {
            return redirect()->route('book_slot', $item['payload']['name_of_talk_id']);


        } elseif($item['values'] == '302') {
            return redirect()->route('home');

        } elseif($item['values'] == '401') {
            return redirect()->route('jtc_welcome');

        }  elseif($item['values'] == '402') {
            return redirect()->route('account_verification');

        } elseif($item['values'] == '701') {
            return redirect()->route('settings_profile');
        } elseif($item['values'] == '702') {
            return redirect()->route('settings_profile');
        } elseif($item['values'] == '703') {
            return redirect()->route('settings_profile');
        } elseif($item['values'] == '704') {
            return redirect()->route('settings_profile');
        } elseif($item['values'] == '801') {
            return redirect()->route('settings_transaction_history');
        }
    }

}
