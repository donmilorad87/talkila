<?php

namespace App\Jobs;

use App\Models\Booking;
use App\Models\HelperModel;
use App\Models\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyTeacherTalkBooked implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string|int Booking ID.
     */
    protected $bookingId;

    /**
     * @var string Talk name.
     */
    protected $talkName;

    /**
     * @var string Talk booking date.
     */
    protected $talkDate;

    /**
     * @var string Talk booking time.
     */
    protected $talkTime;

    /**
     * Create a new job instance.
     *
     * @param $bookingId
     * @param $talkName
     * @param $talkDate
     * @param $talkTime
     */
    public function __construct($bookingId, $talkName, $talkDate, $talkTime)
    {
        $this->bookingId = $bookingId;
        $this->talkName  = $talkName;
        $this->talkDate  = $talkDate;
        $this->talkTime  = $talkTime;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Query the Booking.
        $booking = Booking::query()->find($this->bookingId);

        // Query the User.
        $user = $booking->teacher_user;

        // If the User exists, set app localization to users' last language.
        if ($user) {
            app()->setLocale($user->last_language);
        }

        $data = [
            'user_id'            => $booking->teacher_user_id,
            'notification_value' => $this->bookingId,
            'action'             => Notifications::VALUE['new_booking'],
            'type'               => __('NOTIFICATION_TALK_BOOKED_BY_CLIENT', [
                'talkName' => $this->talkName,
            ]),
            'notification_title' => __('SUPPLIER_TALK_BOOKED_TITLE', [
                'talkName' => $this->talkName,
            ]),
            'notification_body'  => __('SUPPLIER_TALK_BOOKED_BODY', [
                'talkName' => $this->talkName,
                'talkDate' => $this->talkDate,
                'talkTime' => $this->talkTime,
            ]),
        ];

        HelperModel::sendPushNotification($data);
    }
}