<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Entity\CallTypes;
use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\ModelsApi\StaticProfession;
use App\ModelsApi\Talk;
use App\ModelsApi\TalkCategories;
use App\ModelsApi\TalkSubcategories;
use App\ModelsApi\UserBookmarkedTalks;
use App\ModelsApi\UserFollowed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


/**
 *
 * @OA\Tag(
 *     name="Talk Categories",
 *     description="API Endpoints of TalkCategories"
 * )
 */


/**
 * @OA\Post(
 *      path="/v1/talk-categories",
 *      operationId="store",
 *      tags={"Talk Categories"},
 *      summary="Get requested fields from form and create new autocomplete tag",
 *      description="Get requested fields from form and create new autocomplete tag",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/StoreTalkCategoriesRequest")
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/TalkCategories")
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
 *      path="/v1/talk-categories/{id}",
 *      operationId="show",
 *      tags={"Talk Categories"},
 *      summary="Get Talk Categories information",
 *      description="Returns Talk Categories data",
 *      @OA\Parameter(
 *          name="id",
 *          description="Talk Categories id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/TalkCategories")
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      security={
 *         {
 *             "bearer_token": {"write:talk-categories", "read:talk-categories"}
 *         }
 *     },
 * )
 */

/**
 * @OA\Put(
 *      path="/v1/talk-categories/{id}",
 *      operationId="update",
 *      tags={"Talk Categories"},
 *      summary="Get Talk Categories update information",
 *      description="Get requested fields from form and update requested Talk Categories",
 *      @OA\Parameter(
 *          name="id",
 *          description="Talk Categories id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/UpdateTalkCategoriesRequest")
 *      ),
 *      @OA\Response(
 *          response=202,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/TalkCategories")
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      security={
 *         {
 *             "bearer_token": {"write:talk-categories", "read:talk-categories"}
 *         }
 *     },
 * )
 */

/**
 * @OA\Delete(
 *      path="/v1/talk-categories/{id}",
 *      operationId="destroy",
 *      tags={"Talk Categories"},
 *      summary="Delete Talk Categories",
 *      description="Take requested Talk Categories and delete it from system",
 *      @OA\Parameter(
 *          name="id",
 *          description="Talk Categories id",
 *          required=true,
 *          in="path",
 *          @OA\Schema(
 *              type="integer"
 *          )
 *      ),
 *      @OA\Response(
 *          response=204,
 *          description="successful operation",
 *          @OA\JsonContent()
 *       ),
 *      @OA\Response(response=400, description="Bad request"),
 *      @OA\Response(response=404, description="Resource Not Found"),
 *      security={
 *         {
 *             "bearer_token": {"write:talk-categories", "read:talk-categories"}
 *         }
 *     },
 * )
 */


/**
 * @OA\Get(
 *      path="/v1/talk-categories",
 *      operationId="getTalkCategories",
 *      tags={"Talk Categories"},
 *      summary="Method getTalkCategories of TalkCategoriesApiController",
 *      description="Method getTalkCategories of TalkCategoriesApiController",
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
 *      path="/v1/talk-subcategories",
 *      operationId="getTalkSubcategories",
 *      tags={"Talk Categories"},
 *      summary="Method getTalkSubcategories of TalkCategoriesApiController",
 *      description="Method getTalkSubcategories of TalkCategoriesApiController",
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
class TalkCategoriesApiController extends Controller
{
    public function getTalkCategories(Request $request)
    {
        try {
            Log::notice("\n\n" . '::TalkCategoriesApiController::getTalkCategories::$request');
            Log::notice($request->all());

            // Include / Exclude categories and subcategories without talks (search)
            // 1 = include (default)
            // 0 = exclude
            $includedCatAndSubcatWithoutTalks = $request->input('subcategories_with_no_talks_included', 1);
            $includedGroupTalks               = $request->input('group_talks_included', 1);
            $includedOnlyTeachers             = $request->input('only_active_teachers', null);
            $includedTeachersFavorites        = $request->input('teacher_favorites', null);
            $userLanguage                     = StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language') ?: session('language')];

            $talkCategories = TalkCategories::query()
                ->select(['id', $userLanguage . ' as value', 'english as engname'])
                ->with([
                    'subcategories' => function ($query) use ($userLanguage, $includedGroupTalks, $includedOnlyTeachers, $includedTeachersFavorites, $includedCatAndSubcatWithoutTalks) {
                        $query->select('id', $userLanguage . ' as value', 'talk_categories_id', 'english as engname');
                        $query->withCount([
                            'talks' => function ($item) use ($includedGroupTalks, $includedOnlyTeachers, $includedTeachersFavorites) {
                                $item->where('talks.state', Talk::STATE['valid']);
                                $item->withEligibleSuppliers();
                                if ($includedGroupTalks == 0) {
                                    $item->where('call_type', CallTypes::ONE_TO_ONE);
                                }
                                if ($includedOnlyTeachers == 1) {
                                    $teacherUsers = User::query()->where('type', User::TYPE['supplier'])->get()->pluck('id')->toArray();
                                    $item->whereIn('teacher_user_id', $teacherUsers);
                                }
                                if ($includedTeachersFavorites == 1) {
                                    $bookmarkedTalks = UserBookmarkedTalks::query()->where('state', UserBookmarkedTalks::STATE['valid'])
                                        ->where('user_id', auth()->user()->id)
                                        ->pluck('talks_id')
                                        ->toArray();
                                    $item->whereIn('id', $bookmarkedTalks);
                                } else {
                                    if ($includedTeachersFavorites == 2) {
                                        $bookmarkedUsers = UserFollowed::query()->where('state', UserBookmarkedTalks::STATE['valid'])
                                            ->where('user_id', auth()->user()->id)
                                            ->pluck('follower_user_id')
                                            ->toArray();
                                        $teacherTalks    = Talk::query()->select('id')->whereIn('teacher_user_id', $bookmarkedUsers)->get()->pluck('id')->toArray();
                                        $item->whereIn('id', $teacherTalks);
                                    }
                                }
                            },
                        ]);
                        if ($includedCatAndSubcatWithoutTalks == 0) {
                            $query->having('talks_count', '>', 0);
                        }
                    },
                    'talks'         => function ($query) {
                        $query->select(['talks.id', 'talks.headline', 'talks.description', 'talks.duration', 'talks.price', 'talks.talk_type', 'talks.reviews', 'talks.anonym_call as is_anonymous_allowed', 'talks.state', 'talks.talk_categories_id', 'talks.teacher_user_id']);
                        $query->selectRaw('CAST(CASE WHEN SUM(reviews) > 0 THEN ROUND(SUM(ratings)::NUMERIC / SUM(reviews)::NUMERIC, 1) ELSE 0 END AS NUMERIC(10,1)) AS ratings');
                        $query->where('talks.state', Talk::STATE['valid']);
                        $query->withEligibleSuppliers();
                        $query->with('supplier:id,name,username,profile_picture,profile_picture_tmp');
                        $query->groupBy('talks.id', 'talks.headline', 'talks.description', 'talks.duration', 'talks.price', 'talks.talk_type', 'talks.reviews', 'talks.anonym_call', 'talks.state', 'talks.talk_categories_id', 'talks.teacher_user_id');
                    },
                ])
                ->orderBy('value')
                ->get();

            if ($talkCategories->count() < 1) {
                $response = response()->error(__('NO_CATEGORIES'));

                Log::notice("\n\n" . '::TalkCategoriesApiController::getTalkCategories::$response');
                Log::notice($response);

                return $response;
            }

            if ($includedCatAndSubcatWithoutTalks == 0) {
                foreach ($talkCategories as $key => $subcategory) {
                    if ($subcategory->subcategories->count() <= 0) {
                        unset($talkCategories[$key]);
                    }
                }
            }

            $talkCategoriesData = $talkCategories->values();

            foreach ($talkCategoriesData as $key => $talkCategory) {
                $totalTalksCount = 0;
                foreach ($talkCategory['subcategories'] as $subcategory) {
                    $totalTalksCount += $subcategory['talks_count'];
                }
                $talkCategoriesData[$key]['talks_count'] = $totalTalksCount;
            }

            $response = response()->success([
                'message' => 'List of talk categories',
                'data'    => $talkCategoriesData,
            ]);

            Log::notice("\n\n" . '::TalkCategoriesApiController::getTalkCategories::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3800, self::class, __FUNCTION__);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_3800, 500);
        }
    }

    public function getTalkSubcategories(Request $request)
    {
        try {
            Log::notice("\n\n" . '::TalkCategoriesApiController::getTalkSubcategories::$request');
            Log::notice($request->all());

            $talkCategories = TalkSubcategories::query()->where('talk_categories_id', $request->input('category_id'))
                ->select('id', StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', 'en')] . ' as value')
                ->get();

            if ($talkCategories->count() < 1) {
                $response = response()->error(__('NO_SUBCATEGORIES'));

                Log::notice("\n\n" . '::TalkCategoriesApiController::getTalkSubcategories::$response');
                Log::notice($response);

                return $response;
            }

            // $response = response()->json([
            //     'data'    => $talkCategories,
            //     'message' => 'List of talk categories',
            //     'success' => true,
            // ], 200);

            $response = response()->success([
                'message' => 'List of talk categories',
                'data'    => $talkCategories,
            ]);

            Log::notice("\n\n" . '::TalkCategoriesApiController::getTalkSubcategories::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3801, self::class, __FUNCTION__);

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_3801,
            //     'success' => false
            // ], 500);
            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_3801, 500);
        }
    }
}