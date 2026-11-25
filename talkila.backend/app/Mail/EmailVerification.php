<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $language;
    public $requested_email;
    public $name;
    public $my_url;
    public $verificationMessage;
    public $created_request_at;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($language, $requested_email, $name, $my_url, $verificationMessage, $created_request_at)
    {
        $this->language            = $language;
        $this->requested_email     = $requested_email;
        $this->name                = $name;
        $this->my_url              = $my_url;
        $this->verificationMessage = $verificationMessage;
        $this->created_request_at  = $created_request_at;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'mail@talkila.com';
        $subject = __('NEW_EMAIL_VERIFICATION_SUBJECT');
        $name    = 'Talkila';
        $message = $this->getMessage();

        EmailHistoriesLogController::createHistoryEmailLog($this->requested_email, $subject, $message);

        return $this->markdown('emails.new_email_verification')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'language'            => $this->language,
                'requested_email'     => $this->requested_email,
                'name'                => $this->name,
                'my_url'              => $this->my_url,
                'verificationMessage' => $this->verificationMessage,
                'created_request_at'  => $this->created_request_at,
            ]);
    }

    public function getMessage()
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html     = $markdown->render('emails.new_email_verification', [
            'language'            => $this->language,
            'requested_email'     => $this->requested_email,
            'name'                => $this->name,
            'my_url'              => $this->my_url,
            'verificationMessage' => $this->verificationMessage,
            'created_request_at'  => $this->created_request_at,
        ]);

        return $html;
    }
}
