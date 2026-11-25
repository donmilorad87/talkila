<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

/**
 * Class BookingCancellationClient
 * @package App\Mail
 */
class TalkSupplierDoesntShow extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $email_mentor;
    public $talk_name;
    public $date;
    public $start_time;
    public $type;
    public $price;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email_mentor, $talk_name, $date, $start_time, $type, $price)
    {
        $this->email_mentor = $email_mentor;
        $this->talk_name    = $talk_name;
        $this->date         = $date;
        $this->start_time   = $start_time;
        $this->type         = $type;
        $this->price        = $price;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'mail@talkila.com';
        $subject = __('SUPPLIER_DONT_SHOW_SUBJECT');

        $name = 'Talkila';

        $bookingsUrl = config('app.frontend_url') . '/bookings';

        $message = $this->getMessage($bookingsUrl);

        EmailHistoriesLogController::createHistoryEmailLog($this->email_mentor, $subject, $message);

        return $this->markdown('emails.talk_supplier_dont_show')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'bookingsUrl' => $bookingsUrl,
                'talk_name'   => $this->talk_name,
                'date'        => $this->date,
                'type'        => $this->type,
                'price'       => $this->price,
            ]);
    }

    public function getMessage($bookingsUrl = null)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html     = $markdown->render('emails.talk_supplier_dont_show', [
            'bookingsUrl' => $bookingsUrl,
            'talk_name'   => $this->talk_name,
            'date'        => $this->date,
            'type'        => $this->type,
            'price'       => $this->price,
        ]);

        return $html;
    }
}
