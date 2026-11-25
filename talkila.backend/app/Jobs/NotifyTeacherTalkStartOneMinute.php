<?php

namespace App\Jobs;

use App\Models\HelperModel;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyTeacherTalkStartOneMinute implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string|int Supplier ID.
     */
    protected $supplierId;

    /**
     * @var string Talk name.
     */
    private string $talkName;

    /**
     * Create a new job instance.
     *
     * @param $supplierId
     * @param $talkName
     */
    public function __construct($supplierId, $talkName)
    {
        $this->supplierId = $supplierId;
        $this->talkName   = $talkName;
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
            'type'               => __('NOTIFICATION_TALK_START_IN_1_MINUTES'),
            'notification_title' => __('NOTIFICATION_SUPPLIER_TALK_START_IN_1_MINUTES_TITLE'),
            'notification_body'  => __('NOTIFICATION_SUPPLIER_TALK_START_IN_1_MINUTES_BODY', [
                'talkName' => $this->talkName,
            ]),
        ];

        HelperModel::sendPushNotification($data);
    }
}
