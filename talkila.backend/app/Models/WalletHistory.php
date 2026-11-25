<?php


namespace App\Models;


use App\Mail\BoughtNewCoins;
use App\Mail\RefundedCoins;
use App\Traits\Serializable;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Str;

class WalletHistory extends Model
{
    use HasFactory, Serializable;

    public $table = 'wallet_ledgers';

    protected $dates = [
        'created_at ',
        'updated_at',
    ];

    protected $rule = [
        'user_id'          => 'required',
        'wallet_id'        => 'required',
        'transaction_type' => 'required',
        'amount'           => 'required',
        'status'           => 'required',
    ];

    protected $fillable = [
        'user_id',
        'booking_id',
        'source',
        'transaction_id',
        'transaction_type',
        'amount',
        'running_raw_balance',
        'status',
        'card_details',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'response' => 'array',
    ];

    const SOURCE = [
        'BOOKING'   => 0,
        'REFUND'    => 1,
        'POSTPONE'  => 2,
        'WALLET'    => 3,
        'PAYOUT'    => 4,
        'EXTENSION' => 5,
    ];

    const STATUS = [
        'CANCELLED' => '0',
        'COMPLETED' => '1',
        'PENDING'   => '2',
    ];

    const TYPE = [
        'CREDIT' => 'credit',
        'DEBIT'  => 'debit',
    ];

    const TRANSACTION = [
        'CARD'   => 'Credit Card',
        'PAYPAL' => 'PayPal',
        'PAYOUT' => 'Payout',
    ];

    const ISDELETE = [
        'CHARGEABLE'     => '0',
        'NON_CHARGEABLE' => '1',
        'REFUNDABLE'     => '2',
    ];

    const TIME = [
        'Hrs24' => 86400,
    ];

    const PAYMENT = [
        'coins_bought_credit_card'         => 0,
        'coins_bought_paypal'              => 1,
        'paid_with_wallet'                 => 2,
        'paid_with_credit_card'            => 3,
        'paid_with_paypal'                 => 4,
        'paid_with_credit_card_and_wallet' => 5,
        'paid_with_paypal_and_wallet'      => 6,
        'refund_coins'                     => 7,
        'refund_money'                     => 8,
    ];

    /* Relationship declarations
       ============================== */

    /**
     * Booking that owns the Transaction.
     *
     * @return BelongsTo
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the PayPal Transaction associated with the transaction details.
     *
     * @return HasOne
     */
    public function paypalTransaction(): HasOne
    {
        return $this->hasOne(PaypalTransactions::class, 'transaction_id', 'transaction_id');
    }

    /* Methods
       ============================== */

    public function addTransactionDetails($request)
    {
        $walletTransaction = new WalletHistory();

        $walletTransaction->updateOrCreate($request);

        return 1;
    }

    public function updateTransactionDetals($request)
    {
        $data         = WalletHistory::find($request['id']);
        $data->amount = $request['amount'];
        $data->status = 1;
        $data->save();
        return $data->id;
    }

    public function getTansactionByBookinId($userId, $bookingID)
    {
        //$data = DB::select('select * from wallet_ledgers where user_id = ? AND booking_id = ? AND status = ?', array($userId, $bookingID, 2));
        $data = WalletHistory::where('user_id', $userId)
            ->where('booking_id', $bookingID)
            ->where('status', 2)
            ->get();
        return $data;
    }

    public function userWalletJoin($userId)
    {
        return DB::table('users')
            ->select('*')
            ->join('wallets', 'wallets.user_id', '=', 'users.id')
            ->where(['user_id' => $userId,])
            ->get();
    }

    public function addBookTransactionDetails($request)
    {
        $walletTransaction                   = new WalletHistory();
        $walletTransaction->user_id          = $request['user_id'];
        $walletTransaction->wallet_id        = $request['wallet_id'];
        $walletTransaction->booking_id       = $request['booking_id'];
        $walletTransaction->transaction_type = $request['transaction_type'];
        $walletTransaction->amount           = $request['amount'];
        $walletTransaction->status           = $request['status'];
        $walletTransaction->save();
        return $walletTransaction->id;
    }

    public function getTransactionDetailsByUserId($userId)
    {
        $data = WalletHistory::where('user_id', $userId)
            ->where('status', WalletHistory::STATUS['COMPLETED'])
            ->leftJoin('bookings', 'wallet_ledgers.booking_id', '=', 'bookings.id')
            ->orderby('id', 'DESC')
            ->select(['wallet_ledgers.*', 'bookings.parent_id'])
            ->get();

        return $data;
    }

    public function getCancelTransactionByBookingId($bookingId)
    {
        //return DB::select('select * from wallet_ledgers where booking_id = ? AND status = ?', array($bookingId, 2));
        return WalletHistory::where('booking_id', $bookingId)
            ->where('status', 2)
            ->get();
    }

    public function updateCancelCallFlag($flag, $status, $bookingId)
    {
        return DB::update('update wallet_ledgers set is_delete = ?, status = ? where booking_id = ? AND status = 2', [$flag, $status, $bookingId]);
    }

    public function getPricePerminute($amount, $totalTime, $actualTime)
    {
        $amountPerMinitue = $amount / $totalTime;
        $actualAmount     = ($amountPerMinitue * $actualTime);

        return $actualAmount;
    }

    public function getTransactionByTransactionId($transactionId)
    {
        return WalletHistory::where('transaction_id', $transactionId)
            ->where('status', 1)
            ->get();
    }

    public function addFundsInWallet($user, $amount, $transactionType = WalletHistory::TYPE['CREDIT'], $bookingId = null, $transactionId = null, $chargeData = null, $status = WalletHistory::STATUS['COMPLETED'], $source = self::SOURCE['WALLET'])
    {
        Log::notice(self::class . '::' . __FUNCTION__ . ' ($chargeData)::');
        Log::notice($chargeData);

        $balance = $user->wallet_balance;

        if ($bookingId != 0) {

            /*
            $booking = Booking::query()
                ->find($bookingId)
                ->leftJoin('wallet_ledgers as payments', function ($query) {
                    $query->on('payments.booking_id', '=', 'bookings.id')
                        ->whereNotNull('payments.transaction_id');
                })
                ->select(['bookings.*', 'payments.transaction_id'])
                ->first();
            */
            $payment_method = Str::startsWith($transactionId, ['ch', 'pi', 'pm']) ? WalletHistory::TRANSACTION['CARD'] : WalletHistory::TRANSACTION['PAYPAL'];

        } else {

            if ($source == WalletHistory::SOURCE['PAYOUT']) {
                $payment_method = WalletHistory::TRANSACTION['PAYOUT'];
            } else {
                $payment_method = Str::startsWith($transactionId, ['ch', 'pi', 'pm']) ? WalletHistory::TRANSACTION['CARD'] : WalletHistory::TRANSACTION['PAYPAL'];
            }
        }


        if ($status == WalletHistory::STATUS['COMPLETED']) {
            $user->wallet_balance += $amount;
            $user->save();
        }

        $transactionArr = [
            'user_id'          => $user->id,
            'transaction_type' => $transactionType,
            'transaction_id'   => $transactionId,
            'booking_id'       => $bookingId,
            'source'           => $source,
            'amount'           => +$amount,
            'status'           => $status,
            'card_details'     => ($chargeData == null) ? null : json_encode($chargeData),
        ];

        $rs = $this->addTransactionDetails($transactionArr);

        if ($rs > 0) {
            switch ($source) {
                case WalletHistory::SOURCE['BOOKING']:
                    $source = 'Booking';
                    break;
                case WalletHistory::SOURCE['REFUND']:
                    $source = 'Refund';
                    break;
                case WalletHistory::SOURCE['POSTPONE']:
                    $source = 'Postpone';
                    break;
                case WalletHistory::SOURCE['WALLET']:
                    $source = 'Wallet';
                    break;
                case WalletHistory::SOURCE['PAYOUT']:
                    $source = 'Payout';
                    break;
                case WalletHistory::SOURCE['EXTENSION']:
                    $source = 'Extension';
            }

            $userNewState = User::query()->find($user->id);

            if ($source != 'Refund') {
                app()->setLocale($user->last_language);

                Mail::to($user->email)->queue(
                    new BoughtNewCoins(
                        $user->last_language,
                        $user->email,
                        $userNewState->wallet_balance,
                        $balance,
                        // Carbon::parse(date('d.m.Y H:i'))->subMinutes(session()->get('timezone_offset'))->toTimeString(),
                        convertToUserTimezone(now(),'H:i:s'),
                        $source,
                        $amount,
                        $payment_method
                    )
                );
            }
            if ($source == 'Refund') {
                app()->setLocale($user->last_language);
                // $email_mentor, $coins_new_balance, $coins_old_balance, $date, $method, $new_amount, $payment_method
                Mail::to($user->email)->queue(
                    new RefundedCoins(
                        $user->email,
                        $userNewState->wallet_balance,
                        $balance,
                        convertToUserTimezone(now(), 'H:i:s'),
                        $source,
                        $amount,
                        $payment_method
                    )
                );
            }

            return [
                'message' => 'Added Funds in Wallet',
                'success' => true,
            ];
        } else {
            return [
                'message' => 'Error in adding Funds to Wallet',
                'success' => false,
            ];
        }
    }

    public function removeFundsFromWallet($user, $bookingId, $price, $source = self::SOURCE['BOOKING'])
    {
        Log::notice(self::class . '::' . __FUNCTION__ . ' ($bookingId)::');
        Log::notice($bookingId);

        Log::notice(self::class . '::' . __FUNCTION__ . ' ($price)::');
        Log::notice($price);

        $user->wallet_balance -= $price;
        $user->save();

        $transactionArr = [
            'user_id'          => $user->id,
            'transaction_type' => WalletHistory::TYPE['DEBIT'],
            'transaction_id'   => '',
            'booking_id'       => $bookingId,
            'source'           => $source,
            'amount'           => +($price),
            'status'           => WalletHistory::STATUS['COMPLETED'],
            'card_details'     => '',
        ];

        $rs = $this->addTransactionDetails($transactionArr);

        if ($rs > 0) {
            return [
                'message' => 'Removed Funds from Wallet',
                'success' => true,
            ];
        } else {
            return [
                'message' => 'Error in removing Funds from Wallet',
                'success' => false,
            ];
        }
    }

    /* Accessor/Mutators
       ============================== */

    /**
     * Returns Transaction PayPal account.
     *
     * @return string|null
     */
    public function getPaypalAccountAttribute(): ?string
    {
        $transaction = json_decode($this->paypalTransaction->response, true);

        if (!$transaction) {
            return null;
        }

        return $transaction['data']['payment_source']['paypal']['email_address'];
    }
}

