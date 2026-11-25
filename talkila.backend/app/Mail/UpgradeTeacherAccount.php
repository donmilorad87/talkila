<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

class UpgradeTeacherAccount extends Mailable
{
    use Queueable, SerializesModels;

    public $language;
    public $username_client;
    public $step_profession;
    public $step_price;
    public $step_availability;
    public $step_accounting;
    public $step_money_transfer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($language, $username_client, $step_profession, $step_price, $step_availability , $step_accounting, $step_money_transfer)
    {
        $this->language             = $language;
        $this->username_client      = $username_client;
        $this->step_profession      = $step_profession;
        $this->step_price           = $step_price;
        $this->step_availability    = $step_availability;
        $this->step_accounting      = $step_accounting;
        $this->step_money_transfer  = $step_money_transfer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address    = 'mail@talkila.com';
        $subject    = __('UPGRADE_SUPPLIER_ACCOUNT_SUBJECT');
        $name       = 'Talkila';
        $message    = $this->getMessage();

        EmailHistoriesLogController::createHistoryEmailLog($this->username_client, $subject, $message);

        return $this->markdown('emails.upgrade_teacher_account')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'username_client'       => $this->username_client,
                'step_profession'       => $this->step_profession,
                'step_price'            => $this->step_price,
                'step_availability'     => $this->step_availability,
                'step_accounting'       => $this->step_accounting,
                'step_money_transfer'   => $this->step_money_transfer
            ]);
    }

    public function getMessage($courseType = null, $bookingUrl = null)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html = $markdown->render('emails.upgrade_teacher_account', [
            'username_client'       => $this->username_client,
            'step_profession'       => $this->step_profession,
            'step_price'            => $this->step_price,
            'step_availability'     => $this->step_availability,
            'step_accounting'       => $this->step_accounting,
            'step_money_transfer'   => $this->step_money_transfer
        ]);

        return $html;
    }
}
