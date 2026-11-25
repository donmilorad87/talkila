<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    const PRIORITY = [
        'INFO'    => 0,
        'APP_LOG' => 1,
        'LOW'     => 2,
        'NORMAL'  => 3,
        'HIGH'    => 4,
        'URGENT'  => 5,
        'BLOCKER' => 6,
        'PAYMENT' => 7,
    ];

    // PayoutAndBookingsManagementController
    const TYPE_EXCEPTION_1000 = 1000;
    const TYPE_EXCEPTION_1001 = 1001;
    const TYPE_EXCEPTION_1002 = 1002;

    // AppFeedbackApiController
    const TYPE_EXCEPTION_2000 = 2000;
    const TYPE_EXCEPTION_2001 = 2001;

    // AppFeedbackController
    const TYPE_EXCEPTION_2002 = 2002;

    // AvailabilityApiController
    const TYPE_EXCEPTION_2100 = 2100;
    const TYPE_EXCEPTION_2101 = 2101;
    const TYPE_EXCEPTION_2102 = 2102;

    // AvailabilityApiController
    const TYPE_EXCEPTION_2200 = 2200;
    const TYPE_EXCEPTION_2201 = 2201;

    // BookingsApiController
    const TYPE_EXCEPTION_2300 = 2300;
    const TYPE_EXCEPTION_2301 = 2301;
    const TYPE_EXCEPTION_2302 = 2302;
    const TYPE_EXCEPTION_2303 = 2303;
    const TYPE_EXCEPTION_2304 = 2304;
    const TYPE_EXCEPTION_2305 = 2305;
    const TYPE_EXCEPTION_2306 = 2306;
    const TYPE_EXCEPTION_2307 = 2307;
    const TYPE_EXCEPTION_2308 = 2308;
    const TYPE_EXCEPTION_2309 = 2309;
    const TYPE_EXCEPTION_2310 = 2310;
    const TYPE_EXCEPTION_2311 = 2311;
    const TYPE_EXCEPTION_2312 = 2312;
    const TYPE_EXCEPTION_2313 = 2313;
    const TYPE_EXCEPTION_2314 = 2314;
    const TYPE_EXCEPTION_2315 = 2315;
    const TYPE_EXCEPTION_2316 = 2316;
    const TYPE_EXCEPTION_2317 = 2317;
    const TYPE_EXCEPTION_2318 = 2318;
    const TYPE_EXCEPTION_2319 = 2319;

    // BookingsPayoutApiController
    const TYPE_EXCEPTION_2400 = 2400;

    // CallsCancellationReasonApiController
    const TYPE_EXCEPTION_2500 = 2500;

    // CountriesApiController
    const TYPE_EXCEPTION_2600 = 2600;

    // FeedbackApiController
    const TYPE_EXCEPTION_2700 = 2700;
    const TYPE_EXCEPTION_2701 = 2701;
    const TYPE_EXCEPTION_2702 = 2702;
    const TYPE_EXCEPTION_2703 = 2703;
    const TYPE_EXCEPTION_2704 = 2704;

    // JoinTheClubApiController
    const TYPE_EXCEPTION_2800 = 2800;
    const TYPE_EXCEPTION_2801 = 2801;
    const TYPE_EXCEPTION_2802 = 2802;
    const TYPE_EXCEPTION_2803 = 2803;
    const TYPE_EXCEPTION_2804 = 2804;
    const TYPE_EXCEPTION_2805 = 2805;
    const TYPE_EXCEPTION_2806 = 2806;
    const TYPE_EXCEPTION_2807 = 2807;

    // LanguagesApiController
    const TYPE_EXCEPTION_2900 = 2900;
    const TYPE_EXCEPTION_2901 = 2901;
    const TYPE_EXCEPTION_2902 = 2902;

    // NotificationsApiController
    const TYPE_EXCEPTION_3000 = 3000;
    const TYPE_EXCEPTION_3001 = 3001;
    const TYPE_EXCEPTION_3002 = 3002;
    const TYPE_EXCEPTION_3003 = 3003;
    const TYPE_EXCEPTION_3004 = 3004;
    const TYPE_EXCEPTION_3005 = 3005;
    const TYPE_EXCEPTION_3006 = 3006;
    const TYPE_EXCEPTION_3007 = 3007;
    const TYPE_EXCEPTION_3008 = 3008;

    // PageApiController
    const TYPE_EXCEPTION_3100 = 3100;

    // PageApiController
    const TYPE_EXCEPTION_3200 = 3200;
    const TYPE_EXCEPTION_3201 = 3201;
    const TYPE_EXCEPTION_3202 = 3202;
    const TYPE_EXCEPTION_3203 = 3203;

    // PayoutsMethodsApiController
    const TYPE_EXCEPTION_3300 = 3300;
    const TYPE_EXCEPTION_3301 = 3301;

    // ProfileCVApiController
    const TYPE_EXCEPTION_3400 = 3400;
    const TYPE_EXCEPTION_3401 = 3401;
    const TYPE_EXCEPTION_3402 = 3402;
    const TYPE_EXCEPTION_3403 = 3403;
    const TYPE_EXCEPTION_3404 = 3404;
    const TYPE_EXCEPTION_3405 = 3405;
    const TYPE_EXCEPTION_3406 = 3406;
    const TYPE_EXCEPTION_3407 = 3407;
    const TYPE_EXCEPTION_3408 = 3408;
    const TYPE_EXCEPTION_3409 = 3409;
    const TYPE_EXCEPTION_3410 = 3410;

    // ProfileCVApiController
    const TYPE_EXCEPTION_3500 = 3500;
    const TYPE_EXCEPTION_3501 = 3501;

    // SearchesApiController
    const TYPE_EXCEPTION_3600 = 3600;
    const TYPE_EXCEPTION_3601 = 3601;

    // StaticProfessionsApiController
    const TYPE_EXCEPTION_3700 = 3700;
    const TYPE_EXCEPTION_3701 = 3701;

    // TalkCategoriesApiController
    const TYPE_EXCEPTION_3800 = 3800;
    const TYPE_EXCEPTION_3801 = 3801;

    // TalksApiController
    const TYPE_EXCEPTION_3900 = 3900;
    const TYPE_EXCEPTION_3901 = 3901;
    const TYPE_EXCEPTION_3902 = 3902;
    const TYPE_EXCEPTION_3903 = 3903;
    const TYPE_EXCEPTION_3904 = 3904;
    const TYPE_EXCEPTION_3905 = 3905;
    const TYPE_EXCEPTION_3906 = 3906;
    const TYPE_EXCEPTION_3907 = 3907;
    const TYPE_EXCEPTION_3908 = 3908;
    const TYPE_EXCEPTION_3909 = 3909;
    const TYPE_EXCEPTION_3910 = 3910;
    const TYPE_EXCEPTION_3911 = 3911;
    const TYPE_EXCEPTION_3912 = 3912;

    // UserApiController
    const TYPE_EXCEPTION_4000 = 4000;
    const TYPE_EXCEPTION_4001 = 4001;
    const TYPE_EXCEPTION_4002 = 4002;
    const TYPE_EXCEPTION_4003 = 4003;
    const TYPE_EXCEPTION_4004 = 4004;
    const TYPE_EXCEPTION_4005 = 4005;
    const TYPE_EXCEPTION_4006 = 4006;
    const TYPE_EXCEPTION_4007 = 4007;
    const TYPE_EXCEPTION_4008 = 4008;
    const TYPE_EXCEPTION_4009 = 4009;
    const TYPE_EXCEPTION_4010 = 4010;
    const TYPE_EXCEPTION_4011 = 4011;
    const TYPE_EXCEPTION_4012 = 4012;
    const TYPE_EXCEPTION_4013 = 4013;
    const TYPE_EXCEPTION_4014 = 4014;
    const TYPE_EXCEPTION_4015 = 4015;
    const TYPE_EXCEPTION_4016 = 4016;
    const TYPE_EXCEPTION_4017 = 4017;
    const TYPE_EXCEPTION_4018 = 4018;
    const TYPE_EXCEPTION_4019 = 4019;
    const TYPE_EXCEPTION_4020 = 4020;
    const TYPE_EXCEPTION_4021 = 4021;
    const TYPE_EXCEPTION_4022 = 4022;
    const TYPE_EXCEPTION_4023 = 4023;
    const TYPE_EXCEPTION_4024 = 4024;
    const TYPE_EXCEPTION_4025 = 4025;

    // UserBookmarkedTalksApiController
    const TYPE_EXCEPTION_4100 = 4100;
    const TYPE_EXCEPTION_4101 = 4101;
    const TYPE_EXCEPTION_4102 = 4102;
    const TYPE_EXCEPTION_4103 = 4103;
    const TYPE_EXCEPTION_4104 = 4104;

    // UserFollowedApiController
    const TYPE_EXCEPTION_4200 = 4200;
    const TYPE_EXCEPTION_4201 = 4201;
    const TYPE_EXCEPTION_4202 = 4202;
    const TYPE_EXCEPTION_4203 = 4203;
    const TYPE_EXCEPTION_4204 = 4204;
    const TYPE_EXCEPTION_4205 = 4205;
    const TYPE_EXCEPTION_4206 = 4206;
    const TYPE_EXCEPTION_4207 = 4207;
    const TYPE_EXCEPTION_4208 = 4208;
    const TYPE_EXCEPTION_4209 = 4209;
    const TYPE_EXCEPTION_4210 = 4210;

    // UsersApiController
    const TYPE_EXCEPTION_4300 = 4300;
    const TYPE_EXCEPTION_4301 = 4301;

    // UserBlockedApiController
    const TYPE_EXCEPTION_4400 = 4400;
    const TYPE_EXCEPTION_4401 = 4401;
    const TYPE_EXCEPTION_4402 = 4402;

    // UserReportedApiController
    const TYPE_EXCEPTION_4500 = 4500;
    const TYPE_EXCEPTION_4501 = 4501;
    const TYPE_EXCEPTION_4502 = 4502;

    // UserReportedTypeApiController
    const TYPE_EXCEPTION_4600 = 4600;

    // AdyenPaymentController
    const TYPE_EXCEPTION_5000 = 5000;
    const TYPE_EXCEPTION_5001 = 5001;
    const TYPE_EXCEPTION_5002 = 5002;
    const TYPE_EXCEPTION_5003 = 5003;
    const TYPE_EXCEPTION_5004 = 5004;
    const TYPE_EXCEPTION_5005 = 5005;
    const TYPE_EXCEPTION_5006 = 5006;
    const TYPE_EXCEPTION_5007 = 5007;
    const TYPE_EXCEPTION_5008 = 5008;
    const TYPE_EXCEPTION_5009 = 5009;
    const TYPE_EXCEPTION_5010 = 5010;

    // WalletController
    const TYPE_EXCEPTION_6000 = 6000;
    const TYPE_EXCEPTION_6001 = 6001;
    const TYPE_EXCEPTION_6002 = 6002;
    const TYPE_EXCEPTION_6003 = 6003;
    const TYPE_EXCEPTION_6004 = 6004;
    const TYPE_EXCEPTION_6005 = 6005;
    const TYPE_EXCEPTION_6006 = 6006;

    // WalletHistory
    const TYPE_EXCEPTION_6100 = 6100;
    const TYPE_EXCEPTION_6101 = 6101;
    const TYPE_EXCEPTION_6102 = 6102;

    // CreditCardController
    const TYPE_EXCEPTION_7000 = 7000;
    const TYPE_EXCEPTION_7001 = 7001;
    const TYPE_EXCEPTION_7002 = 7002;
    const TYPE_EXCEPTION_7003 = 7003;
    const TYPE_EXCEPTION_7004 = 7004;

    // StripeController
    const TYPE_EXCEPTION_8000 = 8000;
    const TYPE_EXCEPTION_8001 = 8001;
    const TYPE_EXCEPTION_8002 = 8002;
    const TYPE_EXCEPTION_8003 = 8003;
    const TYPE_EXCEPTION_8004 = 8004;
    const TYPE_EXCEPTION_8005 = 8005;
    const TYPE_EXCEPTION_8006 = 8006;
    const TYPE_EXCEPTION_8007 = 8007;
    const TYPE_EXCEPTION_8008 = 8008;
    const TYPE_EXCEPTION_8009 = 8009;
    const TYPE_EXCEPTION_8010 = 8010;
    const TYPE_EXCEPTION_8011 = 8011;
    const TYPE_EXCEPTION_8012 = 8012;
    const TYPE_EXCEPTION_8013 = 8013;
    const TYPE_EXCEPTION_8014 = 8014;

    // StripeEventListener
    const TYPE_EXCEPTION_8100 = 8100;
    const TYPE_EXCEPTION_8101 = 8101;

    // PaymentController
    const TYPE_EXCEPTION_9000 = 9000;
    const TYPE_EXCEPTION_9001 = 9001;
    const TYPE_EXCEPTION_9002 = 9002;

    // StartNewRooms
    const TYPE_EXCEPTION_9800 = 9800;
    const TYPE_EXCEPTION_9801 = 9801;
    const TYPE_EXCEPTION_9802 = 9802;

    // PayPalController
    const TYPE_EXCEPTION_10000 = 10000;
    const TYPE_EXCEPTION_10001 = 10001;
    const TYPE_EXCEPTION_10002 = 10002;
    const TYPE_EXCEPTION_10003 = 10003;
    const TYPE_EXCEPTION_10004 = 10004;
    const TYPE_EXCEPTION_10005 = 10005;
    const TYPE_EXCEPTION_10006 = 10006;
    const TYPE_EXCEPTION_10007 = 10007;
    const TYPE_EXCEPTION_10008 = 10008;
    const TYPE_EXCEPTION_10009 = 10009;


    // UserAppPermissionAPIController
    const TYPE_EXCEPTION_11000 = 11000;
    const TYPE_EXCEPTION_11001 = 11001;


    // PartnerAPIController
    const TYPE_EXCEPTION_12000 = 12000;

    /**
     * Report or log an exception.
     *
     * @param  Throwable  $e
     * @param  int        $priority
     * @param  int        $code
     * @param  string     $class
     * @param  string     $method
     * @param  array      $params
     *
     * @return void
     *
     * @throws Throwable
     */
    public function report(Throwable $e, int $priority = self::PRIORITY['APP_LOG'], int $code = self::TYPE_EXCEPTION_1000, string $class = 'APP_LOG', string $method = 'APP_LOG', array $params = [])
    {
        // TODO Handle all exceptions accordinly and log into db and/or slack

        // Handle exception in case Route Model binding fails.
        if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => __('REQUEST_FAILED'). '.',
                ], Response::HTTP_NOT_FOUND)
            );
        }

        // Hide exception related to expired access token.
        if ($e instanceof \League\OAuth2\Server\Exception\OAuthServerException && $e->getCode() == 9) {
            return;
        }

        // Hide exception related to Stripe 3DS payment.
        if ($e instanceof \Laravel\Cashier\Exceptions\IncompletePayment) {
            return;
        }


        parent::report($e);
    }

    /**
     * Handle unauthenticated user — redirect web requests to login.
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request    $request
     * @param  Throwable  $e
     *
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response
    {
        return parent::render($request, $e);
    }
}
