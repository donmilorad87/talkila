<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

class BookingConfirmationClient extends Mailable
{
    use Queueable, SerializesModels;

    public $language;
    public $email_client;
    public $username_mentor;
    public $course_id;
    public $course_name;
    public $booking_start_date;
    public $booking_start_time;
    public $booking_end_time;
    public $course_duration;
    public $price;
    public $course_type;
    public $booking_id;
    public $teacher_billing;
    public $vat;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($language, $email_client, $username_mentor, $course_id, $course_name, $booking_start_date, $booking_start_time, $booking_end_time, $course_duration, $price, $course_type, $booking_id, $teacher_billing, $vat)
    {
        $this->language           = $language;
        $this->email_client       = $email_client;
        $this->username_mentor    = $username_mentor;
        $this->course_id          = $course_id;
        $this->course_name        = $course_name;
        $this->booking_start_date = changeDateFormatLocale('Y-m-d H:i:s', getTimeZonedDate('Y-m-d H:i:s', $booking_start_date), true);
        $this->booking_start_time = $booking_start_time;
        $this->booking_end_time   = $booking_end_time;
        $this->course_duration    = $course_duration;
        $this->price              = $price;
        $this->course_type        = $course_type;
        $this->booking_id         = $booking_id;
        $this->teacher_billing    = $teacher_billing;
        $this->vat                = $vat;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        app()->setLocale($this->language);

        $address    = 'mail@talkila.com';
        $subject    = __('SUBJECT_BOOKING_CONFIRMATION_CLIENT');
        $name       = 'Talkila';
        $courseType = $this->course_type;
        $bookingUrl = config('app.frontend_url') . '/booking/' . $this->booking_id;
        $mentorUrl  = config('app.frontend_url') . '/' . $this->username_mentor;
        $courseUrl  = config('app.frontend_url') . '/' . $this->username_mentor . '/talk/' . $this->course_id;
        $message    = $this->getMessage($courseType, $bookingUrl, $mentorUrl, $courseUrl);

        EmailHistoriesLogController::createHistoryEmailLog($this->email_client, $subject, $message);

        return $this->markdown('emails.booking_confirmation_client')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'username_mentor'    => $this->username_mentor,
                'course_name'        => $this->course_name,
                'booking_start_date' => $this->booking_start_date,
                'booking_start_time' => $this->booking_start_time,
                'booking_end_time'   => $this->booking_end_time,
                'timezone'           => getLocalTimeZoneName(),
                'course_duration'    => $this->course_duration,
                'price'              => $this->price,
                'teacher_billing'    => $this->teacher_billing,
                'vat'                => $this->vat,
                'course_type'        => $courseType,
                'bookingUrl'         => $bookingUrl,
                'mentorUrl'          => $mentorUrl,
                'courseUrl'          => $courseUrl,
            ]);
    }

    public function getMessage($courseType, $bookingUrl, $mentorUrl, $courseUrl)
    {
        $markdown = Container::getInstance()->make(Markdown::class);


        $html = $markdown->render('emails.booking_confirmation_client', [
            'username_mentor'    => $this->username_mentor,
            'course_name'        => $this->course_name,
            'booking_start_date' => $this->booking_start_date,
            'booking_start_time' => $this->booking_start_time,
            'booking_end_time'   => $this->booking_end_time,
            'timezone'           => getLocalTimeZoneName(),
            'course_duration'    => $this->course_duration,
            'price'              => $this->price,
            'teacher_billing'    => $this->teacher_billing,
            'vat'                => $this->vat,
            'course_type'        => $courseType,
            'bookingUrl'         => $bookingUrl,
            'mentorUrl'          => $mentorUrl,
            'courseUrl'          => $courseUrl,
        ]);

        return $html;
    }
}
