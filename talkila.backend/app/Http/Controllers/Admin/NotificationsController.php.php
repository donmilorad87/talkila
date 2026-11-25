<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationsController extends Controller
{
    public function sendNotification(Request $request)
    {
        try {
            $request->input('type');

            if ($request->input('type') == 1) {
                $value = $request->input('custom_message');
            } else {
                $value = $request->input('type');
            }

            $newNotification            = new Notifications;
            $newNotification->users_id  = $request->user()->id;
            $newNotification->type      = $request->input('type');
            $newNotification->values    = $value;
            $newNotification->pushed_at = date('Y-m-d');
            $newNotification->state     = 1;
            $newNotification->save();

            return view('admin.pages.index');

        } catch (\Exception $exception) {
            Log::error(var_export($exception, true));

            return response()->json([
                'message'   => 'Request failed',
                'success'   => false
            ], 500);
        }
    }
}
