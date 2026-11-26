<?php

namespace App\Http\Controllers\PayPal;

// session_start();
// include_once('HttpHelper.php');

/**
 *    PayPal helper class for REST API requests.
 *
 */
session_start();

class PayPalHelper
{

    private $_http = null;
    private $_apiUrl = null;
    private $_token = null;

    /**
     *    Class constructor.
     *
     */
    public function __construct()
    {
        $this->_http   = new HttpHelper;
        $this->_apiUrl = config('talkila.paypal.endpoints');
    }

    /**
     *    Set PayPal default header for the curl instance.
     *
     * @return void
     */
    private function _setDefaultHeaders()
    {
        $this->_http->addHeader("PayPal-Partner-Attribution-Id: " . config('talkila.paypal.sbn_code'));
    }

    /**
     *    Create the PayPal REST endpoint url.
     *
     *    Use the configurations and combine resources to create the endpoint.
     *
     * @param  string  $resource  Url to be called using curl
     *
     * @return string REST API url depending on environment.
     */
    private function _createApiUrl($resource, $version = null)
    {
        if ($resource == 'oauth2/token') {
            return $this->_apiUrl . ($version ?: "/v1/") . $resource;
        } else {
            return $this->_apiUrl . "/" . ($version ?: config('paypal.rest_version')) . "/" . $resource;
        }
    }

    /**
     *    Request for PayPal REST oath bearer token.
     *
     *    Reset curl helper.
     *    Set default PayPal headers.
     *    Set curl url.
     *    Set curl credentials.
     *    Set curl body.
     *    Set class token attribute with bearer token.
     *
     * @return void
     */
    private function _getToken()
    {
        $this->_http->resetHelper();
        $this->_setDefaultHeaders();
        $this->_http->setUrl($this->_createApiUrl("oauth2/token"));
        $this->_http->setAuthentication(config('paypal.client_id') . ":" . config('paypal.secret'));
        $this->_http->setBody("grant_type=client_credentials");
        $returnData   = $this->_http->sendRequest();
        $this->_token = $returnData['access_token'];
    }

    /**
     *    Actual call to curl helper to create an order using PayPal REST APIs.
     *
     *    Reset curl helper.
     *    Set default PayPal headers.
     *    Set API call specific headers.
     *    Set curl url.
     *    Set curl body.
     *
     * @param  string  $code  Authorization code
     */
    private function _getAccessToken($code)
    {
        $this->_http->resetHelper();
        $this->_setDefaultHeaders();
        $this->_http->setUrl($this->_createApiUrl("oauth2/token"));
        $this->_http->setAuthentication(config('paypal.client_id') . ":" . config('paypal.secret'));
        $this->_http->setBody("grant_type=authorization_code&code=$code");
        $returnData   = $this->_http->sendRequest();
        $this->_token = $returnData['access_token'];
    }

    /**
     *    Actual call to curl helper to create an order using PayPal REST APIs.
     *
     *    Reset curl helper.
     *    Set default PayPal headers.
     *    Set API call specific headers.
     *    Set curl url.
     *    Set curl body.
     *
     * @return array PayPal REST create response
     */
    private function _getUserInfo()
    {
        $this->_http->resetHelper();
        $this->_setDefaultHeaders();
        $this->_http->addHeader("Content-Type: application/json");
        $this->_http->addHeader("Authorization: Bearer " . $this->_token);
        $this->_http->setUrl($this->_createApiUrl("identity/oauth2/userinfo?schema=paypalv1.1", 'v1'));
        return $this->_http->sendRequest();
    }

    /**
     *    Actual call to curl helper to create an order using PayPal REST APIs.
     *
     *    Reset curl helper.
     *    Set default PayPal headers.
     *    Set API call specific headers.
     *    Set curl url.
     *    Set curl body.
     *
     * @param  array  $postData  Url to be called using curl
     *
     * @return array PayPal REST create response
     */
    private function _createOrder($postData)
    {
        $this->_http->resetHelper();
        $this->_setDefaultHeaders();
        $this->_http->addHeader("Content-Type: application/json");
        $this->_http->addHeader("Authorization: Bearer " . $this->_token);
        $this->_http->setUrl($this->_createApiUrl("checkout/orders"));
        $this->_http->setBody($postData);
        return $this->_http->sendRequest();
    }

    /**
     *    Actual call to curl helper to get a payment using PayPal REST APIs.
     *
     *    Reset curl helper.
     *    Set default PayPal headers.
     *    Set API call specific headers.
     *    Set curl url.
     *
     * @param  array  $postData  Url to be called using curl
     *
     * @return array PayPal REST execute response
     */
    private function _getOrderDetails()
    {
        $this->_http->resetHelper();
        $this->_setDefaultHeaders();
        $this->_http->addHeader("Content-Type: application/json");
        $this->_http->addHeader("Authorization: Bearer " . $this->_token);
        $this->_http->setUrl($this->_createApiUrl("checkout/orders/" . $_SESSION['order_id']));
        return $this->_http->sendRequest();
    }

    /**
     *    Actual call to curl helper to execute a payment using PayPal REST APIs.
     *
     *    Reset curl helper.
     *    Set default PayPal headers.
     *    Set API call specific headers.
     *    Set curl url.
     *    Set curl body.
     *
     * @param  array  $postData  Url to be called using curl
     *
     * @return array PayPal REST execute response
     */
    private function _patchOrder($postData)
    {
        $this->_http->resetHelper();
        $this->_setDefaultHeaders();
        $this->_http->addHeader("Content-Type: application/json");
        $this->_http->addHeader("Authorization: Bearer " . $this->_token);
        $this->_http->setUrl($this->_createApiUrl("checkout/orders/" . $_SESSION['order_id']));
        $this->_http->setPatchBody($postData);
        return $this->_http->sendRequest();
    }

    /**
     *    Actual call to curl helper to authorize an order using PayPal REST APIs.
     *
     *    Reset curl helper.
     *    Set default PayPal headers.
     *    Set API call specific headers.
     *    Set curl url.
     *    Set curl body.
     *
     * @param  array  $postData  Url to be called using curl
     *
     * @return array PayPal REST capture response
     */
    private function _authorizeOrder($orderId)
    {
        $this->_http->resetHelper();
        $this->_setDefaultHeaders();
        $this->_http->addHeader("Content-Type: application/json");
        $this->_http->addHeader("Authorization: Bearer " . $this->_token);
        $this->_http->setUrl($this->_createApiUrl("checkout/orders/" . $orderId . "/authorize"));
        $postData = '{}';
        $this->_http->setBody($postData);
        return $this->_http->sendRequest();
    }

    /**
     *    Actual call to curl helper to capture an order using PayPal REST APIs.
     *
     *    Reset curl helper.
     *    Set default PayPal headers.
     *    Set API call specific headers.
     *    Set curl url.
     *    Set curl body.
     *
     * @param  array  $postData  Url to be called using curl
     *
     * @return array PayPal REST capture response
     */
    private function _captureOrder($orderId)
    {
        $this->_http->resetHelper();
        $this->_setDefaultHeaders();
        $this->_http->addHeader("Content-Type: application/json");
        $this->_http->addHeader("Authorization: Bearer " . $this->_token);
        $this->_http->setUrl($this->_createApiUrl("checkout/orders/" . $orderId . "/capture"));
        $postData = '{}';
        $this->_http->setBody($postData);
        return $this->_http->sendRequest();
    }

    /**
     *    Actual call to curl helper to capture an authorized order using PayPal REST APIs.
     *
     *    Reset curl helper.
     *    Set default PayPal headers.
     *    Set API call specific headers.
     *    Set curl url.
     *    Set curl body.
     *
     * @param  array  $postData  Url to be called using curl
     *
     * @return array PayPal REST capture response
     */
    private function _captureAuthorizedOrder($orderId)
    {
        $this->_http->resetHelper();
        $this->_setDefaultHeaders();
        $this->_http->addHeader("Content-Type: application/json");
        $this->_http->addHeader("Authorization: Bearer " . $this->_token);
        $this->_http->setUrl($this->_createApiUrl("payments/authorizations/" . $orderId . "/capture"));
        $postData = '{}';
        $this->_http->setBody($postData);
        return $this->_http->sendRequest();
    }

    /**
     *    Actual call to curl helper to cancel an order using PayPal REST APIs.
     *
     *    Reset curl helper.
     *    Set default PayPal headers.
     *    Set API call specific headers.
     *    Set curl url.
     *    Set curl body.
     *
     * @param  array  $postData  Url to be called using curl
     *
     * @return array PayPal REST capture response
     */
    private function _cancelOrder($orderId)
    {
        $this->_http->resetHelper();
        $this->_setDefaultHeaders();
        $this->_http->addHeader("Content-Type: application/json");
        $this->_http->addHeader("Authorization: Bearer " . $this->_token);
        $this->_http->setUrl($this->_createApiUrl("payments/authorizations/" . $orderId . "/void"));
        $postData = '{}';
        $this->_http->setBody($postData);
        return $this->_http->sendRequest();
    }

    /**
     *    Actual call to curl helper to refund an order using PayPal REST APIs.
     *
     *    Reset curl helper.
     *    Set default PayPal headers.
     *    Set API call specific headers.
     *    Set curl url.
     *    Set curl body.
     *
     * @param  array  $postData  Url to be called using curl
     *
     * @return array PayPal REST capture response
     */
    private function _refundPayment($orderId)
    {
        $this->_http->resetHelper();
        $this->_setDefaultHeaders();
        $this->_http->addHeader("Content-Type: application/json");
        $this->_http->addHeader("Authorization: Bearer " . $this->_token);
        $this->_http->setUrl($this->_createApiUrl("payments/captures/" . $orderId . "/refund"));
        $postData = '{}';
        $this->_http->setBody($postData);
        return $this->_http->sendRequest();
    }

    /**
     *    Call private order create class function to forward curl request to helper.
     *
     *    Get Access Token.
     *    Call internal REST userinfo function.
     *
     * @param  string  $code  Authorization code
     *
     * @return array Formatted API response
     */
    public function userInfo($code): array
    {
        $this->_getAccessToken($code);
        $returnData = $this->_getUserInfo();

        return [
            "ack"  => true,
            "data" => $returnData,
        ];
    }

    /**
     *    Call private order create class function to forward curl request to helper.
     *
     *    Check for bearer token.
     *    Call internal REST create order function.
     *
     * @param  array  $postData  Url to be called using curl
     *
     * @return array Formatted API response
     */
    public function orderCreate($postData)
    {
        if ($this->_token === null) {
            $this->_getToken();
        }
        $returnData           = $this->_createOrder($postData);
        $_SESSION['order_id'] = $returnData['id'];
        return [
            "ack"  => true,
            "data" => [
                "id"            => $returnData['id'],
                "approval_link" => $returnData['links'][1]['href'],
            ],
        ];
    }

    /**
     *    Call private payment get class function to forward curl request to helper.
     *
     *    Check for bearer token.
     *    Call internal REST get order details function.
     *
     * @param  array  $postData  Url to be called using curl
     *
     * @return array Formatted API response
     */
    public function orderGet()
    {
        if ($this->_token === null) {
            $this->_getToken();
        }
        $returnData = $this->_getOrderDetails();
        return [
            "ack"  => true,
            "data" => $returnData,
        ];
    }

    /**
     *    Call private patch order class function to forward curl request to helper.
     *
     *    Check for bearer token.
     *    Call internal REST patch order function.
     *
     * @param  array  $postData  Url to be called using curl
     *
     * @return array Formatted API response
     */
    public function orderPatch($postData)
    {
        if ($this->_token === null) {
            $this->_getToken();
        }
        $returnData = $this->_patchOrder($postData);
        return [
            "ack"  => true,
            "data" => $returnData,
        ];
    }

    /**
     *    Call private capture order class function to forward curl request to helper.
     *
     *    Check for bearer token.
     *    Call internal REST capture order function.
     *
     * @param         $orderId
     * @param  array  $postData  Url to be called using curl
     *
     * @return array Formatted API response
     */
    public function orderAuthorize($orderId = null)
    {
        if ($this->_token === null) {
            $this->_getToken();
        }

        if (empty($orderId)) {
            $orderId = $_SESSION['order_id'];
        }

        $returnData = $this->_authorizeOrder($orderId);
        return [
            "ack"  => true,
            "data" => $returnData,
        ];
    }

    /**
     *    Call private capture order class function to forward curl request to helper.
     *
     *    Check for bearer token.
     *    Call internal REST capture order function.
     *
     * @param         $orderId
     * @param  array  $postData  Url to be called using curl
     *
     * @return array Formatted API response
     */
    public function orderCapture($orderId = null)
    {
        if ($this->_token === null) {
            $this->_getToken();
        }

        if (empty($orderId)) {
            $orderId = $_SESSION['order_id'];
        }

        $returnData = $this->_captureOrder($orderId);
        return [
            "ack"  => true,
            "data" => $returnData,
        ];
    }

    /**
     *    Call private capture authorized order class function to forward curl request to helper.
     *
     *    Check for bearer token.
     *    Call internal REST capture order function.
     *
     * @param         $orderId
     * @param  array  $postData  Url to be called using curl
     *
     * @return array Formatted API response
     */
    public function orderCaptureAuthorized($orderId = null)
    {
        if ($this->_token === null) {
            $this->_getToken();
        }

        if (empty($orderId)) {
            $orderId = $_SESSION['order_id'];
        }

        $returnData = $this->_captureAuthorizedOrder($orderId);
        return [
            "ack"  => true,
            "data" => $returnData,
        ];
    }

    /**
     *    Call private capture order class function to forward curl request to helper.
     *
     *    Check for bearer token.
     *    Call internal REST capture order function.
     *
     * @param         $orderId
     * @param  array  $postData  Url to be called using curl
     *
     * @return array Formatted API response
     */
    public function orderCancel($orderId = null)
    {
        if ($this->_token === null) {
            $this->_getToken();
        }

        if (empty($orderId)) {
            $orderId = $_SESSION['order_id'];
        }

        $returnData = $this->_cancelOrder($orderId);
        return [
            "ack"  => true,
            "data" => $returnData,
        ];
    }

    /**
     *    Call private capture order class function to forward curl request to helper.
     *
     *    Check for bearer token.
     *    Call internal REST capture order function.
     *
     * @param         $orderId
     * @param  array  $postData  Url to be called using curl
     *
     * @return array Formatted API response
     */
    public function paymentRefund($orderId = null)
    {
        if ($this->_token === null) {
            $this->_getToken();
        }

        if (empty($orderId)) {
            $orderId = $_SESSION['order_id'];
        }

        $returnData = $this->_refundPayment($orderId);
        return [
            "ack"  => true,
            "data" => $returnData,
        ];
    }
}
