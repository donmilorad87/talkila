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

class NotifyTeacherTalkPostpond implements ShouldQueue
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
     * @var string Initial Talk date.
     */
    protected $talkDateOld;

    /**
     * @var string Initial Talk time.
     */
    protected $talkTimeOld;

    /**
     * @var string New Talk date.
     */
    protected $talkDateNew;

    /**
     * @var string New Talk time.
     */
    protected $talkTimeNew;

    /**
     * Create a new job instance.
     *
     * @param $supplierId
     * @param $bookingId
     * @param $talkName
     * @param $talkDateOld
     * @param $talkTimeOld
     * @param $talkDateNew
     * @param $talkTimeNew
     */
    public function __construct($supplierId, $bookingId, $talkName, $talkDateOld, $talkTimeOld, $talkDateNew, $talkTimeNew)
    {
        $this->supplierId  = $supplierId;
        $this->bookingId   = $bookingId;
        $this->talkName    = $talkName;
        $this->talkDateOld = $talkDateOld;
        $this->talkTimeOld = $talkTimeOld;
        $this->talkDateNew = $talkDateNew;
        $this->talkTimeNew = $talkTimeNew;
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
            'action'             => Notifications::VALUE['booking_postponed'],
            'type'               => __('NOTIFICATION_TALK_POSTPONED_BY_CLIENT', [
                'talkName' => $this->talkName,
            ]),
            'notification_title' => __('NOTIFICATION_TALK_POSTPONED_BY_CLIENT_TITLE', [
                'talkName' => $this->talkName,
            ]),
            'notification_body'  => __('NOTIFICATION_TALK_POSTPONED_BY_CLIENT_BODY', [
                'talkDateOld' => $this->talkDateOld,
                'talkTimeOld' => $this->talkTimeOld,
                'talkDateNew' => $this->talkDateNew,
                'talkTimeNew' => $this->talkTimeNew,
            ]),
        ];

        HelperModel::sendPushNotification($data);
    }
}