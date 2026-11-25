<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

class PayoutPerMonth extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $language;
    public $mentor_username;
    public $mentor_url;
    public $userBillingData;
    public $userData;
    public $bookingsData;

    public function __construct($language, $mentor_username, $mentor_url, $userBillingData, $userData, $bookingsData)
    {
        $this->language         = $language;
        $this->mentor_username  = $mentor_username;
        $this->mentor_url       = $mentor_url;
        $this->userBillingData  = $userBillingData;
        $this->userData         = $userData;
        $this->bookingsData     = $bookingsData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address    = 'payout@talkila.com';
//        $subject    = 'Talkila Payout '.date('F', strtotime($this->month)) .'/'. $this->year .' - '.  $this->userData['name'];
        $subject    = __('PAYOUT_PER_MONTH_SUBJECT', ['username' => $this->userData['name']]);
        $name       = $this->userData['name'];
        $message    = $this->getMessage();

        EmailHistoriesLogController::createHistoryEmailLog($this->mentor_username, $subject, $message);

        return $this->view('emails.payout_per_month')
            ->from($address, $name)
            ->replyTo($address, $name)
            ->subject($subject)
            ->with([
                'mentor_username'   =>  $this->mentor_username,
                'mentor_url'        =>  $this->mentor_url,
                'userBillingData'   =>  $this->userBillingData,
                'userData'          =>  $this->userData,
                'bookingsData'      =>  $this->bookingsData
            ]);
    }

    public function getMessage($courseType = null, $bookingUrl = null)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html = $markdown->render('emails.payout_per_month', [
            'mentor_username'   =>  $this->mentor_username,
            'mentor_url'        =>  $this->mentor_url,
            'userBillingData'   =>  $this->userBillingData,
            'userData'          =>  $this->userData,
            'bookingsData'      =>  $this->bookingsData
        ]);

        return $html;
    }
}
