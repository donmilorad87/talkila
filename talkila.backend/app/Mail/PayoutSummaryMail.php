<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use App\Models\Payout;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

class PayoutSummaryMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * A Payout model.
     */
    public Payout $payout;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($payout)
    {
        $this->payout = $payout;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'mail@talkila.com';
        $subject = __('PAYOUT_SUMMARY', ['date' => \Carbon\Carbon::parse($this->payout->payout_date)->format('Y F')]);
        $name    = 'Talkila';
        $message = $this->getMessage();

        EmailHistoriesLogController::createHistoryEmailLog($this->payout->user->email, $subject, $message);

        return $this->markdown('emails.payout-summary')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'payout'        => $this->payout,
                'user'          => $this->payout->user,
                'billing'       => $this->payout->user->billing,
                'payout_method' => $this->payout->user->payoutMethod,
                'bookings'      => collect($this->payout->getBookingsSummary()),
                'talks'         => $this->payout->getBookings(0),
            ]);
    }

    public function getMessage()
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html     = $markdown->render('emails.payout-summary', [
            'payout'        => $this->payout,
            'user'          => $this->payout->user,
            'billing'       => $this->payout->user->billing,
            'payout_method' => $this->payout->user->payoutMethod,
            'bookings'      => collect($this->payout->getBookingsSummary()),
            'talks'         => $this->payout->getBookings(0),
        ]);

        return $html;
    }
}
