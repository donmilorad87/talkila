<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserReportTypeResource;
use App\ModelsApi\StaticProfession;
use App\ModelsApi\UserReportType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(
 *     name="Blockeds",
 *     description="Everything about Blockeds / UserBlocked",
 * )
 */


/**
 * @OA\Get(
 *      path="/v1/blocked-users",
 *      operationId="usersBlocked",
 *      tags={"Blockeds"},
 *      summary="Get list of UserBlocked",
 *      description="Returns list of UserBlocked",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/UserFollowedResource")
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 * Returns list of UserBlocked
 */

/**
 * Class UserBlockedApiController
 * @package App\Http\Controllers\Api\V1\Admin
 */
class UserReportedTypeApiController extends Controller
{
    /**
     * @return UserReportTypeResource
     */
    public function index(Request $request, $type)
    {
        try {
            Log::notice("\n\n".'::UserReportedTypeApiController::index::$request');
            Log::notice($request->all());

            $cancellationReason = UserReportType::query()->select(
                'id',
                StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', 'en')].' as value'
            )
                ->where('type', $type)
                ->where('state', UserReportType::STATE['valid']);

            $cancellationReason = $cancellationReason->get()->toArray();

            if (empty($cancellationReason)) {
                $response = response()->error(__('NO_REPORT_REASONS'), 200);

                Log::notice("\n\n".'::UserReportedTypeApiController::index::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->success([
                'message' => 'List of report reasons.',
                'data'    => [
                    'reasons' => $cancellationReason,
                ],
            ]);

            Log::notice("\n\n".'::UserReportedTypeApiController::index::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class.'::'.__FUNCTION__.' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4600,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_4600,
            //     'success' => false,
            // ], 500);

            return response()->error('Error: '.Handler::TYPE_EXCEPTION_4600, 500);
        }
    }
}
