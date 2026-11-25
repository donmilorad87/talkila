<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

class NewEmailAddress extends Mailable
{
    use Queueable, SerializesModels;

    public $language;
    public $email;
    public $username;
    public $username_url;
    public $temporary_url;
    public $date_dateset_updated;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($language, $email, $username, $username_url, $temporary_url , $date_dateset_updated)
    {
        $this->language             = $language;
        $this->email                = $email;
        $this->username             = $username;
        $this->username_url         = $username_url;
        $this->temporary_url        = $temporary_url;
        $this->date_dateset_updated = $date_dateset_updated;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address    = 'mail@talkila.com';
        $subject    = __('NEW_EMAIL_ADDRESS_SUBJECT');
        $name       = 'Talkila';
        $message    = $this->getMessage();

        EmailHistoriesLogController::createHistoryEmailLog($this->username, $subject, $message);

        return $this->markdown('emails.new_email_address')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'username'              => $this->username,
                'username_url'          => $this->username_url,
                'temporary_url'         => $this->temporary_url,
                'date_dateset_updated'  => $this->date_dateset_updated,
            ]);
    }

    public function getMessage($courseType = null, $bookingUrl = null)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html = $markdown->render('emails.new_email_address', [
            'username'              => $this->username,
            'username_url'          => $this->username_url,
            'temporary_url'         => $this->temporary_url,
            'date_dateset_updated'  => $this->date_dateset_updated,
        ]);

        return $html;
    }
}
