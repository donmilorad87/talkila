<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

/**
 * Class AccountActivation
 * @package App\Mail
 */
class AccountActivation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $language;
    /**
     * @var
     */
    public $send_email;
    /**
     * @var
     */
    public $username;
    /**
     * @var
     */
    public $activation_link;
    /**
     * @var
     */
    public $created_at;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($language, $send_email, $username,  $activation_link, $created_at)
    {
        $this->language         = $language;
        $this->send_email       = $send_email;
        $this->username         = $username;
        $this->activation_link  = $activation_link;
        $this->created_at       = $created_at;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address    = 'mail@talkila.com';
        $subject    = __('ACCOUNT_ACTIVATION_SUBJECT');
        $name       = 'Talkila';
        $message    = $this->getMessage();

        EmailHistoriesLogController::createHistoryEmailLog($this->send_email, $subject, $message);

        return $this->markdown('emails.account_activation')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'language'          => $this->language,
                'send_email'        => $this->send_email,
                'username'          => $this->username,
                'activation_link'   => $this->activation_link,
                'created_at'        => $this->created_at
            ]);
    }

    public function getMessage($courseType = null, $bookingUrl = null)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html = $markdown->render('emails.account_activation', [
            'language'          => $this->language,
            'send_email'        => $this->send_email,
            'username'          => $this->username,
            'activation_link'   => $this->activation_link,
            'created_at'        => $this->created_at
        ]);

        return $html;
    }
}
