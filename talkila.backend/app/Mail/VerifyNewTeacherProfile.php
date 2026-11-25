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
class VerifyNewTeacherProfile extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $email_mentor;
    public $name;
    public $username;
    public $email;
    public $profile_picture;
    public $finishedTime;
    public $billingAddress;
    public $availabilities;
    public $talk;
    public $talk_type;
    public $talk_language;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email_mentor, $name, $username, $email, $profile_picture, $finishedTime, $billingAddress, $availabilities, $talk, $talk_type, $talk_language)
    {
        $this->email_mentor    = $email_mentor;
        $this->name            = $name;
        $this->username        = $username;
        $this->email           = $email;
        $this->profile_picture = $profile_picture;
        $this->finishedTime    = $finishedTime;
        $this->billingAddress  = $billingAddress;
        $this->availabilities  = $availabilities;
        $this->talk            = $talk;
        $this->talk_type       = $talk_type;
        $this->talk_language   = $talk_language;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'jtc@talkila.com';
        $subject = __('VERIFY_NEW_SUPPLIER_SUBJECT', ['name' => $this->name, 'username' => $this->username]);

        $name = 'Talkila';

        $verificationUrl = config('app.frontend_url') . '/profile-verifications';
        $usernameUrl     = config('app.frontend_url') . '/' . $this->username;
        $talkUrl         = config('app.frontend_url') . '/booking-summary/' . $this->talk->id;

        $message = $this->getMessage($verificationUrl, $usernameUrl, $talkUrl);

        EmailHistoriesLogController::createHistoryEmailLog($this->email_mentor, $subject, $message);

        return $this->markdown('emails.verify_new_teacher_profile')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'verificationUrl' => $verificationUrl,
                'usernameUrl'     => $usernameUrl,
                'talkUrl'         => $talkUrl,
                'name'            => $this->name,
                'username'        => $this->username,
                'email'           => $this->email,
                'profile_picture' => $this->profile_picture,
                'finishedTime'    => $this->finishedTime,
                'billingAddress'  => $this->billingAddress,
                'availabilities'  => $this->availabilities,
                'talk'            => $this->talk,
                'talk_type'       => $this->talk_type,
                'talk_language'   => $this->talk_language,
            ]);
    }

    public function getMessage($verificationUrl = null, $usernameUrl = null, $talkUrl = null)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html     = $markdown->render('emails.verify_new_teacher_profile', [
            'verificationUrl' => $verificationUrl,
            'usernameUrl'     => $usernameUrl,
            'talkUrl'         => $talkUrl,
            'name'            => $this->name,
            'username'        => $this->username,
            'email'           => $this->email,
            'profile_picture' => $this->profile_picture,
            'finishedTime'    => $this->finishedTime,
            'billingAddress'  => $this->billingAddress,
            'availabilities'  => $this->availabilities,
            'talk'            => $this->talk,
            'talk_type'       => $this->talk_type,
            'talk_language'   => $this->talk_language,
        ]);

        return $html;
    }
}
