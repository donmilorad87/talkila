<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\ModelsApi\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


/**
 * @OA\Tag(
 *     name="Countries",
 *     description="Everything about Countries",
 * )
 */

/**
 * @OA\Get(
 *      path="/v1/countries",
 *      operationId="index",
 *      tags={"Countries"},
 *      summary="Get list of Countries",
 *      description="Returns list of Countries",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/CountryResource")
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 * Returns list of Countries
 */

/**
 * @OA\Post(
 *      path="/v1/countries",
 *      operationId="store",
 *      tags={"Countries"},
 *      summary="Get requested fields from form and create new Countries",
 *      description="Get requested fields from form and create new Countries",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/StoreCountryRequest")
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/Country")
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 */

/**
 * @OA\Get(
 *      path="/v1/countries/{id}",
 *      operationId="show",
 *      tags={"Countries"},
 *      summary="Get Countries information",
 *      description="Returns Countries data",
 *      @OA\Parameter(
 *          name="id",
 *          description="Countries id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/Country")
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      security={
 *         {
 *             "bearer_token": {}
 *         }
 *     },
 * )
 */

/**
 * @OA\Put(
 *      path="/v1/countries/{id}",
 *      operationId="update",
 *      tags={"Countries"},
 *      summary="Get Countries update information",
 *      description="Get requested fields from form and update requested Countries",
 *      @OA\Parameter(
 *          name="id",
 *          description="Countries id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/UpdateCountryRequest")
 *      ),
 *      @OA\Response(
 *          response=202,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/Country")
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      security={
 *         {
 *             "bearer_token": {}
 *         }
 *     },
 * )
 */

/**
 * @OA\Delete(
 *      path="/v1/countries/{id}",
 *      operationId="destroy",
 *      tags={"Countries"},
 *      summary="Delete Countries",
 *      description="Take requested Countries and delete it from system",
 *      @OA\Parameter(
 *          name="id",
 *          description="Countries id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Response(
 *          response=204,
 *          description="successful operation"
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      security={
 *         {
 *             "bearer_token": {}
 *         }
 *     },
 * )
 */

class CountriesApiController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        Log::notice("\n\n" . '::CountriesApiController::index::$request');
        Log::notice($request->all());

        try {
            $language  = \App\Models\StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', session()->get('language') ?: 'en')];
            $countries = Country::query()
                ->whereHasVAT()
                ->select(['id', $language .' as value'])
                ->get()
                ->toArray();

            if (empty($countries)) {

                $response = response()->json([
                    'message' => 'There is no countries',
                    'success' => true
                ], 200);

                Log::notice("\n\n" . '::CountriesApiController::index::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->json([
                'data'      => $countries,
                'message'   => 'List of countries',
                'success'   => true
            ], 200);

            Log::notice("\n\n" . '::CountriesApiController::index::$response');
            Log::notice($response);

            return $response;

        }
        catch (\Exception $exception) {
            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2600, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: '.Handler::TYPE_EXCEPTION_2600,
                'success' => false
            ], 500);
        }
    }
}
