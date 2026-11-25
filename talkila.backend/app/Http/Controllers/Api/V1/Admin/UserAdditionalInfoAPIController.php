<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exceptions\Handler;
use App\Http\Requests\ApiRequests\StoreUserAdditionalInfoRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UserAdditionalInfoAPIController
{
    public function index(Request $request)
    {
        Log::notice("\n\n" . '::UserAdditionalInfoAPIController::index::$request');
        Log::notice(json_encode($request->all()));

        try {
            $additionalInfo = $request->user()
                ->additionalInfo()
                ->get([
                    'data',
                ]);

            if ($additionalInfo->isEmpty()) {
                $response = response()->success('User has no Additional Info.');
            } else {
                $response = response()->success([
                    'message' => 'User Additional Info retrieved successfully!',
                    'data'    => [
                        'user_additional_info' => $additionalInfo,
                    ],
                ]);
            }

            Log::notice("\n\n" . '::UserAdditionalInfoAPIController::index::$response');
            Log::notice($response);

            return $response;

        } catch (Exception $exception) {
            DB::rollBack();

            Log::notice("\n\n" . '::UserAdditionalInfoAPIController::index::$exception');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_11000, self::class, __FUNCTION__);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_11000, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreUserAdditionalInfoRequest $request)
    {
        Log::notice("\n\n" . '::UserAdditionalInfoAPIController::store::$request');
        Log::notice(json_encode($request->all()));

        try {
            DB::beginTransaction();

            $request->user()
                ->additionalInfo()
                ->create($request->validated());

            DB::commit();

            $response = response()->success('User Additional Info stored successfully!');

            Log::notice("\n\n" . '::UserAdditionalInfoAPIController::index::$response');
            Log::notice($response);

            return $response;

        } catch (Exception $exception) {
            DB::rollBack();

            Log::notice("\n\n" . '::UserAdditionalInfoAPIController::store::$exception');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_11001, self::class, __FUNCTION__);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_11001, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}