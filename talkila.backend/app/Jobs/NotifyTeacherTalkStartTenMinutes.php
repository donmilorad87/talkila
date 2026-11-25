<?php

namespace App\Jobs;

use App\Models\HelperModel;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyTeacherTalkStartTenMinutes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string|int Supplier ID.
     */
    protected $supplierId;

    /**
     * @var string Talk name.
     */
    protected string $talkName;

    /**
     * @var string|double Talk price.
     */
    private $talkPrice;

    /**
     * @var string|int Talk duration.
     */
    private $talkDuration;


    /**
     * Create a new job instance.
     *
     * @param $supplierId
     * @param $talkName
     * @param $talkPrice
     * @param $talkDuration
     */
    public function __construct($supplierId, $talkName, $talkPrice, $talkDuration)
    {
        $this->supplierId   = $supplierId;
        $this->talkName     = $talkName;
        $this->talkPrice    = $talkPrice;
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
        $user = User::find($this->supplierId);

        // If the User exists, set app localization to users' last language.
        if ($user) {
            app()->setLocale($user->last_language);
        }

        $data = [
            'user_id'            => $this->supplierId,
            'notification_value' => $this->supplierId,
            'type'               => __('NOTIFICATION_TALK_START_IN_10_MINUTES'),
            'notification_title' => __('NOTIFICATION_SUPPLIER_TALK_START_IN_10_MINUTES_TITLE'),
            'notification_body'  => __('NOTIFICATION_SUPPLIER_TALK_START_IN_10_MINUTES_BODY', [
                'talkName'     => $this->talkName,
                'talkPrice'    => $this->talkPrice,
                'talkDuration' => $this->talkDuration,
            ]),
        ];

        HelperModel::sendPushNotification($data);
    }
}
