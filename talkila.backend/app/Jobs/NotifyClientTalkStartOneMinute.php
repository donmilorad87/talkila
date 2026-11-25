<?php

namespace App\Jobs;

use App\Models\HelperModel;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyClientTalkStartOneMinute implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string|int Client ID.
     */
    protected $clientId;

    /**
     * @var string Supplier username.
     */
    protected string $supplierUsername;

    /**
     * Create a new job instance.
     *
     * @param $clientId
     * @param $supplierUsername
     */
    public function __construct($clientId, $supplierUsername)
    {
        $this->clientId         = $clientId;
        $this->supplierUsername = $supplierUsername;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Query the User.
        $user = User::find($this->clientId);

        // If the User exists, set app localization to users' last language.
        if ($user) {
            app()->setLocale($user->last_language);
        }

        $data = [
            'user_id'            => $this->clientId,
            'notification_value' => $this->clientId,
            'type'               => __('NOTIFICATION_TALK_START_IN_1_MINUTES'),
            'notification_title' => __('NOTIFICATION_CLIENT_TALK_START_IN_1_MINUTES_TITLE'),
            'notification_body'  => __('NOTIFICATION_CLIENT_TALK_START_IN_1_MINUTES_BODY', [
                'talkSupplier' => $this->supplierUsername,
            ]),
        ];

        HelperModel::sendPushNotification($data);
    }
}
