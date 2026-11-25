<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

class JtcWelcome extends Mailable
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
        $this->requested_email = $requested_email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'mail@talkila.com';
        $subject = __('JTC_WELCOME_SUBJECT');
        $name    = 'Talkila';
        $jtcUrl  = config('app.frontend_url') . '/jtc/welcome';
        $message = $this->getMessage($jtcUrl);

        EmailHistoriesLogController::createHistoryEmailLog($this->requested_email, $subject, $message);

        return $this->markdown('emails.jtc_welcome')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'requested_email' => $this->requested_email,
                'jtcUrl'          => $jtcUrl,
            ]);
    }

    public function getMessage($jtcUrl)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html     = $markdown->render('emails.jtc_welcome', [
            'requested_email' => $this->requested_email,
            'jtcUrl'          => $jtcUrl,
        ]);

        return $html;
    }
}
