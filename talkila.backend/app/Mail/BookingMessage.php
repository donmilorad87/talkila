<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

class BookingMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $language;
    public $teacher_name;
    public $student_name;
    public $talk_headline;
    public $booking_start_call;
    public $booking_end_call;
    public $booking_url;
    public $booking_message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($language, $teacher_name, $student_name, $talk_headline, $booking_start_call, $booking_end_call, $booking_url, $booking_message)
    {
        $this->language           = $language;
        $this->teacher_name       = $teacher_name;
        $this->student_name       = $student_name;
        $this->talk_headline      = $talk_headline;
        $this->booking_start_call = $booking_start_call;
        $this->booking_end_call   = $booking_end_call;
        $this->booking_url        = $booking_url;
        $this->booking_message    = $booking_message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        app()->setLocale($this->language);

        $address = 'mail@talkila.com';
        $subject = __('BOOKING_MESSAGE_SUBJECT');
        $name    = 'Talkila';
        $message = $this->getMessage();

        EmailHistoriesLogController::createHistoryEmailLog($this->teacher_name, $subject, $message);

        return $this->markdown('emails.booking_message')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'teacher_name'       => $this->teacher_name,
                'student_name'       => $this->student_name,
                'talk_headline'      => $this->talk_headline,
                'booking_start_call' => $this->booking_start_call,
                'booking_end_call'   => $this->booking_end_call,
                'booking_url'        => $this->booking_url,
                'booking_message'    => $this->booking_message,
            ]);
    }

    public function getMessage($courseType = null, $bookingUrl = null)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html     = $markdown->render('emails.booking_message', [
            'teacher_name'       => $this->teacher_name,
            'student_name'       => $this->student_name,
            'talk_headline'      => $this->talk_headline,
            'booking_start_call' => $this->booking_start_call,
            'booking_end_call'   => $this->booking_end_call,
            'booking_url'        => $this->booking_url,
            'booking_message'    => $this->booking_message,
        ]);

        return $html;
    }
}
