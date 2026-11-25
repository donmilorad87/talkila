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
 * Class AccountImageVerified
 * @package App\Mail
 */
class AccountImageVerified extends Mailable
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
    public function __construct($subject, $recipient, $username)
    {
        $this->subject      = $subject;
        $this->recipient    = $recipient;
        $this->username     = $username;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address    = 'talkila@blazingsun.space';
        $subject    = __('ACCOUNT_IMAGE_VERIFIED_SUBJECT');
        $name       = 'Talkila';
        $message    = $this->getMessage();

        EmailHistoriesLogController::createHistoryEmailLog($this->recipient, $subject, $message);

        return $this->markdown('emails.account_image_verified')
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
        $html = $markdown->render('emails.account_image_verified', [
            'username'      => $this->username,
            'block_reason'  => $this->block_reason
        ]);

        return $html;
    }
}
