<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiRequests\StoreProfilCvRequest;
use App\Http\Requests\ApiRequests\UpdateProfilCvRequest;
use App\ModelsApi\ProfilCv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


/**
 * @OA\Tag(
 *     name="ProfilCvs",
 *     description="Everything about ProfilCvs",
 * )
 */

/**
 * @OA\Post(
 *      path="/v1/profile-cvs",
 *      operationId="store",
 *      tags={"ProfilCvs"},
 *      summary="Get requested fields from form and create new ProfilCv",
 *      description="Get requested fields from form and create new ProfilCv",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/StoreProfilCvRequest")
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/ProfilCv")
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 */

/**
 * @OA\Put(
 *      path="/v1/profile-cvs/{profil_cv}",
 *      operationId="update",
 *      tags={"ProfilCvs"},
 *      summary="Get ProfilCvs update information",
 *      description="Get requested fields from form and update requested ProfilCv",
 *      @OA\Parameter(
 *          name="profil_cv",
 *          description="ProfilCv id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/UpdateProfilCvRequest")
 *      ),
 *      @OA\Response(
 *          response=202,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/ProfilCv")
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
 *      path="/v1/profile-cvs/{profil_cv}",
 *      operationId="destroy",
 *      tags={"ProfilCv"},
 *      summary="Delete ProfilCv",
 *      description="Take requested ProfilCv and delete it from system",
 *      @OA\Parameter(
 *          name="profil_cv",
 *          description="ProfilCv id",
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


/**
 * @OA\Get(
 *      path="/v1/profile-cvs/edit/{id}",
 *      operationId="editProfileCv",
 *      tags={"ProfilCv"},
 *      summary="Method editProfileCv of ProfilCvApiController",
 *      description="Method editProfileCv of ProfilCvApiController",
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
/**
 * @OA\Get(
 *      path="/v1/profil-user-cvs",
 *      operationId="userCv",
 *      tags={"ProfilCv"},
 *      summary="Method userCv of ProfilCvApiController",
 *      description="Method userCv of ProfilCvApiController",
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
/**
 * @OA\Post(
 *      path="/v1/profile-cvs-title",
 *      operationId="editProfileCsvTitle",
 *      tags={"ProfilCv"},
 *      summary="Method editProfileCsvTitle of ProfilCvApiController",
 *      description="Method editProfileCsvTitle of ProfilCvApiController",
 *
 *      @OA\Response(
 *          response=201,
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
/**
 * @OA\Post(
 *      path="/v1/profile-cvs-company",
 *      operationId="editProfileCsvCompany",
 *      tags={"ProfilCv"},
 *      summary="Method editProfileCsvCompany of ProfilCvApiController",
 *      description="Method editProfileCsvCompany of ProfilCvApiController",
 *
 *      @OA\Response(
 *          response=201,
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
/**
 * @OA\Post(
 *      path="/v1/profile-cvs-location",
 *      operationId="editProfileCsvLocation",
 *      tags={"ProfilCv"},
 *      summary="Method editProfileCsvLocation of ProfilCvApiController",
 *      description="Method editProfileCsvLocation of ProfilCvApiController",
 *
 *      @OA\Response(
 *          response=201,
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
/**
 * @OA\Post(
 *      path="/v1/profile-cvs-start-date",
 *      operationId="editProfileCsvStartDate",
 *      tags={"ProfilCv"},
 *      summary="Method editProfileCsvStartDate of ProfilCvApiController",
 *      description="Method editProfileCsvStartDate of ProfilCvApiController",
 *
 *      @OA\Response(
 *          response=201,
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
/**
 * @OA\Post(
 *      path="/v1/profile-cvs-end-date",
 *      operationId="editProfileCsvEndDate",
 *      tags={"ProfilCv"},
 *      summary="Method editProfileCsvEndDate of ProfilCvApiController",
 *      description="Method editProfileCsvEndDate of ProfilCvApiController",
 *
 *      @OA\Response(
 *          response=201,
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
/**
 * @OA\Post(
 *      path="/v1/profile-cvs-work-here",
 *      operationId="editProfileCsvWorkHere",
 *      tags={"ProfilCv"},
 *      summary="Method editProfileCsvWorkHere of ProfilCvApiController",
 *      description="Method editProfileCsvWorkHere of ProfilCvApiController",
 *
 *      @OA\Response(
 *          response=201,
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

/**
 * Class ProfilCvApiController
 * @package App\Http\Controllers\Api\V1\Admin
 */
class ProfilCvApiController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function userCv(Request $request)
    {
        try {
            $userCsv            = \App\Models\ProfilCv::query()->select('id', 'type', 'start_date', 'end_date', 'company_name', 'profession', 'location', 'work_here')->orderByDesc('start_date');
            if($request->has('user_id') && $request->input('user_id') != null) {
                $userCsv->where('user_id', $request->input('user_id'));
            } else {
                $userCsv->where('user_id', $request->user()->id);
            }

            $educationCv        = clone $userCsv;

            $groupedProfileCv   = [];

            $userJobCsv         = $userCsv->where('type', ProfilCv::TYPE['job'])->get()->toArray();
            $userEducationCsv   = $educationCv->where('type', ProfilCv::TYPE['education'])->get()->toArray();

            $groupedProfileCv['job']        = $userJobCsv;
            $groupedProfileCv['education']  = $userEducationCsv;

            if (empty($groupedProfileCv['job']) && empty($groupedProfileCv['education'])) {
                $response = response()->json([
                    'message' => 'There is no added CV-s.',
                    'success' => true
                ], 200);

                Log::notice("\n\n" . '::ProfilCvApiController::userCv::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->json([
                'data'    => $groupedProfileCv,
                'message' => 'Cv-s for logged in user grouped by type of CV.',
                'success' => true
            ], 200);

            Log::notice("\n\n" . '::ProfilCvApiController::userCv::$response');
            Log::notice($response);

            return $response;

        } catch (\Exception $exception) {
            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3400, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: '.Handler::TYPE_EXCEPTION_3400,
                'success' => false
            ], 500);
        }
    }

    /**
     * @param StoreProfilCvRequest $request
     * @return false|\Illuminate\Http\JsonResponse|object
     */
    public function store(StoreProfilCvRequest $request)
    {
        try {
            $countUserActiveCvs = ProfilCv::query()->count();

            if ($countUserActiveCvs < 31) {
                DB::beginTransaction();

                $profileCv = ProfilCv::query()->create($request->all())->toArray();

                Log::notice("\n\n" . '::ProfilCvApiController::store::$profileCv');
                Log::notice($profileCv);

                if (empty($profileCv)) {
                    DB::rollBack();
                    $response = response()->json([
                        'message' => 'Something went wrong, please try again.',
                        'success' => false
                    ], 200);

                    Log::notice("\n\n" . '::ProfilCvApiController::store::$response');
                    Log::notice($response);

                    return $response;
                }

                DB::commit();
                $response = response()->json([
                    'data'    => $profileCv,
                    'message' => 'User CV successfully added',
                    'success' => true
                ], 200);

                Log::notice("\n\n" . '::ProfilCvApiController::store::$response');
                Log::notice($response);

                return $response;

            } else {
                $response = response()->json([
                    'message' => 'User cannot have more then 31 added CV.',
                    'success' => true
                ], 200);

                return $response;
            }

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3401, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: '.Handler::TYPE_EXCEPTION_3401,
                'success' => false
            ], 500);
        }

    }

    /**
     * @param Request $request
     * @param $profilCv
     * @return \Illuminate\Http\JsonResponse
     */
    public function editProfileCv(Request $request, $profilCv)
    {
        try {
            Log::notice("\n\n" . '::ProfilCvApiController::editProfileCsvTitle::$request');
            Log::notice($request->all());

            $userCsv    = ProfilCv::query()->select('id', 'type', 'start_date', 'end_date', 'company_name', 'profession', 'location', 'work_here', 'profession_id')
                                           ->where('id', $profilCv)
                                           ->first()
                                           ->toArray();
            if (empty($userCsv)) {
                $response = response()->json([
                    'message' => 'There is no requested Profile CV.',
                    'success' => true
                ], 200);

                Log::notice("\n\n" . '::ProfilCvApiController::editProfileCv::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->json([
                'data'    => $userCsv,
                'message' => 'Data of requested Profile CV.',
                'success' => true
            ], 200);

            Log::notice("\n\n" . '::ProfilCvApiController::editProfileCv::$response');
            Log::notice($response);

            return $response;

        } catch (\Exception $exception) {
            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3402, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: '.Handler::TYPE_EXCEPTION_3402,
                'success' => false
            ], 500);
        }
    }

    /**
     * @param UpdateProfilCvRequest $request
     * @param ProfilCv $profilCv
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function update(UpdateProfilCvRequest $request, ProfilCv $profilCv)
    {
        Log::notice("\n\n" . '::ProfilCvApiController::update::$request');
        Log::notice($request->all());

        try {
            DB::beginTransaction();
            $updatedProfileCv   = $profilCv->update($request->all());

            DB::commit();
            if ($updatedProfileCv) {
                $response = response()->json([
                    'message' => 'Profile CV successfully updated.',
                    'success' => true
                ], 200);

                Log::notice("\n\n" . '::ProfilCvApiController::update::$response');
                Log::notice($response);

                return $response;

            } else {
                $response = response()->json([
                    'message' => 'Something went wrong, please check data and try again.',
                    'success' => true
                ], 200);

                Log::notice("\n\n" . '::ProfilCvApiController::update::$response');
                Log::notice($response);

                return $response;
            }

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3403, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: '.Handler::TYPE_EXCEPTION_3403,
                'success' => false
            ], 500);
        }
    }

    /**
     * @param ProfilCv $profilCv
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(ProfilCv $profilCv)
    {
        Log::notice("\n\n" . '::ProfilCvApiController::destroy::$profilCv');
        Log::notice($profilCv);

        try {
            DB::beginTransaction();

            $profilCv->delete();

            DB::commit();

            $response = response()->json([
                'message' => 'Profile CV successfully deleted.',
                'success' => true
            ], 200);

            Log::notice("\n\n" . '::ProfilCvApiController::destroy::$response');
            Log::notice($response);

            return $response;

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3404, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: '.Handler::TYPE_EXCEPTION_3404,
                'success' => false
            ], 500);
        }
    }

    /**
     * Edit Profile CSV profession
     *
     * @param Request $request
     * @return [string] message
     */
    public function editProfileCsvTitle(Request $request)
    {
        try {
            Log::notice("\n\n" . '::ProfilCvApiController::editProfileCsvTitle::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            if($request->has('id')) {
                $userCsv            = ProfilCv::query()->select('id', 'profession')
                                                       ->where('user_id', '=', $request->user()->id)
                                                       ->where('id', $request->input('id'))
                                                       ->first();

                $responseMessage    = 'Successfully updated experience profession';
            } else {
                $userCsv            = new ProfilCv;
                $responseMessage    = 'Successfully added experience profession';
            }

            $userCsv->profession    = $request->input('profession');
            $userCsv->save();

            DB::commit();
            $response = response()->json([
                'message' => $responseMessage,
                'success' => true
            ], 200);

            Log::notice("\n\n" . '::ProfilCvApiController::editProfileCsvTitle::$response');
            Log::notice($response);

            return $response;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3405, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: '.Handler::TYPE_EXCEPTION_3405,
                'success' => false
            ], 500);
        }
    }

    /**
     * Edit Profile CSV company_name
     *
     * @param Request $request
     * @return [string] message
     */
    public function editProfileCsvCompany(Request $request)
    {
        try {
            Log::notice("\n\n" . '::ProfilCvApiController::editProfileCsvCompany::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            if($request->has('id')) {
                $userCsv            = ProfilCv::query()->select('id', 'company_name')
                                                       ->where('user_id', '=', $request->user()->id)
                                                       ->where('id', $request->input('id'))
                                                       ->first();
                $responseMessage    = 'Successfully updated experience company_name';
            } else {
                $userCsv            = new ProfilCv;
                $responseMessage    = 'Successfully added experience company_name';
            }

            $userCsv->profession_id = $request->input('profession_id');
            $userCsv->type          = $request->input('type');
            $userCsv->start_date    = $request->input('start_date');
            $userCsv->end_date      = $request->input('end_date');
            $userCsv->company_name  = $request->input('company_name');
            $userCsv->profession    = $request->input('profession');
            $userCsv->location      = $request->input('location');
            $userCsv->work_here     = $request->input('work_here');
            $userCsv->save();

            DB::commit();
            $response = response()->json([
                'message' => $responseMessage,
                'success' => true
            ], 200);

            Log::notice("\n\n" . '::ProfilCvApiController::editProfileCsvCompany::$response');
            Log::notice($response);

            return $response;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3406, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: '.Handler::TYPE_EXCEPTION_3406,
                'success' => false
            ], 500);
        }
    }

    /**
     * Edit Profile CSV location
     *
     * @param Request $request
     * @return [string] message
     */
    public function editProfileCsvLocation(Request $request)
    {
        try {
            Log::notice("\n\n".'::ProfilCvApiController::editProfileCsvLocation::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            if($request->has('id')) {
                $userCsv            = ProfilCv::query()->select('id', 'location')
                                                       ->where('user_id', '=', $request->user()->id)
                                                       ->where('id', $request->input('id'))
                                                       ->first();
                $responseMessage    = 'Successfully updated experience location';
            } else {
                $userCsv            = new ProfilCv;
                $responseMessage    = 'Successfully added experience location';
            }

            $userCsv->location  = $request->input('location');
            $userCsv->save();
            DB::commit();
            $response = response()->json([
                'message' => $responseMessage,
                'success' => true
            ], 200);

            Log::notice("\n\n" . '::ProfilCvApiController::editProfileCsvCompany::$response');
            Log::notice($response);

            return $response;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3407, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: '.Handler::TYPE_EXCEPTION_3407,
                'success' => false
            ], 500);
        }
    }

    /**
     * Edit Profile CSV start_date
     *
     * @param Request $request
     * @return [string] message
     */
    public function editProfileCsvStartDate(Request $request)
    {
        try {
            Log::notice("\n\n" . '::ProfilCvApiController::editProfileCsvStartDate::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            $formattedStartDate = date('Y-m-d', strtotime($request->input('start_date')));

            if($request->has('id')) {
                $userCsv            = ProfilCv::query()->select('id', 'start_date')
                                                       ->where('user_id', '=', $request->user()->id)
                                                       ->where('id', $request->input('id'))
                                                       ->first();
                $responseMessage    = 'Successfully updated experience start_date';
            } else {
                $userCsv            = new ProfilCv;
                $responseMessage    = 'Successfully added experience start_date';
            }

            $userCsv->start_date    = $formattedStartDate;
            $userCsv->save();

            DB::commit();
            $response = response()->json([
                'message' => $responseMessage,
                'success' => true
            ], 200);

            Log::notice("\n\n" . '::ProfilCvApiController::editProfileCsvStartDate::$response');
            Log::notice($response);

            return $response;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3408, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: '.Handler::TYPE_EXCEPTION_3408,
                'success' => false
            ], 500);
        }
    }

    /**
     * Edit Profile CSV end_date
     *
     * @param Request $request
     * @return [string] message
     */
    public function editProfileCsvEndDate(Request $request)
    {
        try {
            Log::notice("\n\n" . '::ProfilCvApiController::editProfileCsvEndDate::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            $formattedEndDate = date('Y-m-d', strtotime($request->input('end_date')));

            if($request->has('id')) {
                $userCsv            = ProfilCv::query()->select('id', 'end_date')
                                                       ->where('user_id', '=', $request->user()->id)
                                                       ->where('id', $request->input('id'))
                                                       ->first();

                $responseMessage    = 'Successfully updated experience end_date';
            } else {
                $userCsv            = new ProfilCv;
                $responseMessage    = 'Successfully added experience end_date';
            }

            $userCsv->end_date      = $formattedEndDate;
            $userCsv->save();

            DB::commit();
            $response = response()->json([
                'message' => $responseMessage,
                'success' => true
            ], 200);

            Log::notice("\n\n" . '::ProfilCvApiController::editProfileCsvEndDate::$response');
            Log::notice($response);

            return $response;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3409, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: '.Handler::TYPE_EXCEPTION_3409,
                'success' => false
            ], 500);
        }
    }

    /**
     * Edit Profile CSV end_date
     *
     * @param Request $request
     * @return [string] message
     */
    public function editProfileCsvWorkHere(Request $request)
    {
        try {
            Log::notice("\n\n" . '::ProfilCvApiController::editProfileCsvWorkHere::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            if($request->has('id')) {
                $userCsv            = ProfilCv::query()->select('id', 'work_here')
                                                       ->where('user_id', '=', $request->user()->id)
                                                       ->where('id', $request->input('id'))
                                                       ->first();
                $responseMessage    = 'Successfully updated experience end_date';
            } else {
                $userCsv            = new ProfilCv;
                $responseMessage    = 'Successfully added experience end_date';
            }

            $userCsv->work_here      = $request->input('work_here') == null ? 0 : 1;
            $userCsv->save();

            DB::commit();
            $response = response()->json([
                'message' => $responseMessage,
                'success' => true
            ], 200);

            Log::notice("\n\n" . '::ProfilCvApiController::editProfileCsvWorkHere::$response');
            Log::notice($response);

            return $response;
        }
        catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3410, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: '.Handler::TYPE_EXCEPTION_3410,
                'success' => false
            ], 500);
        }
    }
}
