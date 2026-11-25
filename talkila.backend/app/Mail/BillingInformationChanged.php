<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class BillingInformationChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $language;
    public $email_mentor;
    public $original_full_name;
    public $new_full_name;
    public $original_address;
    public $new_address;
    public $original_city;
    public $new_city;
    public $original_zip_code;
    public $new_zip_code;
    public $original_vat;
    public $new_vat;
    public $original_country;
    public $new_country;
    public $date;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        $language,
        $email_mentor,
        $original_full_name,
        $new_full_name,
        $original_address,
        $new_address,
        $original_city,
        $new_city,
        $original_zip_code,
        $new_zip_code,
        $original_vat,
        $new_vat,
        $new_country,
        $original_country,
        $date
    ) {
        $this->language           = $language;
        $this->email_mentor       = $email_mentor;
        $this->original_full_name = $original_full_name;
        $this->new_full_name      = $new_full_name;
        $this->original_address   = $original_address;
        $this->new_address        = $new_address;
        $this->original_city      = $original_city;
        $this->new_city           = $new_city;
        $this->original_zip_code  = $original_zip_code;
        $this->new_zip_code       = $new_zip_code;
        $this->original_vat       = $original_vat;
        $this->new_vat            = $new_vat;
        $this->new_country        = $new_country;
        $this->original_country   = $original_country;
        $this->date               = $date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'mail@talkila.com';
        $subject = __('BILLING_CHANGED_SUBJECT');
        $name    = 'Talkila';

        $billingInformationUrl = config('app.frontend_url') . '/settings/billing-informations';
        $message               = $this->getMessage($billingInformationUrl);

        EmailHistoriesLogController::createHistoryEmailLog($this->email_mentor, $subject, $message);

        return $this->markdown('emails.billing_information_changed')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'original_full_name'    => $this->original_full_name,
                'new_full_name'         => $this->new_full_name,
                'original_address'      => $this->original_address,
                'new_address'           => $this->new_address,
                'original_city'         => $this->original_city,
                'new_city'              => $this->new_city,
                'original_zip_code'     => $this->original_zip_code,
                'new_zip_code'          => $this->new_zip_code,
                'original_vat'          => $this->original_vat,
                'new_vat'               => $this->new_vat,
                'original_country'      => $this->original_country,
                'new_country'           => $this->new_country,
                'date'                  => Carbon::parse($this->date)->format('d.m.Y'),
                'time'                  => Carbon::parse($this->date)->format('H:i'),
                'billingInformationUrl' => $billingInformationUrl,
            ]);
    }

    public function getMessage($billingInformationUrl)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html     = $markdown->render('emails.billing_information_changed', [
            'original_full_name'    => $this->original_full_name,
            'new_full_name'         => $this->new_full_name,
            'original_address'      => $this->original_address,
            'new_address'           => $this->new_address,
            'original_city'         => $this->original_city,
            'new_city'              => $this->new_city,
            'original_zip_code'     => $this->original_zip_code,
            'new_zip_code'          => $this->new_zip_code,
            'original_vat'          => $this->original_vat,
            'new_vat'               => $this->new_vat,
            'original_country'      => $this->original_country,
            'new_country'           => $this->new_country,
            'date'                  => Carbon::parse($this->date)->format('d.m.Y'),
            'time'                  => Carbon::parse($this->date)->format('H:i'),
            'billingInformationUrl' => $billingInformationUrl,

        ]);

        return $html;
    }
}