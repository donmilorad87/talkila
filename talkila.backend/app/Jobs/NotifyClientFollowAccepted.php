<?php

namespace App\Jobs;

use App\Models\HelperModel;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyClientFollowAccepted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $client_id;

    /**
     * Create a new job instance.
     *
     * @param $client_id
     * @return void
     */
    public function __construct($client_id)
    {
        $this->client_id = $client_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Query the User.
        $user = User::find($this->client_id);

        // If the User exists, set app localization to users' last language.
        if ($user) {
            app()->setLocale($user->last_language);
        }

        $data = [
            'user_id'               => $this->client_id ,
            'notification_value'    => $this->client_id,
            'type'                  => 'NOTIFICATION_CLIENT_FOLLOW_ACCEPTED_TYPE',
            'notification_title'    => __('NOTIFICATION_CLIENT_FOLLOW_ACCEPTED_TITLE'),
            'notification_body'     => __('NOTIFICATION_CLIENT_FOLLOW_ACCEPTED_BODY'),
        ];

        HelperModel::sendPushNotification($data);
    }
}
