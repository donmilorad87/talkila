<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Entity\TalkTypes;
use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfileVerificationRequest;
use App\Mail\VerifyNewTeacherProfile;
use App\Models\Availability;
use App\Models\BillingAddress;
use App\Models\JoinTheClub;
use App\ModelsApi\Language;
use App\ModelsApi\StaticProfession;
use App\ModelsApi\Talk;
use App\ModelsApi\UserImagesApi;
use App\ModelsApi\UserVerificationRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Laravel\Facades\Image;

/**
 * Class ProfileVerificationApiController
 * @package App\Http\Controllers\Api\V1\Admin
 */
class ProfileVerificationApiController extends Controller
{
    // the base directory that contains profile (user) images from application
    /**
     *
     */
    const DIRECTORY_USER_IMAGES = 'assets/images/user/';
    /**
     *
     */
    const VERIFICATION_STATUS = [
        '0' => 'Pending',
        '1' => 'Approved',
        '2' => 'Declined'
    ];

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * @OA\Get(
     *      path="/v1/user-verifications",
     *      operationId="profileVerification",
     *      tags={"ProfileVerification"},
     *      summary="Method profileVerification of ProfileVerificationApiController",
     *      description="Method profileVerification of ProfileVerificationApiController",
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
    public function profileVerification(Request $request)
    {
        Log::notice("\n\n" . '::ProfileVerificationApiController::profileVerification::$request');
        Log::notice($request->all());

        try {
            $userVerificationRequests = UserVerificationRequests::query()->select('name', 'request_date', 'approve_date', 'status')
                ->orderBy('created_at')
                ->get()
                ->toArray();

            if (empty($userVerificationRequests)) {
                $response = response()->json([
                    'message' => __('NO_VERIFICATION_REQUESTS'),
                    'success' => true
                ], 200);

                Log::notice("\n\n" . '::ProfileVerificationApiController::profileVerification::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->json([
                'data'    => $userVerificationRequests,
                'message' => __('LIST_VERIFICATION_REQUESTS'),
                'success' => true
            ], 200);

            Log::notice("\n\n" . '::ProfileVerificationApiController::profileVerification::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3500, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: '.Handler::TYPE_EXCEPTION_3500,
                'success' => false
            ], 500);
        }
    }

    /**
     * Add (profile) verification
     *
     * @param Request $request
     * @var $newVerification UserVerificationRequests
     * @return [string] message
     */


    /**
     * @OA\Post(
     *      path="/v1/add-profile-verification",
     *      operationId="addProfileVerification",
     *      tags={"ProfileVerification"},
     *      summary="Method addProfileVerification of ProfileVerificationApiController",
     *      description="Method addProfileVerification of ProfileVerificationApiController",
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

    public function addProfileVerification(StoreProfileVerificationRequest $request)
    {
        try {
            Log::notice("\n\n" . '::ProfileVerificationApiController::addProfileVerification::$request');
            Log::notice($request->all());

            $file       = $request->file('file');
            $user       = $request->user();

            $validateImage = UserApiController::detectImageSafeSearch($file->getRealPath())->getData('true');

            DB::beginTransaction();

            if ($validateImage['data']) {
                $extension          = $file->getClientOriginalExtension();

                $imageName          = substr(time(), -8).".{$extension}";
                $imagePath          = self::DIRECTORY_USER_IMAGES . $user->id;
                $imagePathPublic    = public_path($imagePath);

                if (!is_dir($imagePathPublic)) {
                    mkdir($imagePathPublic, 0777, true);
                }

                Image::read($file)->save($imagePathPublic . DIRECTORY_SEPARATOR . $imageName);

                $userImage          = new UserImagesApi;
                $userImage->user_id = $user->id;
                $userImage->image   = asset($imagePath . DIRECTORY_SEPARATOR . $imageName);
                $userImage->state   = UserImagesApi::STATE['approved'];
                $userImage->size    = 300;
                $userImage->save();

                $newVerification                = new UserVerificationRequests;
                $newVerification->name          = $request->input('name');
                $newVerification->image         = $userImage->image;
                $newVerification->request_date  = date('Y-m-d');
                $newVerification->status        = 0;
                $newVerification->save();

                $joinTheClubStepFive = JoinTheClub::query()->where('users_id', $request->user()->id)->first();

                if($joinTheClubStepFive->step_4 != 1) {
                    $joinTheClubStepFive->update(['step_4' => 1]);

                    $billingAddress = BillingAddress::query()->where('user_id', $user->id)->with('countries')->first();
                    $availability   = Availability::query()->where('user_id', $user->id)->where('state', true)->get();
                    $talk           = Talk::query()->where('teacher_user_id', $user->id)->first();
                    $languages      = Language::query()->select(['id', StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', 'en')] . ' as language_name'])->where('id', $talk->languages_id)->first();

                    Mail::to('jtc@talkila.com')->queue(new VerifyNewTeacherProfile($user->email, $user->name, $user->username, $user->email, $user->profile_picture, date('Y-m-d'), $billingAddress, $availability, $talk, $talk->talk_type == TalkTypes::VOICE_CALL ? 'Phone-Talk' : 'Video-Talk', $languages->language_name));

                    $addProfileVerificationObject = new JoinTheClubApiController();
                    $addProfileVerificationObject->joinTheClubAvailabilityCompleted($request);

                }



                DB::commit();
                $response = response()->json([
                    'message'   => __('SUCCESS_VERIFICATION_REQUEST'),
                    'success'   => true
                ]);

                Log::notice("\n\n" . '::ProfileVerificationApiController::addProfileVerification::$response');
                Log::notice($response);

                return $response;

            } else {
                DB::rollBack();
                $response = response()->json([
                    'message'   => __('IMAGE_DOESNT_FIT_PRIVACY_POLICY'),
                    'success'   => false
                ], 200);

                Log::notice("\n\n" . '::ProfileVerificationApiController::addProfileVerification::$response');
                Log::notice($response);

                return $response;
            }
        }
        catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_3501, self::class, __FUNCTION__);

            return response()->json([
                'message' => 'Error: '.Handler::TYPE_EXCEPTION_3501,
                'success' => false
            ], 500);
        }
    }
}
