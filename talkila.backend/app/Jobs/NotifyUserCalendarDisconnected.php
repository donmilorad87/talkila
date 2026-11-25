<?php

namespace App\Jobs;

use App\Models\HelperModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyUserCalendarDisconnected implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Set app localization to users' last language.
        app()->setLocale($this->user->last_language);

        $data = [
            'user_id'            => $this->user->id,
            'notification_value' => $this->user->id,
            'type'               => __('NOTIFICATION_CALENDAR_DISCONNECTED'),
            'notification_title' => __('NOTIFICATION_CLIENT_CALENDAR_DISCONNECTED_TITLE'),
            'notification_body'  => __('NOTIFICATION_CLIENT_CALENDAR_DISCONNECTED_BODY'),
        ];

        HelperModel::sendPushNotification($data);
    }
}
