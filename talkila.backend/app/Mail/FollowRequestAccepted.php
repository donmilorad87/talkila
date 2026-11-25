<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

/**
 * Class WelcomeEmail
 * @package App\Mail
 */
class FollowRequestAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $email;

    public $username;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $username)
    {
        $this->email    = $email;
        $this->username = $username;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'mail@talkila.com';
        $subject = __('FOLLOW_REQUEST_ACCEPTED_SUBJECT', ['username' => $this->username]);
        $name    = 'Talkila';
        $url     = config('app.frontend_url') . '/' . $this->username;
        $message = $this->getMessage($url);

        EmailHistoriesLogController::createHistoryEmailLog($this->email, $subject, $message);

        return $this->markdown('emails.follow_request_accepted')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'username' => $this->username,
                'url'      => $url,
            ]);
    }

    public function getMessage($url)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html     = $markdown->render('emails.follow_request_accepted', [
            'username' => $this->username,
            'url'      => $url,
        ]);

        return $html;
    }
}
