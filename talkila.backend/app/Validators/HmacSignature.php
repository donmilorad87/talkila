<?php

/**
 *                       ######
 *                       ######
 * ############    ####( ######  #####. ######  ############   ############
 * #############  #####( ######  #####. ######  #############  #############
 *        ######  #####( ######  #####. ######  #####  ######  #####  ######
 * ###### ######  #####( ######  #####. ######  #####  #####   #####  ######
 * ###### ######  #####( ######  #####. ######  #####          #####  ######
 * #############  #############  #############  #############  #####  ######
 *  ############   ############  #############   ############  #####  ######
 *                                      ######
 *                               #############
 *                               ############
 *
 * Adyen API Library for PHP
 *
 * Copyright (c) 2019 Adyen B.V.
 * This file is open source and available under the MIT license.
 * See the LICENSE file for more info.
 *
 */

namespace App\Validators;

use Adyen\AdyenException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

/**
 * Class HmacSignature
 * @package App\Validators
 */
class HmacSignature implements SignatureValidator
{
    /**
     * @param string $hmacKey
     * @param array $params
     * @return string
     * @throws AdyenException
     */
    public function calculateNotificationHMAC($hmacKey, $params)
    {
        // validate if hmacKey is provided
        if (empty($hmacKey)) {
            throw new AdyenException("You did not provide a HMAC key");
        }

        // validate if hmacKey contains only hexadecimal chars to be packed with H*
        if (!ctype_xdigit($hmacKey)) {
            throw new AdyenException("Invalid HMAC key: $hmacKey");
        }

        if (empty($params)) {
            throw new AdyenException("You did not provide any parameters");
        }

        $dataToSign = self::getNotificationDataToSign($params);

        // base64-encode the binary result of the HMAC computation
        $merchantSig = base64_encode(hash_hmac('sha256', $dataToSign, pack("H*", $hmacKey), true));
//        Log::error('$merchantSig: ');
//        Log::error($merchantSig);
        return $merchantSig;
    }

    /**
     * @param array $params
     * @return string
     */
    private function getNotificationDataToSign($params)
    {
        $pspReference = (!empty($params['pspReference'])) ? $params['pspReference'] : "";
        $originalReference = (!empty($params['originalReference'])) ? $params['originalReference'] : "";
        $merchantAccountCode = (!empty($params['merchantAccountCode'])) ? $params['merchantAccountCode'] : "";
        $merchantReference = (!empty($params['merchantReference'])) ? $params['merchantReference'] : "";
        $value = (!empty($params['amount']['value'])) ? $params['amount']['value'] : "";
        $currency = (!empty($params['amount']['currency'])) ? $params['amount']['currency'] : "";
        $eventCode = (!empty($params['eventCode'])) ? $params['eventCode'] : "";
        $success = (!empty($params['success'])) ? $params['success'] : "";

        $dataToSign = array(
            $pspReference,
            $originalReference,
            $merchantAccountCode,
            $merchantReference,
            $value,
            $currency,
            $eventCode,
            $success
        );

        $characterEscapeFunction = function ($val) {
            // escapes `:` and `\` to properly sign data
            // `:` will be used as glue
            // `\` is the standard escaping character
            return str_replace(':', '\\:', str_replace('\\', '\\\\', $val));
        };

        $dataToSign = implode(":", array_map($characterEscapeFunction, array_values($dataToSign)));

        return $dataToSign;
    }

    /**
     * @param string $hmacKey
     * @param array $params
     * @return bool
     * @throws AdyenException
     */
    public function isValidNotificationHMAC($hmacKey, $params)
    {
        if (empty($params["additionalData"]) || empty($params["additionalData"]["hmacSignature"])) {
            throw new AdyenException("You did not provide hmacSignature in additionalData");
        }
        $merchantSign = $params["additionalData"]["hmacSignature"];
        unset($params["additionalData"]);
        $expectedSign = $this->calculateNotificationHMAC($hmacKey, $params);

        return $expectedSign == $merchantSign;
    }

    /**
     * @param Request $request
     * @param WebhookConfig $config
     * @return bool
     */
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        $isRequestValid = true;

        // YOUR_HMAC_KEY from the Customer Area
        $hmacKey = env('WEBHOOK_CLIENT_SECRET');
        $notificationRequest = $request->all();

        // TEST
//        $hmacKey = '7346620E75C60EE2E5E81A368B89611E6F66E9761B9E1D16047044A010985FD4';
//        $jsonRequest = '{"live":"false","notificationItems":[{"NotificationRequestItem":{"additionalData":{"hmacSignature":"0v4\/0\/6Zd0J949apecOAJLQCE22jxho5xmMFI4cGjU8="},"amount":{"currency":"EUR","value":0},"eventCode":"REFUND_WITH_DATA","eventDate":"2020-11-28T21:26:21+01:00","merchantAccountCode":"TALKILAECOM","merchantReference":"testMerchantRef1","originalReference":"pspReference of the REFUND_WITH_DATA","pspReference":"test_REFUND_WITH_DATA","reason":"","success":"true"}}]}';

//        $notificationRequest = json_decode($jsonRequest, true);

//        Log::error($hmacKey);
//        Log::error($notificationRequest);

        if(isset($notificationRequest["notificationItems"])) {
            foreach ( $notificationRequest["notificationItems"] as $notificationRequestItem ) {
                $params = $notificationRequestItem["NotificationRequestItem"];
                try {
                    if ($this->isValidNotificationHMAC($hmacKey, $params)) {
                        $eventcode = $params['eventCode'];
                        // print_r($eventcode);
                        // Process the notification based on the eventCode
                    } else {
                        $isRequestValid = false;
                    }
                } catch (AdyenException $e) {
                    Log::error($e);
                }
            }
        } else {
            return false;
        }

//        Log::error('END SIGN VALIDATION');
//        return true;
        return $isRequestValid;
    }
}
