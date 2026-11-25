<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\ModelsApi\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class PageApiController
 * @package App\Http\Controllers\Api\V1\Admin
 */
class PageApiController extends Controller
{
    /**
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    /**
     * @OA\Get(
     *      path="/v1/static/{slug}",
     *      operationId="dynamic_page",
     *      tags={"Page"},
     *      summary="Method dynamic_page of PageApiController",
     *      description="Method dynamic_page of PageApiController",
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
    public function dynamic_page(Request $request, $slug)
    {
        try {
            if ($slug == 'recaptcha')
                return view('admin.pages.recaptcha');

            $content = Pages::query()->where('slug', $slug)->first();

            if (empty($content)) {
                return response()->error(__('REQUEST_FAILED'));
            }

            $response = response()->success([
                'message' => 'Requested dynamic page.',
                'data' => $content,
            ]);

            Log::notice("\n\n" . '::ProfilCvApiController::userCv::$response');
            Log::notice($response);

            return $response;

        }
        catch (\Exception $exception) {
            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3100, self::class, __FUNCTION__);

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_3100,
            //     'success' => false
            // ], 500);

            return response()->error('Error: '.Handler::TYPE_EXCEPTION_3100, 500);
        }
    }
}
