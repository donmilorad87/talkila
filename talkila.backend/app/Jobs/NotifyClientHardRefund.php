<?php

namespace App\Jobs;

use App\Models\HelperModel;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyClientHardRefund implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string|int Client ID
     */
    protected $clientId;

    /**
     * @var string Talk name.
     */
    protected string $talkName;

    /**
     * @var string Talk refund date.
     */
    protected string $talkDate;

    /**
     * @var string Talk refund time.
     */
    protected string $talkTime;

    /**
     * Create a new job instance.
     *
     * @param $clientId
     * @param $talkName
     * @param $talkDate
     * @param $talkTime
     */
    public function __construct($clientId, $talkName, $talkDate, $talkTime)
    {
        $this->clientId = $clientId;
        $this->talkName = $talkName;
        $this->talkDate = $talkDate;
        $this->talkTime = $talkTime;
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
            'type'               => 'NOTIFICATION_CLIENT_HARD_REFUND',
            'notification_title' => __('NOTIFICATION_CLIENT_HARD_REFUND_TITLE'),
            'notification_body'  => __('NOTIFICATION_CLIENT_HARD_REFUND_BODY', [
                'talkName' => $this->talkName,
                'talkDate' => $this->talkDate,
                'talkTime' => $this->talkTime,
            ]),
        ];

        HelperModel::sendPushNotification($data);
    }
}
