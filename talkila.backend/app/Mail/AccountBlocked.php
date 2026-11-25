<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

/**
 * Class AccountBlocked
 * @package App\Mail
 */
class AccountBlocked extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $subject;
    /**
     * @var
     */
    public $recipient;
    /**
     * @var
     */
    public $username;
    /**
     * @var
     */
    public $block_reason;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $recipient, $username, $block_reason)
    {
        $this->subject      = $subject;
        $this->recipient    = $recipient;
        $this->username     = $username;
        $this->block_reason = $block_reason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address    = 'mail@talkila.com';
        $subject    = __('ACCOUNT_BLOCKED_SUBJECT');
        $name       = 'Talkila';
        $message    = $this->getMessage();

        EmailHistoriesLogController::createHistoryEmailLog($this->recipient, $subject, $message);

        return $this->markdown('emails.account_blocked')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'username'      => $this->username,
                'block_reason'  => $this->block_reason
            ]);
    }

    public function getMessage($courseType = null, $bookingUrl = null)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html = $markdown->render('emails.account_blocked', [
            'username'      => $this->username,
            'block_reason'  => $this->block_reason
        ]);

        return $html;
    }
}
