<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

/**
 * Class BookingCancellationClient
 * @package App\Mail
 */
class ProfileNotVerified extends Mailable
{
    use Queueable, SerializesModels;

    public $verificationUrl;
    public $clientUsername;
    public $rejectDate;
    /**
     * Create a new message instance.
     *
     * @return void
     */



    public function __construct($clientUsername, $rejectDate)
    {
        $this->verificationUrl = config('app.frontend_url') . '/account-verification';
        $this->clientUsername = $clientUsername;
        $this->rejectDate = $rejectDate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'mail@talkila.com';
        $subject = __('VERIFICATION_REJECTED');

        $name = 'Talkila';


        //$message = $this->getMessage($talkUrl, $courseUrl);

        //EmailHistoriesLogController::createHistoryEmailLog($this->email_mentor, $subject, $message);

        return $this->markdown('emails.profile_not_verified')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'verificationUrl'       => $this->verificationUrl,
                'clientUsername'        => $this->clientUsername,
                'rejectDate'            => $this->rejectDate
            ]);
    }

    public function getMessage($talkUrl = null, $courseUrl = null)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html     = $markdown->render('emails.profile_not_verified', [
            'verificationUrl'       => $this->verificationUrl,
            'clientUsername'        => $this->clientUsername,
            'rejectDate'            => $this->rejectDate
        ]);

        return $html;
    }
}
