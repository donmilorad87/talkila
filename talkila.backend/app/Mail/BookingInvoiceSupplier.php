<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

class BookingInvoiceSupplier extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Email language.
     */
    public $language;

    /**
     * Booking.
     */
    public $booking;

    /**
     * Talk Teacher.
     */
    public $teacher;

    /**
     * Talk Student.
     */
    public $student;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($language, $booking, $teacher, $student)
    {
        $this->language = $language;
        $this->booking  = $booking;
        $this->teacher  = $teacher;
        $this->student  = $student;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address    = 'mail@talkila.com';
        $subject    = __('SUBJECT_BOOKING_INVOICE_CLIENT', ['talk' => $this->booking->talk->headline]);
        $name       = 'Talkila';
        $bookingUrl = config('app.frontend_url') . '/bookings/' . $this->booking->id;
        $mentorUrl  = config('app.frontend_url') . '/' . $this->teacher->username;
        $courseUrl  = config('app.frontend_url') . '/booking-summary/' . $this->booking->id;
        $message    = $this->getMessage($bookingUrl, $mentorUrl, $courseUrl);

        EmailHistoriesLogController::createHistoryEmailLog($this->teacher->email, $subject, $message);

        return $this->markdown('emails.booking_invoice_teacher')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'username_mentor' => $this->student->name,
                'course_name'     => $this->booking->talk->headline,
                'price'           => $this->booking->talk->price,
                'teacher_billing' => $this->teacher->billing,
                'vat'             => $this->booking->vat,
                'bookingUrl'      => $bookingUrl,
                'mentorUrl'       => $mentorUrl,
                'courseUrl'       => $courseUrl,
            ]);
    }

    public function getMessage($bookingUrl, $mentorUrl, $courseUrl)
    {
        $markdown = Container::getInstance()->make(Markdown::class);


        $html = $markdown->render('emails.booking_invoice_teacher', [
            'username_mentor' => $this->student->name,
            'course_name'     => $this->booking->talk->headline,
            'price'           => $this->booking->talk->price,
            'teacher_billing' => $this->teacher->billing,
            'vat'             => $this->booking->vat,
            'bookingUrl'      => $bookingUrl,
            'mentorUrl'       => $mentorUrl,
            'courseUrl'       => $courseUrl,
        ]);

        return $html;
    }
}
