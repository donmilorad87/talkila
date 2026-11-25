<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Models\Notifications;
use App\ModelsApi\Language;
use App\ModelsApi\StaticProfession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class LanguagesApiController
 * @package App\Http\Controllers\Api\V1\Admin
 */

/**
 * @OA\Tag(
 *     name="Languages",
 *     description="Everything about Languages",
 * )
 */

/**
 * @OA\Get(
 *      path="/v1/languages",
 *      operationId="index",
 *      tags={"Languages"},
 *      summary="Get list of Languages",
 *      description="Returns list of Languages",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/LanguageResource")
 *       ),
 *       @OA\Response(response=400, description="Bad request"),
 *       security={
 *           {"bearer_token": {}}
 *       }
 *     )
 *
 * Returns list of Languages
 */
class LanguagesApiController extends Controller
{
    const GERMAN = 33;
    const ENGLISH = 38;
    const CROATIAN = 60;
    const POLISH = 127;

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, $pickedLanguages = null)
    {
        try {
            Log::notice("\n\n" . '::LanguagesApiController::index::$request');
            Log::notice($request->all());

            // List of available app languages.
            $app_languages = [
                'de' => self::GERMAN,
                'en' => self::ENGLISH,
                'hr' => self::CROATIAN,
                'pl' => self::POLISH
            ];

            $selected_language = $app_languages[$request->header('Application-Language')] ?? self::GERMAN;

            $languages = Language::query()
                ->select(['id', StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', session()->get('language') ?: 'en')] . ' as value'])
                // ->orderByRaw('-order_by DESC')
                // ->where('croatian', '!=', '')
                ->orderBy('id');

            if (! empty($pickedLanguages)) {
                $languages->whereIn('id', $pickedLanguages);
            }

            $languages = $languages->get()->toArray();

            if (empty($languages)) {
                $response = response()->json([
                    'message' => 'There is no languages',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::LanguagesApiController::index::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->json([
                'success'  => true,
                'message'  => 'List of available talk languages',
                'data'     => [
                    'selected' => $selected_language,
                    'languages' => $languages,
                ],
            ]);

            Log::notice("\n\n" . '::LanguagesApiController::index::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2900, self::class, __FUNCTION__);

            // return response()->json([
            //     'message' => 'Error: ' . Handler::TYPE_EXCEPTION_2900,
            //     'success' => false,
            // ], 500);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving languages.',
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            Log::notice("\n\n" . '::LanguagesApiController::update::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            $user = $request->user();

            if (is_null($user)) {
                $response = response()->json([
                    'message' => 'User not found',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::LanguagesApiController::update::$response');
                Log::notice($response);
                return $response;
            }

            $language   = $request->input('language');
            $dataErrors = [];

            if (empty($language)) {
                $dataErrors['language'] = [
                    'The Language value is required.',
                ];
            }

            if (! empty($dataErrors)) {
                $response = response()->json([
                    'errors'  => $dataErrors,
                    'message' => 'These fields are required',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileLanguage::$response');
                Log::notice($response);

                return $response;
            }

            $user->update(['last_language' => $language]);

            $notificationData = [
                'user_id' => $user->id,
                'type'    => 'custom',
                'value'   => Notifications::VALUE['language_settings_changed'],
            ];
            $notification     = NotificationsApiController::sendNotification($request, $notificationData);

            Log::notice("\n\n" . '::UserApiController::editProfileLanguage::$notification');
            Log::notice($notification);

            DB::commit();
            $response = response()->json([
                'message' => 'Successfully updated language',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserApiController::editProfileLanguage::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4009,
                self::class,
                __FUNCTION__
            );

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4009,
                'success' => false,
            ], 500);
        }
    }
}