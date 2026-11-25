<?php

namespace App\Jobs;

use App\Models\HelperModel;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyClientTalkStartTenMinutes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string|int Client ID.
     */
    protected $clientId;

    /**
     * @var string Talk name.
     */
    protected string $talkName;

    /**
     * @var string|double Talk start time.
     */
    protected $talkTime;

    /**
     * @var string|int Talk duration.
     */
    protected string $talkDuration;

    /**
     * Create a new job instance.
     *
     * @param $clientId
     * @param $talkName
     * @param $talkTime
     * @param $talkDuration
     */
    public function __construct($clientId, $talkName, $talkTime, $talkDuration)
    {
        $this->clientId     = $clientId;
        $this->talkName     = $talkName;
        $this->talkTime     = $talkTime;
        $this->talkDuration = $talkDuration;
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
            'type'               => __('NOTIFICATION_TALK_START_IN_10_MINUTES'),
            'notification_title' => __('NOTIFICATION_CLIENT_TALK_START_IN_10_MINUTES_TITLE'),
            'notification_body'  => __('NOTIFICATION_CLIENT_TALK_START_IN_10_MINUTES_BODY', [
                'talkName'     => $this->talkName,
                'talkTime'     => $this->talkTime,
                'talkDuration' => $this->talkDuration,
            ]),
        ];

        HelperModel::sendPushNotification($data);
    }
}
