<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use DB;
use Illuminate\Support\Facades\Config;


class Wallet extends Model
{
    use HasFactory;

    public $table = 'wallets';

    protected $dates = [
        'created_at ',
        'updated_at',
    ];

    protected $rule = [
        'user_id' => 'required',
        'raw_balance' => 'required',
    ];

    protected $fillable = [
        'user_id',
        'raw_balance',
        'available_balance',
    ];


    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function checkWalletExits($userId)
    {
        $data = Wallet::where('user_id', $userId)->first();
        return $data;
    }

    public function addWalletData($request)
    {
        $wallet = new Wallet();
        $wallet->user_id = $request['user_id'];
        $wallet->raw_balance = $request['raw_balance'];
        $wallet->available_balance = $request['available_balance'];
        $wallet->save();
        return $wallet->id;
    }

    public function updateWalletData($userId, $balance, $available_balance = "")
    {
        $updateArray = array();
        $updateArray['raw_balance'] = $balance;
        if($available_balance !== "") {
            $updateArray['available_balance'] = $available_balance;
        }
        return Wallet::where('user_id',$userId)->update($updateArray);
    }
}
