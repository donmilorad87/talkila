<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

class BillingInformationAdded extends Mailable
{
    use Queueable, SerializesModels;

    public $language;
    public $email_mentor;
    public $original_full_name;
    public $original_address;
    public $original_city;
    public $original_zip_code;
    public $original_tax_id;
    public $original_country;
    public $username_mentor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        $language,
        $email_mentor,
        $original_full_name,
        $original_address,
        $original_city,
        $original_zip_code,
        $original_tax_id,
        $original_country,
        $username_mentor)
    {

        $this->language             = $language;
        $this->email_mentor         = $email_mentor;
        $this->original_full_name   = $original_full_name;
        $this->original_address     = $original_address;
        $this->original_city        = $original_city;
        $this->original_zip_code    = $original_zip_code;
        $this->original_tax_id      = $original_tax_id;
        $this->original_country     = $original_country;
        $this->username_mentor      = $username_mentor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address    = 'mail@talkila.com';
        $subject    = __('BILLING_CHANGED_SUBJECT');
        $name       = 'Talkila';

        $bilingInformationUrl   = config('app.frontend_url').'/settings/billing-informations';
        $message                = $this->getMessage();

        EmailHistoriesLogController::createHistoryEmailLog($this->email_mentor, $subject, $message);

        return $this->markdown('emails.billing_information_added')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'original_full_name'    => $this->original_full_name,
                'original_address'      => $this->original_address,
                'original_city'         => $this->original_city,
                'original_zip_code'     => $this->original_zip_code,
                'original_tax_id'       => $this->original_tax_id,
                'original_country'      => $this->original_country,
                'bilingInformationUrl'  => $bilingInformationUrl
            ]);
    }

    public function getMessage()
    {
        $bilingInformationUrl   = config('app.frontend_url').'/settings/billing-informations';
        $markdown = Container::getInstance()->make(Markdown::class);
        $html = $markdown->render('emails.billing_information_added', [
            'original_full_name'    => $this->original_full_name,
            'original_address'      => $this->original_address,
            'original_city'         => $this->original_city,
            'original_zip_code'     => $this->original_zip_code,
            'original_tax_id'       => $this->original_tax_id,
            'original_country'      => $this->original_country,
            'bilingInformationUrl'  => $bilingInformationUrl,
            'username_mentor'       => $this->username_mentor,
        ]);

        return $html;
    }
}
