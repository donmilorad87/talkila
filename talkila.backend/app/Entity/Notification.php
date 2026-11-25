<?php

namespace App\Entity;
use App\Exceptions\Handler;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Sends a push notification through firebase messaging
 */
class Notification
{
    public function __construct()
    {
        $this->accessKey = getenv("FIREBASE_ACCESS_KEY");
    }

    public function sendPushNotification($payload){
        Log::notice("\n\n" .self::class.'::'. __FUNCTION__ .'::$request');
        Log::notice($payload);

        try {
            $headers = array
            (
                'Authorization: key=' . $this->accessKey,
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $payload ) );
            $result = curl_exec($ch );
            curl_close( $ch );

            // TODO Handle Firebase error response here
            return $result;
        } catch(Exception $exception) {
            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_9500, self::class, __FUNCTION__);
        }
    }

    public function sendiOSPushNotification($payload, $firebase_token){
        Log::notice("\n\n" .self::class.'::'. __FUNCTION__ .'::$request');
        Log::notice($payload);
        Log::notice($firebase_token);

        try {
            $headers = array
            (
                'apns-topic: com.romic.talkila.voip'
            );

            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://api.sandbox.push.apple.com/3/device/'.$firebase_token );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_2_0);
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $payload ) );

            curl_setopt($ch, CURLOPT_SSLCERT, __DIR__ . '/../../config/iosCertificates/talkila_production.pem');
            $result = curl_exec($ch );
            curl_close( $ch );

            Log::error(response()->json($result));

            // TODO Handle Firebase error response here
        } catch(Exception $exception) {
            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_9500, self::class, __FUNCTION__);
        }
    }


}

