<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNotificationSettingsRequest;
use App\Models\NotificationSettings;
use Illuminate\Http\Request;

class NotificationSettingsController extends Controller
{
    /**
     * A Notification Settings model.
     */
    public NotificationSettings $notification_settings;

    /**
     * Create a new Controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->notification_settings = new NotificationSettings();
    }

    /**
     * Get users' Notification settings.
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        // Get User notification settings.
        $notifications = $request->user()->notificationSettings;

        if (! $notifications) {
            return response()->error([
                'message' => 'Error while getting notification settings.',
            ]);
        }

        return response()->success([
            'message' => 'Notifications Settings.',
            'data'    => [
                'bookings'   => $notifications->bookings,
                'payments'   => $notifications->payments,
                'followings' => $notifications->followings,
                'reviews'    => $notifications->reviews,
                'payouts'    => $notifications->payouts,
            ],
        ]);
    }

    /**
     * Store users' Notification settings.
     *
     * @param  StoreNotificationSettingsRequest  $request
     *
     * @return mixed
     */
    public function store(StoreNotificationSettingsRequest $request)
    {
        $request->user()->storeNotificationSettings($request->validated());

        return response()->success(__('SUCCESSFULLY_UPDATED_NOTIFICATION_SETTINGS'));
    }
}
