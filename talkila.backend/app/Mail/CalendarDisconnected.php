<?php

namespace App\Mail;

use App\Models\CalendarAccount;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CalendarDisconnected extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User The User instance.
     */
    public User $user;

    /**
     * @var CalendarAccount The Calendar Account instance.
     */
    public CalendarAccount $calendarAccount;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, CalendarAccount $calendarAccount)
    {
        $this->user            = $user;
        $this->calendarAccount = $calendarAccount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): CalendarDisconnected
    {
        app()->setLocale($this->user->last_language);

        $address    = 'mail@talkila.com';
        $subject    = __('CALENDAR_DISCONNECTED_SUBJECT');
        $name       = 'Talkila';
        $profileUrl = config('app.frontend_url') . '/settings/profile';

        return $this->markdown('emails.calendar_disconnected')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'profileUrl'      => $profileUrl,
                'calendarAccount' => $this->calendarAccount,
            ]);
    }
}
