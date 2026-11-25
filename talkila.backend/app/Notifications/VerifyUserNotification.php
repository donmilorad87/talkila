<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Class VerifyUserNotification
 * @package App\Notifications
 */
class VerifyUserNotification extends Notification
{
    use Queueable;

    /**
     * @var User
     */
    private $user = null;

    /**
     * VerifyUserNotification constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param $notifiable
     * @return string[]
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * @param $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line(trans('global.verifyYourUser'))
            ->action(trans('global.clickHereToVerify'), route('userVerification', $this->user->verification_token))
            ->line(trans('global.thankYouForUsingOurApplication'));
    }

    /**
     * @param $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [];
    }
}
