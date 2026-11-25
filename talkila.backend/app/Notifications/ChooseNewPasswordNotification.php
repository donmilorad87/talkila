<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChooseNewPasswordNotification extends Notification
{
    use Queueable;

    /**
     * @var string New Password Verification token.
     */
    public string $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = config('app.frontend_url') . '/password/reset/' . $this->token . '?email=' . $notifiable->email;

        return (new MailMessage)
            ->subject(__('APP_PERMISSIONS_REVOKED_SUBJECT'))
            ->greeting(__('APP_PERMISSIONS_REVOKED_HEADLINE'))
            ->line(__('APP_PERMISSIONS_REVOKED_CONTENT'))
            ->action(__('NEW_PASSWORD'), $url);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
