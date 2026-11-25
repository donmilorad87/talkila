<?php

    use \App\Http\Controllers\Api\V1\Admin\WalletController;
    use App\Models\Wallet;
    use App\Models\WalletHistory;
    $wallet = new WalletController();
    $walletData = new Wallet();
    $wallethistory = new WalletHistory();

    $paymentIntentId = $_REQUEST['payment_intent'];
    $userId = $_REQUEST['user_id'];
    $web_redirect = isset($_REQUEST['web_redirect']) ? $_REQUEST['web_redirect'] : "";
    $response = array();
    $data = $wallet->checkPaymentStatus($paymentIntentId);
    $paymentData = json_decode($data);

    if($paymentData->status == 'succeeded'){
        //echo $paymentData->charges->data[0]->id; exit;
        $checkTransaction = $wallethistory->getTransactionByTransactionId($paymentData->charges->data[0]->id);
        if($checkTransaction->isEmpty()){

            $walletData = $walletData->checkWalletExits($userId);
            if (empty($walletData)) {
                $walletArr = array();
                $balance = ($paymentData->amount / 100);
                $walletArr = array(
                    'user_id' => $userId,
                    'raw_balance' => (double) $balance,
                    'available_balance' => (double) $balance,
                );

                $wallet_id = $walletData->addWalletData($walletArr);
            } else {
                $balance = $walletData['raw_balance'] + ($paymentData->amount / 100);
                $available_balance = $walletData['available_balance'] + ($paymentData->amount / 100);
                $walletData->updateWalletData($userId, $balance, $available_balance);
                $wallet_id = $walletData['id'];
            }

            $transactionArr = array(
                'user_id' => $userId,
                'wallet_id' => $wallet_id,
                'transaction_type' => 'credit',
                'transaction_id' => $paymentData->charges->data[0]->id,
                'amount' => +($paymentData->amount / 100),
                'status' => WalletHistory::STATUS['COMPLETED'],
                'card_details' => json_encode($paymentData),
            );
            //print_r($transactionArr); exit;
            $rs = $wallethistory->addTransactionDetails($transactionArr);
            $response['success'] = true;
            $response['message'] = "3D secure authentication successfully.";
        } else {
            $response['success'] = true;
            $response['message'] = "3D secure authentication successfully.";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "3D secure authentication failed.";
    }
    if ($web_redirect != "") {
        $query = parse_url($web_redirect, PHP_URL_QUERY);
        if ($query) {
            $web_redirect .= '&message=' . $response['message'];
        } else {
            $web_redirect .= '?message=' . $response['message'];
        }
        echo redirect()->away($web_redirect);exit;
    }
    echo response()->json($response)->getContent();exit;
?>
