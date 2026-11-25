<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;




class WalletTest extends TestCase
{
    /**
     *
     *
     * @return void
     * @throws GuzzleException
     */
    public function test_deposit_in_wallet()
    {
        $appUrl = env('APP_URL');
        $client = new Client();
        $apiRequest =
            ['form_params' =>[
                'user_id' => '1',
                'amount' => '5',
                'currency' => 'eur'
            ]];
        $user = $apiRequest['form_params']['user_id'];
        $amount = $apiRequest['form_params']['amount'];
        $currency = $apiRequest['form_params']['currency'];

        $responseText = $client->post($appUrl.'/v1/deposite-in-wallet',$apiRequest);

        $response = json_decode($responseText->getBody()->getContents());

        $expected = new \stdClass();
        if(empty($user)){
            $expected->message = "USER_ID_REQUIRED";
            $expected->success = false;
        } elseif (empty($amount)){
            $expected->message = "Ammount is required.";
            $expected->success = false;
        } elseif (empty($currency)){
            $expected->message = "Currency is required.";
            $expected->success = false;
        } else {
            $data = array(
                "user_id" => $response->data->user_id,
                "balance" => $response->data->balance,
                "available_balance" => $response->data->available_balance,
            );

            $dataObj = new \stdClass();
            $dataObj->user_id = $data['user_id'];
            $dataObj->balance = $data['balance'];
            $dataObj->available_balance = $data['available_balance'];
            $expected->success = true;
            $expected->message = $response->message;
            $expected->data = $dataObj;
            $expected->is_3D_authentic = false;
        }
        $this->assertEquals($expected,$response,'Success');
        dd($response);
    }
}
