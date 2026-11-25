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
 * Class AppFeedback
 * @package App\Mail
 */
class AppFeedback extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $username;
    /**
     * @var
     */
    public $rating;
    /**
     * @var
     */
    public $comment;
    /**
     * @var
     */
    public $created;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($username, $rating, $comment, $created)
    {
        $this->username = $username;
        $this->rating   = $rating;
        $this->comment  = $comment;
        $this->created  = $created;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address    = 'mail@talkila.com';
        $subject    = __('FEEDBACK_ON_APPLICATION_SUBJECT');
        $name       = 'Talkila';
        $message    = $this->getMessage();

        EmailHistoriesLogController::createHistoryEmailLog($this->username, $subject, $message);

        return $this->markdown('emails.app_feedback')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'username'  => $this->username,
                'rating'    => $this->rating,
                'comment'   => $this->comment,
                'created'   => $this->created
            ]);
    }

    public function getMessage($courseType = null, $bookingUrl = null)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html = $markdown->render('emails.app_feedback', [
            'username'  => $this->username,
            'rating'    => $this->rating,
            'comment'   => $this->comment,
            'created'   => $this->created
        ]);

        return $html;
    }
}
