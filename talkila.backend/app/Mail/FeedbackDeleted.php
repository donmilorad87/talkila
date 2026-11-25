<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

class FeedbackDeleted extends Mailable
{
    use Queueable, SerializesModels;

    public $language;
    public $email_client;
    public $reason;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($language, $email_client, $reason)
    {
        $this->language     = $language;
        $this->email_client = $email_client;
        $this->reason       = $reason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address    = 'mail@talkila.com';
        $subject    = __('FEEDBACK_DELETED_SUBJECT');
        $name       = 'Talkila';
        $message    = $this->getMessage();

        EmailHistoriesLogController::createHistoryEmailLog($this->email_client, $subject, $message);

        return $this->markdown('emails.feedback_deleted')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'email_client'  => $this->email_client,
                'reason'        => $this->reason
            ]);
    }

    public function getMessage()
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html = $markdown->render('emails.feedback_deleted', [
            'email_client'  => $this->email_client,
            'reason'        => $this->reason
        ]);

        return $html;
    }
}
