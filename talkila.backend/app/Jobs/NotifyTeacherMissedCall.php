<?php

namespace App\Jobs;

use App\Models\Booking;
use App\Models\HelperModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyTeacherMissedCall implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $bookingId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($bookingId)
    {
        $this->bookingId = $bookingId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Query the Booking.
        $booking = Booking::find($this->bookingId);

        // Get the Teacher/Supplier from the Booking.
        $user = $booking->teacher_user;

        // If the User exists, set app localization to users' last language.
        if ($user) {
            app()->setLocale($user->last_language);
        }

        $data = [
            'bookingId' => $this->bookingId,
            'type'      => __('NOTIFICATION_SUPPLIER_MISSED_TALK'),
            'value'     => $this->bookingId,
        ];

        HelperModel::sendPushNotification($data);
    }
}
