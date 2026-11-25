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
class JtcFinished extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $email_mentor;
    public $name;
    public $username;
    public $billing_full_name;
    public $billing_address;
    public $billing_city;
    public $billing_zip_code;
    public $billing_tax_id;
    public $billing_country;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email_mentor, $name, $username, $billing_full_name, $billing_address, $billing_city, $billing_zip_code, $billing_tax_id, $billing_country)
    {
        $this->email_mentor      = $email_mentor;
        $this->name              = $name;
        $this->username          = $username;
        $this->billing_full_name = $billing_full_name;
        $this->billing_address   = $billing_address;
        $this->billing_city      = $billing_city;
        $this->billing_zip_code  = $billing_zip_code;
        $this->billing_tax_id    = $billing_tax_id;
        $this->billing_country   = $billing_country;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'mail@talkila.com';
        $subject = __('JTC_FINISHED_SUBJECT');

        $name = 'Talkila';

        $verificationUrl = config('app.frontend_url') . '/account-verification';
        $message         = $this->getMessage($verificationUrl);

        EmailHistoriesLogController::createHistoryEmailLog($this->email_mentor, $subject, $message);

        return $this->markdown('emails.jtc_finished')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'name'              => $this->name,
                'username'          => $this->username,
                'billing_full_name' => $this->billing_full_name,
                'billing_address'   => $this->billing_address,
                'billing_city'      => $this->billing_city,
                'billing_zip_code'  => $this->billing_zip_code,
                'billing_tax_id'    => $this->billing_tax_id,
                'billing_country'   => $this->billing_country,
                'verificationUrl'   => $verificationUrl,
            ]);
    }

    public function getMessage($verificationUrl = null)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html     = $markdown->render('emails.jtc_finished', [
            'name'              => $this->name,
            'username'          => $this->username,
            'billing_full_name' => $this->billing_full_name,
            'billing_address'   => $this->billing_address,
            'billing_city'      => $this->billing_city,
            'billing_zip_code'  => $this->billing_zip_code,
            'billing_tax_id'    => $this->billing_tax_id,
            'billing_country'   => $this->billing_country,
            'verificationUrl'   => $verificationUrl,
        ]);

        return $html;
    }
}
