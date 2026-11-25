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
class RefundedCoins extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $email_mentor;
    public $coins_new_balance;
    public $coins_old_balance;
    public $date;
    public $method;
    public $new_amount;
    public $payment_method;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email_mentor, $coins_new_balance, $coins_old_balance, $date, $method, $new_amount, $payment_method)
    {
        $this->email_mentor      = $email_mentor;
        $this->coins_new_balance = $coins_new_balance;
        $this->coins_old_balance = $coins_old_balance;
        $this->date              = $date;
        $this->method            = $method;
        $this->new_amount        = $new_amount;
        $this->payment_method    = $payment_method;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'mail@talkila.com';
        $subject = __('REFUNDED_COINS_SUBJECT');

        $name = 'Talkila';

        $walletUrl = config('app.frontend_url') . '/settings/wallets';

        $message = $this->getMessage($walletUrl);

        EmailHistoriesLogController::createHistoryEmailLog($this->email_mentor, $subject, $message);

        return $this->markdown('emails.refunded_coins')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'walletUrl'         => $walletUrl,
                'coins_new_balance' => $this->coins_new_balance,
                'coins_old_balance' => $this->coins_old_balance,
                'date'              => $this->date,
                'method'            => $this->method,
                'new_amount'        => $this->new_amount,
                'payment_method'    => $this->payment_method
            ]);
    }

    public function getMessage($walletUrl = null)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html     = $markdown->render('emails.refunded_coins', [
            'walletUrl'         => $walletUrl,
            'coins_new_balance' => $this->coins_new_balance,
            'coins_old_balance' => $this->coins_old_balance,
            'date'              => $this->date,
            'method'            => $this->method,
            'new_amount'        => $this->new_amount,
            'payment_method'    => $this->payment_method
        ]);

        return $html;
    }
}
