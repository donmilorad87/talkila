<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStaticProfessionRequest;
use App\ModelsApi\StaticProfession;
use App\ModelsApi\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StaticProfessionsApiController extends Controller
{
    /**
     * @param  StoreStaticProfessionRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreStaticProfessionRequest $request)
    {
        Log::notice("\n\n" . '::StaticProfessionsApiController::store::$request');
        Log::notice($request->all());

        try {
            $requestedLanguage = StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', 'en')];

            $existingProfession = StaticProfession::query()->where(
                $requestedLanguage,
                $request->input('profession')
            )->first();


            if (empty($existingProfession)) {
                $staticProfession                     = new StaticProfession;
                $staticProfession[$requestedLanguage] = $request->input('profession');
                $staticProfession->save();

                // $response = response()->json([
                //     'data' => $staticProfession,
                //     'message' => 'You\'re trying to add already existing profession.',
                //     'success' => false
                // ], 200);

                $response = response()->error([
                    'message' => 'You\'re trying to add already existing profession.',
                    'data'    => [
                        'professions' => $staticProfession,
                    ],
                ]);

                Log::notice("\n\n" . '::StaticProfessionsApiController::store::$response');
                Log::notice($response);

                return $response;
            } else {
                // $response = response()->json([
                //     'request'             => $request->all(),
                //     'profession'          => $request->input('profession'),
                //     'language'            => $requestedLanguage,
                //     'existing_profession' => $existingProfession,
                //     'error'               => 'You\'re trying to add already existing profession.',
                //     'success'             => false,
                // ], 200);

                // $response = response()->error([
                //     'message' => 'You\'re trying to add already existing profession.',
                //     'data'    => [
                //         'request'     => $request->all(),
                //         'professions' => [
                //             'new'      => $request->input('profession'),
                //             'existing' => $existingProfession,
                //         ],
                //         'language'    => $requestedLanguage,
                //         'error'       => 'You\'re trying to add already existing profession.',
                //     ],
                // ]);

                $response = response()->error([
                    'message' => 'You\'re trying to add already existing profession.',
                    'data'    => [
                        'request'             => $request->all(),
                        'profession'          => $request->input('profession'),
                        'language'            => $requestedLanguage,
                        'existing_profession' => $existingProfession,
                        'error'               => 'You\'re trying to add already existing profession.',
                    ],
                ]);

                Log::notice("\n\n" . '::StaticProfessionsApiController::store::$response');
                Log::notice($response);

                return $response;
            }
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_3700,
                self::class,
                __FUNCTION__
            );
            //
            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_3700,
            //     'success' => false,
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_3700, 500);
        }
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfession(Request $request)
    {
        Log::notice("\n\n" . '::StaticProfessionsApiController::getProfession::$request');
        Log::notice($request->all());

        try {
            $requestedLanguage = StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', 'en')];
            $requestedSearch   = $request->input('search');


            $staticProfessions = StaticProfession::query()
                ->select([
                    'id',
                    StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', 'en')] . ' as value',
                ])
                ->where($requestedLanguage, 'LIKE', '%' . $requestedSearch . '%')
                ->get()
                ->toArray();

            if (empty($staticProfessions)) {
                $response = response()->error(__('NO_PROFESSIONS'));

                Log::notice("\n\n" . '::StaticProfessionsApiController::getProfession::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->success([
                'message' => __('LIST_PROFESSIONS'),
                'data'    => $staticProfessions,
            ]);

            Log::notice("\n\n" . '::StaticProfessionsApiController::getProfession::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_3700,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_3700,
            //     'success' => false,
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_3700, 500);
        }
    }

    /**
     * @param  Request  $request
     * @param           $professionId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function setUserProfession(Request $request, $professionId)
    {
        try {
            Log::notice("\n\n" . '::StaticProfessionsApiController::setUserProfession::$request');
            Log::notice($request->all());

            Log::notice("\n\n" . '::StaticProfessionsApiController::setUserProfession::$professionId');
            Log::notice($professionId);

            User::query()->find($request->user()->id)->update(['profession_id' => $professionId]);

            $response = response()->success(__('SUCCESSFULLY_CREATED_PROFESSION'));

            Log::notice("\n\n" . '::StaticProfessionsApiController::setUserProfession::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_3701,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_3701,
            //     'success' => false,
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_3701, 500);
        }
    }
}
