<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiRequests\StorePayoutRequest;
use App\Mail\PayoutSummaryMail;
use App\Models\Payout;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mail;


/**
 * @OA\Tag(
 *     name="Payouts",
 *     description="Everything about Payouts",
 * )
 */

/**
 * @OA\Get(
 *      path="/v1/payout-invoices",
 *      operationId="index",
 *      tags={"Payouts"},
 *      summary="Get list of Payouts",
 *      description="Returns list of Payouts",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/PayoutResource")
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 * Returns list of Payouts
 */

/**
 * @OA\Post(
 *      path="/v1/payout-invoices",
 *      operationId="store",
 *      tags={"Payouts"},
 *      summary="Get requested fields from form and create new Payout",
 *      description="Get requested fields from form and create new Payout",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/StorePayoutRequest")
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/Payout")
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 */


/**
 * Class PayoutsApiController
 * @package App\Http\Controllers\Api\V1\Admin
 */
class PayoutsApiController extends Controller
{
    public function index(Request $request)
    {
        try {
            Log::notice('::PayoutsApiController::index::$response');
            Log::notice($request->all());

            // Query below will return Payouts for all users.
            // $payouts = Payout::query()
            //     ->select([
            //         'id',
            //         'payout_date',
            //         'price',
            //         'invoice_number',
            //         'sales_tax',
            //         'reference',
            //         // 'transferred_date',
            //         // 'user_id',
            //         // 'finance_currencies_id',
            //     ])
            //     ->get()
            //     ->toArray();

            $payouts = $request->user()
                ->payouts()
                ->select([
                    'id',
                    'payout_date',
                    'price',
                    'invoice_number',
                    'sales_tax',
                    'reference',
                ])
                ->get()
                ->toArray();

            $current_earnings = auth()->user()->getCurrentEarnings(0, 0);

            if (empty($payouts)) {
                // $response = response()->json([
                //     'message' => 'There is no payouts.',
                //     'success' => true,
                // ], 200);

                $response = response()->success(__('NO_PAYOUTS'));

                Log::notice("\n\n" . '::PayoutsApiController::index::$response');
                Log::notice($response);

                return $response;
            }

            // $response = response()->success([
            //     'message' => 'All payouts data.',
            //     'data'    => $payouts,
            // ], 200);

            $response = response()->success([
                'message' => 'All payouts data.',
                'data'    => [
                    'total_earnings' => number_format($current_earnings->get('total'), 2),
                    'payouts' => $payouts,
                ],
            ]);

            Log::notice('::PayoutsApiController::index::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3200, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_3200,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  StorePayoutRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(StorePayoutRequest $request)
    {
        try {
            DB::beginTransaction();
            $payout = Payout::create($request->all());

            DB::commit();

            $response = response()->json([
                'data'    => $payout,
                'message' => 'Payout successfully created.',
                'success' => false,
            ], 200);

            Log::notice('::PayoutsApiController::store::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3201, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_3201,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * @OA\Get(
     *      path="/v1/user-payouts",
     *      operationId="userPayoutData",
     *      tags={"Payouts"},
     *      summary="Method userPayoutData of PayoutsApiController",
     *      description="Method userPayoutData of PayoutsApiController",
     *
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      @OA\Response(response=500, description="Server error"),
     *      @OA\Response(response=503, description="Service unavailable"),
     *      security={
     *         {
     *             "bearer_token": {}
     *         }
     *     },
     * )
     */
    public function userPayoutData(Request $request)
    {
        try {
            Log::notice('::PayoutsApiController::userPayoutData::$response');
            Log::notice($request->all());

            $payouts = Payout::query()
                ->select([
                    'id',
                    'payout_date',
                    'price',
                    'invoice_number',
                    'sales_tax',
                    'reference',
                    // 'transferred_date',
                    // 'user_id',
                    // 'finance_currencies_id',
                ])
                ->where('user_id', $request->user()->id)
                ->get()
                ->toArray();

            if (empty($payouts)) {
                $response = response()->json([
                    'message' => 'There is no payouts.',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . '::PayoutsApiController::userPayoutData::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->json([
                'data'    => [
                    'payouts' => $payouts,
                ],
                'message' => 'All payouts data.',
                'success' => false,
            ]);

            Log::notice('::PayoutsApiController::userPayoutData::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3203, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_3203,
                'success' => false,
            ], 500);
        }
    }

    /**
     * Show Payout Details.
     *
     * @param  int|string  $payout_id
     * @param  Request     $request
     *
     * @return mixed
     */
    public function show($payout_id, Request $request)
    {
        try {
            $payout = Payout::find($payout_id);
            $limit  = $request->input('limit');
            $offset = $request->input('offset');

            if (! $payout) {
                return response()->error(__('NO_PAYOUT'), 404);
            }

            if ($payout->user_id != $request->user()->id) {
                return response()->error(__('NO_PAYOUT'), 403);
            }

            $bookings = $payout->load('user', 'user.payoutMethod', 'bookings')->getBookings($limit, $offset);

            return response()->success([
                'message' => 'Payout retrieved!',
                'data'    => [
                    'payout_id'   => $payout->id,
                    'payout_date' => Carbon::parse($payout->payout_date)->format('d.m.Y H:i:s'),
                    'month'       => Carbon::parse($payout->payout_date)->format('F'),
                    'year'        => Carbon::parse($payout->payout_date)->format('Y'),
                    'talks_count' => $payout->bookings->count(),
                    'payout'      => number_format($payout->price, 2),
                    'duration'    => $this->getDuration($payout->bookings->sum('duration')),
                    'iban'        => $this->mask($payout->user->payoutMethod->value),
                    'name'        => $payout->user->name,
                    'bookings'    => $bookings,
                ],
            ]);
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3300, self::class, __FUNCTION__);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_3300, 500);
        }
    }

    public function currentEarnings(Request $request)
    {
        $user   = $request->user();
        $limit  = $request->input('limit');
        $offset = $request->input('offset');

        $current_earnings = $user->getCurrentEarnings(0, $offset);

        return response()->success([
            'message' => 'Current earnings',
            'data'    => [
                'payout'      => number_format($current_earnings->get('total'), 2),
                'talks_count' => $current_earnings->get('talks_count'),
                'duration'    => $this->getDuration($current_earnings->get('duration')),
                'iban'        => $this->mask($user->payoutMethod->value),
                'year'        => now()->format('Y'),
                'month'       => now()->format('F'),
                'name'        => $user->name,
                'bookings'    => $current_earnings->get('bookings'),
            ],
        ]);
    }

    /**
     * Send Payout Mail to the User.
     *
     * @param  Payout  $payout
     *
     * @return mixed
     */
    public function sendPayoutsMail(Payout $payout)
    {
        $payout = $payout->load('user', 'user.billing', 'user.billing.countries', 'user.payoutMethod', 'bookings', 'bookings.talk');

        try {
            Mail::to($payout->user->email)->queue(new PayoutSummaryMail($payout));
            return response()->success(__('SUCCESSFULLY_SENT_MAIL'));
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3300, self::class, __FUNCTION__);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_3300, 500);
        }
    }

    /**
     * Get Payout duration by converting minutes to hours.
     *
     * @param  int|string  $duration  Duration in minutes.
     *
     * @return string
     */
    protected function getDuration($duration): string
    {
        return floor($duration / 60) . 'hr ' . ($duration - floor($duration / 60) * 60) . 'min';
    }

    /**
     * Mask the string.
     *
     * @param  string  $string  String to mask.
     * @param  int     $offset  Masking offset.
     * @param  string  $char    Replacement character.
     *
     * @return string Masked string,
     */
    protected function mask(string $string, int $offset = 4, string $char = '*'): string
    {
        return substr($string, 0, $offset) . preg_replace('/[A-Za-z0-9]/', $char, substr($string, $offset, strlen($string) - $offset));
    }
}
