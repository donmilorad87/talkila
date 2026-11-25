<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

/**
 * Class AccountBlocked
 * @package App\Mail
 */
class AccountDeleted extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * @var
     */
    public $recipient;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($recipient)
    {
        $this->recipient    = $recipient;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address    = 'mail@talkila.com';
        $subject    = __('ACCOUNT_DELETED_SUBJECT');
        $name       = 'Talkila';
        $message    = $this->getMessage();

        EmailHistoriesLogController::createHistoryEmailLog($this->recipient->email, $subject, $message);

        return $this->markdown('emails.account_deleted')
            ->from($address, $name)
            ->subject($subject);
    }

    public function getMessage()
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html = $markdown->render('emails.account_deleted', []);

        return $html;
    }
}
