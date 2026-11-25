<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use DB;

class CreditCard extends Model
{
    use  SoftDeletes;

    public $table = 'credit_card';

    protected $dates = [
        'created_at ',
        'updated_at',
        'deleted_at',
    ];

    protected $rule = [
        'stripe_card_id'        => 'required',
        'stripe_customer_id'    => 'required',
        'user_id'               => 'required',
        'card_last_four_digit'  => 'required',
        'card_month_expire'     => 'required',
        'card_year_expire'      => 'required',
        'card_brand'            => 'required',
    ];

    protected $fillable = [
        'stripe_card_id',
        'stripe_customer_id',
        'user_id',
        'card_last_four_digit',
        'card_month_expire',
        'card_year_expire',
        'card_brand',
        'response',
        'fingerprint',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function addCreditCard($request)
    {
            $creditCard = new CreditCard();
        $creditCard->stripe_card_id = $request['stripe_card_id'];
        $creditCard->stripe_customer_id = $request['stripe_customer_id'];
        $creditCard->user_id = $request['user_id'];
        $creditCard->card_last_four_digit = $request['card_last_four_digit'];
        $creditCard->card_month_expire = $request['card_month_expire'];
        $creditCard->card_year_expire = $request['card_year_expire'];
        $creditCard->card_brand = $request['card_brand'];
        $creditCard->response = $request['response'];
        $creditCard->fingerprint = $request['fingerprint'];
        $creditCard->save();
        return $creditCard->id;
    }

    public function displayCardByUserId($userId)
    {
        $cardData = CreditCard::where('user_id', $userId)->get();
        return $cardData;
    }

    public function getCardById($cardId)
    {
        $cardData = CreditCard::where('id', $cardId)->first();
        return $cardData;
    }

    public function updateDefaultCardDb($cardId, $userId){

        //DB::update('update credit_card set default_card = 0 where user_id = ?',[$userId]);
        CreditCard::where('user_id',$userId)
            ->update(['default_card' => 0]);

        $data = CreditCard::find($cardId);
        $data->default_card = 1;
        $data->save();
    }
    public function DefaultCard($carStripedId){
        //DB::update('update credit_card set default_card = 1 where stripe_card_id = ?',[$carStripedId]);
        CreditCard::where('stripe_card_id',$carStripedId)
            ->update(['default_card' => 1]);
    }
    public function getDefaultCardByUserId($user_id){
        return CreditCard::where('user_id',$user_id)
            ->where('default_card',1)
            ->first();
    }
    public function deleteCardById($cardId)
    {
        CreditCard::where('id', $cardId)->firstorfail()->delete();
    }
    public function getCardByFingerprint($userId, $fingerprint)
    {
        return CreditCard::where('user_id',$userId)
            ->select("id", "fingerprint")
            ->where('fingerprint', "$fingerprint")
            ->first();
    }
    public function editCreditCard($request)
    {
        $creditCard = CreditCard::find($request['id']);
        $creditCard->stripe_card_id = $request['stripe_card_id'];
        $creditCard->card_last_four_digit = $request['card_last_four_digit'];
        $creditCard->card_month_expire = $request['card_month_expire'];
        $creditCard->card_year_expire = $request['card_year_expire'];
        $creditCard->response = $request['response'];
        $creditCard->save();
    }
}
