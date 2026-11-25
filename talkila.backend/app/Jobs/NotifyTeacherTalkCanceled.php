<?php

namespace App\Jobs;

use App\Models\HelperModel;
use App\Models\Notifications;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyTeacherTalkCanceled implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string|int Supplier ID.
     */
    protected $supplierId;

    /**
     * @var string|int Booking ID.
     */
    protected $bookingId;

    /**
     * @var string Talk name.
     */
    protected $talkName;

    /**
     * @var string Talk cancellation date.
     */
    protected $talkDate;

    /**
     * @var string Talk cancellation time.
     */
    protected $talkTime;

    /**
     * Create a new job instance.
     *
     * @param $supplierId
     * @param $bookingId
     * @param $talkName
     * @param $talkDate
     * @param $talkTime
     */
    public function __construct($supplierId, $bookingId, $talkName, $talkDate, $talkTime)
    {
        $this->supplierId = $supplierId;
        $this->bookingId  = $bookingId;
        $this->talkName   = $talkName;
        $this->talkDate   = $talkDate;
        $this->talkTime   = $talkTime;
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
            'notification_value' => $this->bookingId,
            'action'             => Notifications::VALUE['canceled_by_supplier'],
            'type'               => __('NOTIFICATION_TALK_CANCELED_BY_CLIENT', [
                'talkName' => $this->talkName,
            ]),
            'notification_title' => __('NOTIFICATION_TALK_CANCELED_BY_CLIENT_TITLE', [
                'talkName' => $this->talkName,
            ]),
            'notification_body'  => __('NOTIFICATION_TALK_CANCELED_BY_CLIENT_BODY', [
                'talkName' => $this->talkName,
                'talkDate' => $this->talkDate,
                'talkTime' => $this->talkTime,
            ]),
        ];

        HelperModel::sendPushNotification($data);
    }
}