<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

class BookingRefundedTalkClient extends Mailable
{
    use Queueable, SerializesModels;

    public $language;
    public $email_mentor;
    public $username_mentor;
    public $course_name;
    public $booking_start_date;
    public $booking_start_time;
    public $booking_end_time;
    public $course_duration;
    public $price;
    public $course_type;
    public $booking_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($language, $email_mentor, $username_mentor, $course_name, $booking_start_date, $booking_start_time, $booking_end_time, $course_duration, $price, $course_type, $booking_id)
    {
        $this->language           = $language;
        $this->email_mentor       = $email_mentor;
        $this->username_mentor    = $username_mentor;
        $this->course_name        = $course_name;
        $this->booking_start_date = $booking_start_date;
        $this->booking_start_time = $booking_start_time;
        $this->booking_end_time   = $booking_end_time;
        $this->course_duration    = $course_duration;
        $this->price              = $price;
        $this->course_type        = $course_type;
        $this->booking_id         = $booking_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address    = 'mail@talkila.com';
        $subject    = __('BOOKING_REFUNDED_TALK_CLIENT_SUBJECT');
        $name       = 'Talkila';
        $bookingUrl = config('app.frontend_url') . '/booking/' . $this->booking_id;
        $message    = $this->getMessage($bookingUrl);


        EmailHistoriesLogController::createHistoryEmailLog($this->email_mentor, $subject, $message);

        return $this->markdown('emails.booking_refunded_client')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'username_mentor'    => $this->username_mentor,
                'course_name'        => $this->course_name,
                'booking_start_date' => $this->booking_start_date,
                'booking_start_time' => $this->booking_start_time,
                'booking_end_time'   => $this->booking_end_time,
                'course_duration'    => $this->course_duration,
                'price'              => $this->price,
                'course_type'        => $this->course_type,
                'bookingUrl'         => $bookingUrl,
            ]);
    }

    public function getMessage($bookingUrl = null)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html     = $markdown->render('emails.booking_refunded_client', [
            'username_mentor'    => $this->username_mentor,
            'course_name'        => $this->course_name,
            'booking_start_date' => $this->booking_start_date,
            'booking_start_time' => $this->booking_start_time,
            'booking_end_time'   => $this->booking_end_time,
            'course_duration'    => $this->course_duration,
            'price'              => $this->price,
            'course_type'        => $this->course_type,
            'bookingUrl'         => $bookingUrl,
        ]);

        return $html;
    }
}
