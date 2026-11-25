<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

class JtcIntroduction extends Mailable
{
    use Queueable, SerializesModels;

    public $requested_email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($requested_email)
    {
        $this->requested_email      = $requested_email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address    = 'mail@talkila.com';
        $subject    = __('JTC_INTRODUCTION_SUBJECT');
        $name       = 'Talkila';
        $message    = $this->getMessage();

        EmailHistoriesLogController::createHistoryEmailLog($this->requested_email, $subject, $message);

        return $this->markdown('emails.jtc_introduction')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'requested_email'       => $this->requested_email,
                'jtc_route'             => route('api.jtc_availabilities'),
            ]);
    }

    public function getMessage($courseType = null, $bookingUrl = null)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html = $markdown->render('emails.jtc_introduction', [
            'requested_email'       => $this->requested_email,
            'jtc_route'             => route('api.jtc_availabilities'),
        ]);

        return $html;
    }
}
