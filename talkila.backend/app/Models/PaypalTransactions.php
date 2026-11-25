<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaypalTransactions extends Model
{
    use HasFactory;

    public $table = 'paypal_transactions';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'id',
        'user_id',
        'amount',
        'transaction_type',
        'transaction_id',
        'response',
        'status',
        'created_at',
        'updated_at',
    ];

    public function addPayPalTransaction($request){
        $payPalTransactions                     = new PaypalTransactions();
        $payPalTransactions->user_id            = $request['user_id'];
        $payPalTransactions->amount             = $request['amount'];
        $payPalTransactions->transaction_type   = $request['transaction_type'];
        $payPalTransactions->transaction_id     = $request['transaction_id'];
        $payPalTransactions->response           = $request['response'];
        $payPalTransactions->status             = $request['status'];
        $payPalTransactions->save();
        return $payPalTransactions->id;
    }

    public function getTransactionById($transactionId)
    {
        $transactionData = PaypalTransactions::where('transaction_id', $transactionId)->first();
        return $transactionData;
    }
}
