<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

class BookingPostponedSupplier extends Mailable
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
    public $original_booking_start_date;
    public $original_booking_start_time;
    public $original_booking_end_time;
    public $original_duration;
    public $anonym;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($language, $email_mentor, $username_mentor, $course_name, $booking_start_date, $booking_start_time, $booking_end_time, $course_duration, $price, $course_type, $booking_id, $original_booking_start_date, $original_booking_start_time, $original_booking_end_time, $anonym, $original_duration)
    {
        $this->language                    = $language;
        $this->email_mentor                = $email_mentor;
        $this->username_mentor             = $username_mentor;
        $this->course_name                 = $course_name;
        $this->booking_start_date          = $booking_start_date;
        $this->booking_start_time          = $booking_start_time;
        $this->booking_end_time            = $booking_end_time;
        $this->course_duration             = $course_duration;
        $this->price                       = $price;
        $this->course_type                 = $course_type;
        $this->booking_id                  = $booking_id;
        $this->original_booking_start_date = $original_booking_start_date;
        $this->original_booking_start_time = $original_booking_start_time;
        $this->original_booking_end_time   = $original_booking_end_time;
        $this->original_duration           = $original_duration;
        $this->anonym                      = $anonym;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        app()->setLocale($this->language);

        $address     = 'mail@talkila.com';
        $subject     = __('BOOKING_POSTPONED_SUPPLIER_SUBJECT');
        $name        = 'Talkila';
        $bookingUrl  = config('app.frontend_url') . '/booking/' . $this->booking_id;
        $anonymState = $this->anonym == 1 ? 'Yes' : 'No';
        $message     = $this->getMessage($bookingUrl, $anonymState);

        EmailHistoriesLogController::createHistoryEmailLog($this->email_mentor, $subject, $message);

        return $this->markdown('emails.booking_postponed_teacher')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'username_mentor'             => $this->username_mentor,
                'course_name'                 => $this->course_name,
                'booking_start_date'          => $this->booking_start_date,
                'booking_start_time'          => $this->booking_start_time,
                'booking_end_time'            => $this->booking_end_time,
                'course_duration'             => $this->course_duration,
                'price'                       => $this->price,
                'course_type'                 => $this->course_type,
                'bookingUrl'                  => $bookingUrl,
                'original_booking_start_date' => $this->original_booking_start_date,
                'original_booking_start_time' => $this->original_booking_start_time,
                'original_booking_end_time'   => $this->original_booking_end_time,
                'original_duration'           => $this->original_duration,
                'anonym'                      => $anonymState,
            ]);
    }

    public function getMessage($bookingUrl = null, $anonymState = null)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html     = $markdown->render('emails.booking_postponed_teacher', [
            'username_mentor'             => $this->username_mentor,
            'course_name'                 => $this->course_name,
            'booking_start_date'          => $this->booking_start_date,
            'booking_start_time'          => $this->booking_start_time,
            'booking_end_time'            => $this->booking_end_time,
            'course_duration'             => $this->course_duration,
            'price'                       => $this->price,
            'course_type'                 => $this->course_type,
            'bookingUrl'                  => $bookingUrl,
            'original_booking_start_date' => $this->original_booking_start_date,
            'original_booking_start_time' => $this->original_booking_start_time,
            'original_booking_end_time'   => $this->original_booking_end_time,
            'original_duration'           => $this->original_duration,
            'anonym'                      => $anonymState,
        ]);

        return $html;
    }
}
