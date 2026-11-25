<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

class ClientLeftTalk extends Mailable
{
    use Queueable, SerializesModels;

    public $language;
    public $email_mentor;
    public $username_mentor;
    public $course_id;
    public $talk_name;
    public $reason;
    public $badReview;
    public $booking_start_date;
    public $booking_start_time;
    public $booking_end_time;
    public $booked_minutes;
    public $supplier_enter_time;
    public $supplier_exit_time;
    public $supplier_minutes;
    public $client_enter_date;
    public $client_exit_time;
    public $client_minutes;
    public $supplier_login_type;
    public $client_login_type;
    public $course_type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($language, $email_mentor, $username_mentor, $course_id, $talk_name, $reason, $badReview, $booking_start_date, $booking_start_time, $booking_end_time, $booked_minutes, $supplier_enter_time, $supplier_exit_time, $supplier_minutes, $client_enter_date, $client_exit_time, $client_minutes, $supplier_login_type, $client_login_type, $course_type)
    {
        $this->language            = $language;
        $this->email_mentor        = $email_mentor;
        $this->username_mentor     = $username_mentor;
        $this->course_id           = $course_id;
        $this->talk_name           = $talk_name;
        $this->reason              = $reason;
        $this->badReview           = $badReview;
        $this->booking_start_date  = $booking_start_date;
        $this->booking_start_time  = $booking_start_time;
        $this->booking_end_time    = $booking_end_time;
        $this->booked_minutes      = $booked_minutes;
        $this->supplier_enter_time = $supplier_enter_time;
        $this->supplier_exit_time  = $supplier_exit_time;
        $this->supplier_minutes    = $supplier_minutes;
        $this->client_enter_date   = $client_enter_date;
        $this->client_exit_time    = $client_exit_time;
        $this->client_minutes      = $client_minutes;
        $this->supplier_login_type = $supplier_login_type;
        $this->client_login_type   = $client_login_type;
        $this->course_type         = $course_type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address     = 'mail@talkila.com';
        $subject     = __('CLIENT_LEFT_TALK_SUBJECT', ['talk_name' => $this->talk_name]);
        $name        = 'Talkila';
        $bookingsUrl = config('app.frontend_url') . '/bookings';
        $mentorUrl   = config('app.frontend_url') . '/' . $this->username_mentor;
        $courseUrl   = config('app.frontend_url') . '/booking-summary/' . $this->course_id;

        $message = $this->getMessage($bookingsUrl, $mentorUrl, $courseUrl);

        EmailHistoriesLogController::createHistoryEmailLog($this->email_mentor, $subject, $message);

        return $this->markdown('emails.client_left_talk')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'username_mentor'     => $this->username_mentor,
                'talk_name'           => $this->talk_name,
                'reason'              => $this->reason,
                'badReview'           => $this->badReview,
                'booking_start_date'  => $this->booking_start_date,
                'booking_start_time'  => $this->booking_start_time,
                'booking_end_time'    => $this->booking_end_time,
                'booked_minutes'      => $this->booked_minutes,
                'supplier_enter_time' => $this->supplier_enter_time,
                'supplier_exit_time'  => $this->supplier_exit_time,
                'supplier_minutes'    => $this->supplier_minutes,
                'client_enter_date'   => $this->client_enter_date,
                'client_exit_time'    => $this->client_exit_time,
                'client_minutes'      => $this->client_minutes,
                'supplier_login_type' => $this->supplier_login_type,
                'client_login_type'   => $this->client_login_type,
                'course_type'         => $this->course_type,
                'bookingsUrl'         => $bookingsUrl,
                'mentorUrl'           => $mentorUrl,
                'courseUrl'           => $courseUrl,
            ]);
    }

    public function getMessage($bookingsUrl, $mentorUrl, $courseUrl)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html     = $markdown->render('emails.client_left_talk', [
            'username_mentor'     => $this->username_mentor,
            'talk_name'           => $this->talk_name,
            'reason'              => $this->reason,
            'badReview'           => $this->badReview,
            'booking_start_date'  => $this->booking_start_date,
            'booking_start_time'  => $this->booking_start_time,
            'booking_end_time'    => $this->booking_end_time,
            'booked_minutes'      => $this->booked_minutes,
            'supplier_enter_time' => $this->supplier_enter_time,
            'supplier_exit_time'  => $this->supplier_exit_time,
            'supplier_minutes'    => $this->supplier_minutes,
            'client_enter_date'   => $this->client_enter_date,
            'client_exit_time'    => $this->client_exit_time,
            'client_minutes'      => $this->client_minutes,
            'supplier_login_type' => $this->supplier_login_type,
            'client_login_type'   => $this->client_login_type,
            'course_type'         => $this->course_type,
            'bookingsUrl'         => $bookingsUrl,
            'mentorUrl'           => $mentorUrl,
            'courseUrl'           => $courseUrl,
        ]);

        return $html;
    }
}
