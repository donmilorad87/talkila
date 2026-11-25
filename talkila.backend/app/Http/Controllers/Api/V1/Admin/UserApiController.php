<?php

namespace App\Http\Controllers\Api\V1\Admin;

//namespace Google\Cloud\Samples\Vision;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResendVerificationEmailRequest;
use App\Mail\AccountActivation;
use App\Mail\EmailVerification;
use App\Mail\PayoutPerMonth;
use App\Models\BookingsPaymentDetails;
use App\Models\HelperModel;
use App\Models\JoinTheClub;
use App\Models\Notifications;
use App\Models\ProfilCv;
use App\Models\SocketParticipant;
use App\Models\SuggestionsHomeScreen;
use App\ModelsApi\BillingAddress;
use App\ModelsApi\Booking;
use App\ModelsApi\EmailChangeVerification;
use App\ModelsApi\Payout;
use App\ModelsApi\ProfilPayoutMethod;
use App\ModelsApi\StaticProfession;
use App\ModelsApi\User;
use App\ModelsApi\UserBlocked;
use App\ModelsApi\UserDontShowAgain;
use App\ModelsApi\UserFollowed;
use App\ModelsApi\UserImagesApi;
use App\Notifications\ChooseNewPasswordNotification;
use Exception;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;


/**
 * @OA\Tag(
 *     name="UserApi",
 *     description="Everything about UserApi",
 * )
 */

/**
 * Class UserApiController
 * @package App\Http\Controllers\Api\V1\Admin
 */
class UserApiController extends Controller
{
    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     *
     */
    const DIRECTORY_USER_IMAGES = 'assets/images/user/';

    /**
     * @param  Request  $request
     * @param           $id
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * @OA\Post(
     *      path="/v1/user-suggestions",
     *      operationId="getSuggestions",
     *      tags={"User"},
     *      summary="Method getSuggestions of UserApiController",
     *      description="Method getSuggestions of UserApiController",
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
    public function getSuggestions(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserApiController::getSuggestions::$request');
            Log::notice($request->all());

            $requestedSuggestionsLimit = $request->input('showLimit', 10);
            $loggedUser                = $request->user();

            // TODO is this condition valid? you need to exclude only users that current logged-in user blocked
            $blockedUser = UserBlocked::query()->where('user_id', $request->user()->id)
                ->where('state', UserBlocked::STATE['valid'])
                ->pluck('blocked_user_id')
                ->toArray();

            $blockedByUser = UserBlocked::query()->where('blocked_user_id', $request->user()->id)
                ->where('state', UserBlocked::STATE['valid'])
                ->pluck('user_id')
                ->toArray();

            $usersDontShow = UserDontShowAgain::query()->pluck('dont_show_again_user_id')->toArray();
            $followingUser = UserFollowed::query()->where('state', UserFollowed::STATE['valid'])
                ->select('follower_user_id')
                ->groupBy('follower_user_id')
                ->pluck('follower_user_id')
                ->toArray();
            $followedUsers = array_merge($followingUser, $usersDontShow);

            $blockedUserIds = array_merge($blockedUser, $blockedByUser);

            $suggestedOnes = SuggestionsHomeScreen::query()->where('user_id', '!=', $request->user()->id)
                ->where('state', SuggestionsHomeScreen::STATE['valid'])
                ->whereNotIn('user_id', array_unique(array_merge($blockedUserIds, $followedUsers)))
                ->limit($requestedSuggestionsLimit)
                ->get()
                ->pluck('user_id')
                ->toArray();

            $suggestedUsers = User::query()
                ->select([
                    'users.id',
                    'users.name',
                    'users.username',
                    'users.description',
                    'talks.headline AS first_talk_category',
                ])
                ->selectRaw("CASE WHEN users.id = $loggedUser->id THEN profile_picture_tmp ELSE profile_picture END AS profile_picture")
                // ->selectRaw("IF(user_followeds.state = 2 , true, false) AS follow_pending")
                ->leftJoin('talks', function ($join) {
                    $join->on('talks.teacher_user_id', '=', 'users.id');
                })
                ->leftJoin('user_verification_requests', 'users.id', '=', 'user_verification_requests.user_id')
                ->whereIn('users.id', $suggestedOnes)
                ->where('approved', User::STATE['approved'])
                ->where('type', User::TYPE['supplier'])
                ->where('visibility', User::VISIBILITY['open'])
                ->where('user_verification_requests.status', 1)
                ->withCount('followerUserUserFolloweds AS total_followers')
                ->groupBy('talks.teacher_user_id', 'users.id', 'users.name', 'users.username', 'users.description', 'users.profile_picture', 'users.profile_picture_tmp', 'talks.headline', 'user_verification_requests.id')
                ->get();

            foreach ($suggestedUsers as $suggestedUser) {
                $suggestedUser->follow_pending = UserFollowed::where([
                    'state'            => UserFollowed::STATE['requested'],
                    'follower_user_id' => $suggestedUser->id,
                    'user_id'          => $request->user()->id,
                ])->exists();
            }

            $suggestedUsers->toArray();

            Log::notice("\n\n" . '::UserApiController::getSuggestions::spam::$suggestedUsers');
            Log::notice($suggestedUsers);

            if (empty($suggestedUsers)) {
                $response = response()->json([
                    'message' => 'There is no users for suggestion',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::getSuggestions::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->json([
                'data'    => $suggestedUsers,
                'message' => 'Successfully got user suggestions.',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserApiController::getSuggestions::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4000,
                self::class,
                __FUNCTION__
            );

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4000,
                'success' => false,
            ], 500);
        }
    }

    // the base directory that contains profile (user) images from application

    /**
     * @OA\Post(
     *      path="/v1/remove-suggestion/{id}",
     *      operationId="dontShowAgainUser",
     *      tags={"User"},
     *      summary="Method dontShowAgainUser of UserApiController",
     *      description="Method dontShowAgainUser of UserApiController",
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
    public function dontShowAgainUser(Request $request, $id)
    {
        try {
            Log::notice("\n\n" . '::UserApiController::dontShowAgainUser::$request');
            Log::notice($request->all());

            Log::notice("\n\n" . '::UserApiController::dontShowAgainUser::$id');
            Log::notice($id);

            DB::beginTransaction();

            $followUser                          = new UserDontShowAgain();
            $followUser->user_id                 = $request->user()->id;
            $followUser->dont_show_again_user_id = $id;
            $followUser->created_at              = date('Y-m-d H:i:s');
            $followUser->save();

            Log::notice("\n\n" . '::UserApiController::dontShowAgainUser::$followUser');
            Log::notice($followUser);

            DB::commit();
            $response = response()->json([
                'message' => 'User successfully hidden',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserApiController::dontShowAgainUser::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4001,
                self::class,
                __FUNCTION__
            );

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4001,
                'success' => false,
            ], 500);
        }
    }

    // TODO move on right place
    /**
     * Edit user (profile) picture
     *
     * @param  Request  $request
     *
     * @return [string] message
     */

    /**
     * @OA\Post(
     *      path="/v1/edit-profile-photo",
     *      operationId="editProfilePhoto",
     *      tags={"User"},
     *      summary="Method editProfilePhoto of UserApiController",
     *      description="Method editProfilePhoto of UserApiController",
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
    public function editProfilePhoto(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserApiController::editProfilePhoto::$request');
            Log::notice($request->all());

            $file       = $request->file('file');
            $loggedUser = $request->user();
            $user       = User::query()->select('id')
                ->selectRaw("CASE WHEN id = $loggedUser->id THEN profile_picture_tmp ELSE profile_picture END AS profile_picture")
                ->where('id', '=', $request->user()->id)->first();

            if (is_null($user)) {
                $response = response()->json([
                    'message' => 'User not found',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfilePhoto::$response');
                Log::notice($response);

                return $response;
            }

            if (empty($file)) {
                $response = response()->json([
                    'errors'  => ['file' => 'File is required'],
                    'message' => 'File is required',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfilePhoto::$response');
                Log::notice($response);

                return $response;
            }
            DB::beginTransaction();
            $validateImage = UserApiController::detectImageSafeSearch($file->getRealPath())->getData('true');

            if ($validateImage['data']) {
                $extension = $file->getClientOriginalExtension() !== ''
                    ? $file->getClientOriginalExtension()
                    : explode(
                          "/",
                          $file->getClientMimeType()
                      )[count(explode("/", $file->getClientMimeType())) - 1];

                $imageName       = substr(time(), -8) . ".{$extension}";
                $imagePath       = self::DIRECTORY_USER_IMAGES . $user->id;
                $imagePathPublic = public_path($imagePath);

                if (!is_dir($imagePathPublic)) {
                    mkdir($imagePathPublic, 0777, true);
                }

                Image::read($file)->resize(300, 300)->save($imagePathPublic . DIRECTORY_SEPARATOR . $imageName);

                $userImage          = new UserImagesApi;
                $userImage->user_id = $user->id;
                $userImage->image   = asset('/') . $imagePath . DIRECTORY_SEPARATOR . $imageName;
                $userImage->state   = UserImagesApi::STATE['pending'];
                $userImage->size    = 300;
                $userImage->save();

                $user->profile_picture_tmp = asset('/') . $imagePath . DIRECTORY_SEPARATOR . $imageName . "?t=" . microtime(true);
                $user->save();

                Log::notice("\n\n" . '::UserApiController::editProfilePhoto::$user');
                Log::notice($user);
                DB::commit();
                $response = response()->json([
                    'message' => 'Successfully uploaded profile photo',
                    'success' => true,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfilePhoto::$response');
                Log::notice($response);

                return $response;
            } else {
                DB::rollBack();
                $response = response()->json([
                    'message' => 'Your image doesnt fit with our privacy police.',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfilePhoto::$response');
                Log::notice($response);

                return $response;
            }
        } catch (\Exception $exception) {
            DB::commit();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4002,
                self::class,
                __FUNCTION__
            );

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4002,
                'success' => false,
            ], 500);
        }
    }

    /**
     * Edit user (profile) username
     *
     * @param  Request  $request
     *
     * @return [string] message
     */

    /**
     * @OA\Post(
     *      path="/v1/test-profile-photo",
     *      operationId="detectImageSafeSearch",
     *      tags={"User"},
     *      summary="Method detectImageSafeSearch of UserApiController",
     *      description="Method detectImageSafeSearch of UserApiController",
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
    public static function detectImageSafeSearch($path)
    {
        try {
            //  Set always to return positive validation because google is not a proper validator
            $response = response()->json([
                'data'    => true,
                'message' => 'Image for upload',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserApiController::detectImageSafeSearch::$response');
            Log::notice($response);

            return $response;

            Log::notice("\n\n" . '::UserApiController::detectImageSafeSearch::$path');
            Log::notice($path);

            $imageAnnotator = new ImageAnnotatorClient([
                'credentials' => storage_path('app/google/TalkilaVision-cc7330bb68fb.json'),
            ]);
//            $path       = self::DIRECTORY_USER_IMAGES . '59023/nude3.jpg';

            # annotate the image
            $image    = file_get_contents($path);
            $response = $imageAnnotator->safeSearchDetection($image);
            $safe     = $response->getSafeSearchAnnotation();

            $adult    = $safe->getAdult();
            $medical  = $safe->getMedical();
            $spoof    = $safe->getSpoof();
            $violence = $safe->getViolence();
            $racy     = $safe->getRacy();

            # names of likelihood from google.cloud.vision.enums
            $likelihoodName = [
                'UNKNOWN',
                'VERY_UNLIKELY',
                'UNLIKELY',
                'POSSIBLE',
                'LIKELY',
                'VERY_LIKELY',
            ];

            $resultData = [
                'adult'    => $likelihoodName[$adult],
                'medical'  => $likelihoodName[$medical],
                'spoof'    => $likelihoodName[$spoof],
                'violence' => $likelihoodName[$violence],
                'racy'     => $likelihoodName[$racy],
            ];

            $imageAnnotator->close();

            $unwantedData = ['POSSIBLE', 'LIKELY', 'VERY_LIKELY'];

            $unwantedDataCheck = array_intersect($resultData, $unwantedData);

            $response = response()->json([
                'data'    => empty($unwantedDataCheck) ? true : false,
                'message' => 'Image for upload',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserApiController::detectImageSafeSearch::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4022,
                self::class,
                __FUNCTION__
            );

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4022,
                'success' => false,
            ], 500);
        }
    }

    /**
     * Edit user (profile) username
     *
     * @param  Request  $request
     *
     * @return [string] message
     */

    /**
     * @OA\Post(
     *      path="/v1/edit-profile-name",
     *      operationId="editProfileName",
     *      tags={"User"},
     *      summary="Method editProfileName of UserApiController",
     *      description="Method editProfileName of UserApiController",
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
    public function editProfileName(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserApiController::editProfileName::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            $user = User::query()->select('id', 'name')->where('id', '=', $request->user()->id)->first();

            if (is_null($user)) {
                DB::rollBack();
                $response = response()->json([
                    'message' => 'User not found',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileName::$response');
                Log::notice($response);

                return $response;
            }

            if (empty($request->input('name'))) {
                DB::rollBack();
                $response = response()->json([
                    'errors'  => ['name' => 'Field name is required'],
                    'message' => 'Field name is required',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileName::$response');
                Log::notice($response);

                return $response;
            }

            $validatedNameResponse = HelperModel::validateName($request->input('name'))->getData(true);

            if (!$validatedNameResponse['success']) {
                return $validatedNameResponse;
            }

            $user->name = $request->input('name');
            $user->save();

            DB::commit();
            $response = response()->json([
                'message' => 'Successfully updated name',
                'success' => true,
            ]);

            Log::notice("\n\n" . '::UserApiController::editProfileName::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4003,
                self::class,
                __FUNCTION__
            );

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4003,
                'success' => false,
            ], 500);
        }
    }
    /**
     * Edit user (profile) username
     *
     * @param  Request  $request
     *
     * @return [string] message
     */

    /**
     * @OA\Post(
     *      path="/v1/edit-profile-username",
     *      operationId="editProfileUsername",
     *      tags={"User"},
     *      summary="Method editProfileUsername of UserApiController",
     *      description="Method editProfileUsername of UserApiController",
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
    public function editProfileUsername(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserApiController::editProfileUsername::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            $user = User::query()->select('id', 'username')->where('id', '=', $request->user()->id)->first();

            if (is_null($user)) {
                DB::rollBack();
                $response = response()->json([
                    'message' => 'User not found',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileUsername::$response');
                Log::notice($response);

                return $response;
            }

            if (empty($request->input('username'))) {
                DB::rollBack();
                $response = response()->json([
                    'errors'  => ['username' => 'Field username is required'],
                    'message' => 'Field username is required',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileUsername::$response');
                Log::notice($response);

                return $response;
            }

            if (strlen($request->input('username')) <= 3) {
                DB::rollBack();
                $response = response()->json([
                    'message' => 'The username needs to be minimum of 4 characters.',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileUsername::$response');
                Log::notice($response);

                return $response;
            }

            $requestedUsername = $request->input('username');
            $existUsername     = User::query()->where('username', $requestedUsername)->where(
                'id',
                '!=',
                $request->user()->id
            )->exists();

            Log::notice("\n\n" . '::UserApiController::editProfileUsername::$existUsername');
            Log::notice($existUsername);

            if ($existUsername) {
                DB::rollBack();
                $response = response()->json([
                    'message' => 'Already existing user with that username.',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileUsername::$response');
                Log::notice($response);

                return $response;
            }

            $validatedNameResponse = HelperModel::validateName($request->input('username'))->getData(true);

            if (!$validatedNameResponse['success']) {
                return $validatedNameResponse;
            }

            Log::notice("\n\n" . '::UserApiController::editProfileUsername::$requestedUsername');
            Log::notice($requestedUsername);

            if (preg_match("/[A-Za-z0-9]+/", $requestedUsername) != true) {
                DB::rollBack();
                $response = response()->json([
                    'message' => 'Username need to be without special characters.',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileUsername::$response');
                Log::notice($response);

                return $response;
            }

            $user->username = $requestedUsername;
            $user->save();

            $joinTheClubStepOne = JoinTheClub::query()->where('users_id', $user->id)->first();

            if ($joinTheClubStepOne->step_1 != 1) {
                $joinTheClubStepOne->update(['step_1' => 1]);
            }

            DB::commit();

            $response = response()->json([
                'message' => 'Successfully updated username',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserApiController::editProfileUsername::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4004,
                self::class,
                __FUNCTION__
            );

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4004,
                'success' => false,
            ], 500);
        }
    }

    /**
     * Edit user (profile) website
     *
     * @param  Request  $request
     *
     * @return [string] message
     */

    /**
     * @OA\Post(
     *      path="/v1/edit-profile-name-and-username",
     *      operationId="editProfileNameAndUsername",
     *      tags={"User"},
     *      summary="Method editProfileNameAndUsername of UserApiController",
     *      description="Method editProfileNameAndUsername of UserApiController",
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

    public function editProfileNameAndUsername(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserApiController::editProfileNameAndUsername::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            $user = User::query()->select('id', 'name', 'username')->where('id', '=', $request->user()->id)->first();

            if (is_null($user)) {
                $response = response()->json([
                    'message' => 'User not found',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileNameAndUsername::$response');
                Log::notice($response);

                return $response;
            }

            $dataErrors = [];

            if (empty($request->input('name'))) {
                $dataErrors['name'] = [
                    __('ATTRIBUTE_REQUIRED', ['attribute' => 'name']),
                ];
            }
            if (empty($request->input('username'))) {
                $dataErrors['username'] = [
                    __('ATTRIBUTE_REQUIRED', ['attribute' => 'username'])
                ];
            }
            if (preg_match('/[!@#$%^&*()+={}\|\[\]]/', $request->input('username'))) {
                $dataErrors['username'] = [
                    __('ATTRIBUTE_FORMAT', ['attribute' => 'username']),
                ];
            }

            if (!empty($dataErrors)) {
                $response = response()->json([
                    'errors'  => $dataErrors,
                    'message' => 'The given data was invalid.',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileNameAndUsername::$response');
                Log::notice($response);

                return $response;
            }

            $requestedUsername    = $request->input('username');
            $requestedName        = $request->input('name');
            $requestedDescription = $request->input('description');
            $existUsername        = User::query()->where('username', $requestedUsername)->where(
                'id',
                '!=',
                $request->user()->id
            )->exists();

            Log::notice("\n\n" . '::UserApiController::editProfileNameAndUsername::$existUsername');
            Log::notice($existUsername);

            if ($existUsername) {
                $response = response()->json([
                    'errors'  => ['username' => ['Already existing user with that username.']],
                    'message' => 'Already existing user with that username.',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileNameAndUsername::$response');
                Log::notice($response);

                return $response;
            }

            Log::notice("\n\n" . '::UserApiController::editProfileNameAndUsername::$requestedUsername');
            Log::notice($requestedUsername);

            if (preg_match("/[A-Za-z0-9]+/", $requestedUsername) != true) {
                $response = response()->json([
                    'errors'  => ['username' => ['Username need to be without special characters.']],
                    'message' => 'Username need to be without special characters.',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileNameAndUsername::$response');
                Log::notice($response);

                return $response;
            }

            $validatedNameResponse     = HelperModel::validateName($requestedName)->getData(true);
            $validatedUsernameResponse = HelperModel::validateName($requestedUsername)->getData(true);

            if (!$validatedNameResponse['success']) {
                return $validatedNameResponse;
            }

            if (!$validatedUsernameResponse['success']) {
                return $validatedUsernameResponse;
            }

            $user->name     = $requestedName;
            $user->username = $requestedUsername;
            if (!is_null($requestedDescription)) {
                $user->description = $requestedDescription;
            }
            $user->save();

            session()->put(['username' => $requestedUsername]);


            (new JoinTheClubApiController())->joinTheClubComplete($request->merge(['step' => 1]));

            DB::commit();
            $response = response()->json([
                'message' => 'Successfully updated username',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserApiController::editProfileNameAndUsername::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4005,
                self::class,
                __FUNCTION__
            );

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4005,
                'success' => false,
            ], 500);
        }
    }

    /**
     * Edit user (profile) biography
     *
     * @param  Request  $request
     *
     * @return [string] message
     */

    /**
     * @OA\Post(
     *      path="/v1/edit-profile-website",
     *      operationId="editProfileWebsite",
     *      tags={"User"},
     *      summary="Method editProfileWebsite of UserApiController",
     *      description="Method editProfileWebsite of UserApiController",
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
    public function editProfileWebsite(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserApiController::editProfileWebsite::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            $user = User::query()->select('id', 'url')->where('id', '=', $request->user()->id)->first();

            if (is_null($user)) {
                $response = response()->json([
                    'message' => 'User not found',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileWebsite::$response');
                Log::notice($response);

                return $response;
            }

            if (empty($request->input('website'))) {
                $response = response()->json([
                    'errors'  => ['website' => 'Field website is required'],
                    'message' => 'Field website is required',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileWebsite::$response');
                Log::notice($response);

                return $response;
            }

            $user->url = $request->input('website');
            $user->save();

            DB::commit();
            $response = response()->json([
                'message' => 'Successfully updated website',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserApiController::editProfileWebsite::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4006,
                self::class,
                __FUNCTION__
            );

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4006,
                'success' => false,
            ], 500);
        }
    }

    /**
     * Edit user (profile) biography
     *
     * @param  Request  $request
     *
     * @return [string] message
     */

    /**
     * @OA\Post(
     *      path="/v1/edit-profile-biography",
     *      operationId="editProfileBiography",
     *      tags={"User"},
     *      summary="Method editProfileBiography of UserApiController",
     *      description="Method editProfileBiography of UserApiController",
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
    public function editProfileBiography(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserApiController::editProfileBiography::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            $user = User::query()->select('id', 'description')->where('id', '=', $request->user()->id)->first();

            if (is_null($user)) {
                $response = response()->json([
                    'message' => 'User not found',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileBiography::$response');
                Log::notice($response);

                return $response;
            }

            if (empty($request->input('biography'))) {
                $response = response()->json([
                    'errors'  => ['biography' => 'Field biography is required'],
                    'message' => 'Field biography is required',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileBiography::$response');
                Log::notice($response);

                return $response;
            }

            $user->description = $request->input('biography');
            $user->save();

            $notificationData = [
                'user_id' => $user->id,
                'type'    => 'custom',
                'value'   => Notifications::VALUE['about_me_changed'],
            ];

            $notification = NotificationsApiController::sendNotification($request, $notificationData);

            Log::notice("\n\n" . '::UserApiController::editProfileBiography::$notification');
            Log::notice($notification);

            DB::commit();
            $response = response()->json([
                'message' => 'Successfully updated biography',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserApiController::editProfileBiography::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4007,
                self::class,
                __FUNCTION__
            );

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4007,
                'success' => false,
            ], 500);
        }
    }


    /**
     * Edit user (profile) biography
     *
     * @param  Request  $request
     *
     * @return [string] message
     */

    /**
     * @OA\Post(
     *      path="/v1/user-update-cv",
     *      operationId="editProfileCV",
     *      tags={"User"},
     *      summary="Method editProfileCV of UserApiController",
     *      description="Method editProfileCV of UserApiController",
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
    public function editProfileCV(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserApiController::editProfileCV::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            $userCv = ProfilCv::query()->select('id')->where('user_id', '=', $request->user()->id)->first();

            if (is_null($userCv)) {
                $response = response()->json([
                    'message' => 'User not found',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileCV::$response');
                Log::notice($response);

                return $response;
            }

            ProfilCv::query()->where('user_id', '=', $request->user()->id)->update($request->all());

            $notificationData = [
                'user_id' => $userCv->user_id,
                'type'    => 'custom',
                'value'   => Notifications::VALUE['new_cv'],
            ];
            $notification     = NotificationsApiController::sendNotification($request, $notificationData);

            Log::notice("\n\n" . '::UserApiController::editProfileCV::$notification');
            Log::notice($notification);

            DB::commit();
            $response = response()->json([
                'message' => 'Successfully updated user CV',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserApiController::editProfileCV::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4008,
                self::class,
                __FUNCTION__
            );

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4008,
                'success' => false,
            ], 500);
        }
    }

    /**
     * Edit user (profile) biography
     *
     * @param  Request  $request
     *
     * @return [string] message
     */

    /**
     * @OA\Post(
     *      path="/v1/user-update-language",
     *      operationId="editProfileLanguage",
     *      tags={"User"},
     *      summary="Method editProfileLanguage of UserApiController",
     *      description="Method editProfileLanguage of UserApiController",
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
    public function editProfileLanguage(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserApiController::editProfileLanguage::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            $user = User::query()->select('id')->where('id', '=', $request->user()->id)->first();

            if (is_null($user)) {
                $response = response()->json([
                    'message' => 'User not found',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileLanguage::$response');
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

            if (!empty($dataErrors)) {
                $response = response()->json([
                    'errors'  => $dataErrors,
                    'message' => 'These fields are required',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileLanguage::$response');
                Log::notice($response);

                return $response;
            }


            User::query()->where('id', '=', $request->user()->id)
                ->update(['last_language' => $language]);

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

    /**
     * Edit user (profile) videoUrl
     *
     * @param  Request  $request
     *
     * @return [string] message
     */

    /**
     * @OA\Post(
     *      path="/v1/user-update-profession",
     *      operationId="editProfileProfession",
     *      tags={"User"},
     *      summary="Method editProfileProfession of UserApiController",
     *      description="Method editProfileProfession of UserApiController",
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
    public function editProfileProfession(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserApiController::editProfileProfession::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            $user = User::query()->select('id', 'profession', 'profession_id')->where(
                'id',
                '=',
                $request->user()->id
            )->first();

            if (is_null($user)) {
                $response = response()->json([
                    'message' => 'User not found',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileProfession::$response');
                Log::notice($response);

                return $response;
            }

            if (empty($request->input('profession'))) {
                $response = response()->json([
                    'errors'  => ['profession' => ['Field profession is required']],
                    'message' => 'Field profession is required',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileProfession::$response');
                Log::notice($response);

                return $response;
            }

            $requestedLanguage = StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', 'en')];

            Log::notice("\n\n" . '::UserApiController::editProfileProfession::$request');
            Log::notice($requestedLanguage);

            $existingProfession = StaticProfession::query()->where(
                $requestedLanguage,
                $request->input('profession')
            )->first();

            Log::notice("\n\n" . '::UserApiController::editProfileProfession::$existingProfession');
            Log::notice($existingProfession);

            if (empty($existingProfession)) {
                $response = response()->json([
                    'errors'  => ['profession' => ['This profession is not recognised in the system.']],
                    'message' => 'This profession is not recognised in the system.',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileProfession::$response');
                Log::notice($response);

                return $response;
            }

            $professionName = $request->input('profession');

            $user->profession    = $professionName;
            $user->profession_id = $existingProfession->id;
            $user->save();

            $notificationData = [
                'user_id' => $user->id,
                'type'    => 'custom',
                'value'   => Notifications::VALUE['profession_changed'],
            ];
            $notification     = NotificationsApiController::sendNotification($request, $notificationData);

            Log::notice("\n\n" . '::UserApiController::editProfileProfession::$notification');
            Log::notice($notification);

            DB::commit();
            $response = response()->json([
                'message' => 'Successfully updated biography',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserApiController::editProfileProfession::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4010,
                self::class,
                __FUNCTION__
            );

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4010,
                'success' => false,
            ], 500);
        }
    }

    /**
     * Edit user (profile) privateStatus
     *
     * @param  Request  $request
     *
     * @return [string] message
     */

    /**
     * @OA\Post(
     *      path="/v1/edit-profile-video",
     *      operationId="editProfileVideo",
     *      tags={"User"},
     *      summary="Method editProfileVideo of UserApiController",
     *      description="Method editProfileVideo of UserApiController",
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

    public function editProfileVideo(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserApiController::editProfileVideo::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            $user = User::query()->select('id', 'youtube_video')->where('id', '=', $request->user()->id)->first();

            if (is_null($user)) {
                $response = response()->json([
                    'message' => 'User not found',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileVideo::$response');
                Log::notice($response);

                return $response;
            }

            if (empty($request->input('video_url'))) {
                $response = response()->json([
                    'errors'  => ['video_url' => ['Field is required']],
                    'message' => 'Field is required',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileVideo::$response');
                Log::notice($response);

                return $response;
            }

            if (preg_match(
                '@^(?:https://(?:www\\.)?youtube.com/)(watch\\?v=|v/)([a-zA-Z0-9_]*)@',
                $request->input('video_url'),
                $match
            )) {
                $youtubeVideo = $request->input('video_url');
            } else {
                $response = response()->json([
                    'errors'  => ['video_url' => ['Video need to be from youtube.com']],
                    'message' => 'Video need to be from youtube.com',
                    'success' => false,
                ]);

                Log::notice("\n\n" . '::UserApiController::editProfileVideo::$response');
                Log::notice($response);

                return $response;
            }


            $user->youtube_video = $youtubeVideo;
            $user->save();

            DB::commit();
            $response = response()->json([
                'message' => 'Successfully updated',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserApiController::editProfileVideo::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4011,
                self::class,
                __FUNCTION__
            );

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4011,
                'success' => false,
            ], 500);
        }
    }

    /**
     * Edit user (profile) email
     *
     * @param  Request  $request
     *
     * @return [string] message
     */

    /**
     * @OA\Post(
     *      path="/v1/edit-profile-private",
     *      operationId="editProfilePrivateStatus",
     *      tags={"User"},
     *      summary="Method editProfilePrivateStatus of UserApiController",
     *      description="Method editProfilePrivateStatus of UserApiController",
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
    public function editProfilePrivateStatus(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserApiController::editProfilePrivateStatus::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            $user = User::query()->select('id', 'visibility')->where('id', '=', $request->user()->id)->first();

            if (is_null($user)) {
                $response = response()->json([
                    'message' => 'User not found',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfilePrivateStatus::$response');
                Log::notice($response);

                return $response;
            }

            if (empty($request->input('private_status'))) {
                $response = response()->json([
                    'errors'  => ['private_status' => 'Field private status is required'],
                    'message' => 'Field private status is required',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileVideo::$response');
                Log::notice($response);

                return $response;
            }

            $user->visibility = $request->input('private_status');
            $user->save();

            DB::commit();
            $response = response()->json([
                'message' => 'Successfully updated privateStatus',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserApiController::editProfilePrivateStatus::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4012,
                self::class,
                __FUNCTION__
            );

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4012,
                'success' => false,
            ], 500);
        }
    }

    /**
     * Edit user (profile) password
     *
     * @param  Request  $request
     *
     * @return [string] message
     */

    /**
     * @OA\Post(
     *      path="/v1/edit-profile-email",
     *      operationId="editProfileEmail",
     *      tags={"User"},
     *      summary="Method editProfileEmail of UserApiController",
     *      description="Method editProfileEmail of UserApiController",
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


    public function editProfileEmail(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserApiController::editProfileEmail::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            $user = User::query()->select('id', 'email', 'name')->where('id', '=', $request->user()->id)->first();

            if (is_null($user)) {
                $response = response()->json([
                    'message' => 'User not found',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileEmail::$response');
                Log::notice($response);

                return $response;
            }

            if (empty($request->input('email'))) {
                $response = response()->json([
                    'errors'  => [
                        'email' =>
                            ['Field email is required'],
                    ],
                    'message' => 'Field email is required',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileEmail::$response');
                Log::notice($response);

                return $response;
            }

            $existEmail = User::query()->where('email', $request->input('email'))->where(
                'id',
                '!=',
                $request->user()->id
            )->exists();

            if ($existEmail) {
                $response = response()->json([
                    'errors'  => [
                        'email' =>
                            ['Already existing user with that email.'],
                    ],
                    'message' => 'Already existing user with that email.',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfileEmail::$response');
                Log::notice($response);

                return $response;
            }

            if ($user->email != $request->input('email')) {
                $hashedCode = Hash::make(
                    substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!$<>"), 0, 10)
                );

                $emailChangeRequest                    = new EmailChangeVerification;
                $emailChangeRequest->requested_email   = $request->input('email');
                $emailChangeRequest->user_id           = $user->id;
                $emailChangeRequest->verification_code = $hashedCode;
                $emailChangeRequest->status            = EmailChangeVerification::STATE['requested'];
                $emailChangeRequest->save();

                $verificationMessage = route(
                    'users.user-email-verify',
                    ['id' => $emailChangeRequest->user_id, 'hash' => $hashedCode]
                );

                Mail::to($user->email)->queue(
                    new EmailVerification(
                        $request->header('Application-Language', 'en'),
                        $user->email,
                        $user->name,
                        route('api.email.verify', ['hash' => $emailChangeRequest->verification_code, 'id' => $user->id]),
                        $verificationMessage,
                        convertToUserTimezone(now())->toDateTimeString()
                    )
                );

//                if ($emailResponse == true) {
                DB::commit();
                $response = response()->json([
                    'success' => true,
                    'message' => 'Successfully sent request for change of email.',
                ]);
//                } else {
//                    DB::rollBack();
//                    $response = response()->json([
//                        'success' => false,
//                        'message' => 'Error happen during send request for change of email',
//                    ]);
//                }

                Log::notice('::AuthController::register::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->json([
                'errors'  => [
                    'email' =>
                        ['That your current email.'],
                ],
                'message' => 'That your current email',
                'success' => false,
            ], 200);

            Log::notice("\n\n" . '::UserApiController::editProfileEmail::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4013,
                self::class,
                __FUNCTION__
            );

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4013,
                'success' => false,
            ], 500);
        }
    }

    /**
     * Get user (profile) total booking amount
     *
     * @param  Request  $request
     *
     * @return [string] message
     */

    /**
     * @OA\Post(
     *      path="/v1/edit-profile-password",
     *      operationId="editProfilePassword",
     *      tags={"User"},
     *      summary="Method editProfilePassword of UserApiController",
     *      description="Method editProfilePassword of UserApiController",
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

    public function editProfilePassword(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserApiController::editProfilePassword::$request');
            Log::notice($request->all());
            DB::beginTransaction();

            $user = User::query()->select('id', 'password')->where('id', '=', $request->user()->id)->first();

            if (is_null($user)) {
                $response = response()->json([
                    'message' => 'User not found',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfilePassword::$response');
                Log::notice($response);

                return $response;
            }

            if (empty($request->input('new_password'))) {
                $response = response()->json([
                    'errors'  => [
                        'new_password' => ['New password cannot be empty.'],
                    ],
                    'message' => 'Password is required.',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfilePassword::$response');
                Log::notice($response);

                return $response;
            }

            //Take old password and logged user email and check if that is valid password
            if (!Hash::check($request->input('password'), $user->password)) {
                $response = response()->json([
                    'errors'  => [
                        'password' => ['Wrong original password. Password confirmation is not matching, please try again.'],
                    ],
                    'message' => 'Wrong original password',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::editProfilePassword::$response');
                Log::notice($response);

                return $response;
            }

            // check is input field new_password_confirmation  same as input password
            $validator = Validator::make($request->all(), [
                'new_password'           => 'required|min:8',
                'new_password_confirmed' => 'required|min:8|same:new_password',
            ]);


            if ($validator->fails()) {
                $response = response()->json([
                    'errors'  => [
                        'new_password_confirmed' => ['New password is not matching with confirmed password.'],
                    ],
                    'message' => 'New password is not matching with confirmed password',
                    'success' => false,
                ], 200);
                Log::notice("\n\n" . '::UserApiController::editProfilePassword::$response');
                Log::notice($response);

                return $response;
            }

            $request->user()->fill([
                'password' => Hash::make($request->input('new_password')),
            ])->save();

            DB::commit();
            $response = response()->json([
                'message' => 'Successfully updated password',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserApiController::editProfilePassword::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4014,
                self::class,
                __FUNCTION__
            );

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4014,
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
     *      path="/v1/user-booking-amount",
     *      operationId="getTotalBookingAmount",
     *      tags={"User"},
     *      summary="Method getTotalBookingAmount of UserApiController",
     *      description="Method getTotalBookingAmount of UserApiController",
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

    public function getTotalBookingAmount(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserApiController::getTotalBookingAmount::$request');
            Log::notice($request->all());

            $loggedInUserId = $request->user()->id;

            $userBookings = Booking::query()->where('state', Booking::STATE['paid'])
                ->where('teacher_user_id', $loggedInUserId)
                ->pluck('id');

            $payoutAmount = BookingsPaymentDetails::query()->where('status', Booking::STATE['paid'])
                ->whereIn('booking_id', $userBookings)
                ->sum('amount_value');

            if (empty($payoutAmount)) {
                $response = response()->json([
                    'message' => 'There is no payout amount',
                    'success' => true,
                ], 200);
                Log::notice("\n\n" . '::UserApiController::getTotalBookingAmount::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->json([
                'data'    => [
                    'payoutAmount' => $payoutAmount / 100,
                ],
                'message' => 'Total booking amount for logged in user',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserApiController::getTotalBookingAmount::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4015,
                self::class,
                __FUNCTION__
            );

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4015,
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
     *      path="/v1/user-booking-amount-monthly",
     *      operationId="getTotalBookingAmountMonthly",
     *      tags={"User"},
     *      summary="Method getTotalBookingAmountMonthly of UserApiController",
     *      description="Method getTotalBookingAmountMonthly of UserApiController",
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
    public function getTotalBookingAmountMonthly(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserApiController::getTotalBookingAmountMonthly::$request');
            Log::notice($request->all());

            $loggedInUserId = $request->user()->id;

            $currentMonth = date('m');
            $currentYear  = date('Y');

            $userBookings = Booking::query()->where('state', Booking::STATE['paid'])
                ->whereMonth('start_date', $currentMonth)
                ->whereYear('start_date', $currentYear)
                ->where('teacher_user_id', $request->user()->id)
                ->pluck('id');

            $currentMonthSum = BookingsPaymentDetails::query()->where('status', Booking::STATE['paid'])
                ->whereIn('booking_id', $userBookings)
                ->sum('amount_value');

            $payoutAmount = Payout::query()->selectRaw('TO_CHAR(payout_date, \'YYYY-MM\') as formatted_dop')
                ->selectRaw('ROUND(CAST(SUM(price) AS NUMERIC(10,2)),2) AS total_all, 0 as current_month')
                ->where('user_id', $loggedInUserId)
                ->orderByDesc('formatted_dop')
                ->groupBy('formatted_dop')
                ->get()->toArray();

            if (!empty($currentMonthSum)) {
                $currentMonthBooking['formatted_dop'] = $currentYear . '-' . $currentMonth;
                $currentMonthBooking['total_all']     = (integer)number_format($currentMonthSum / 100, 2, '.', '');
                $currentMonthBooking['current_month'] = 1;
                array_unshift($payoutAmount, $currentMonthBooking);
            }

            if (empty($payoutAmount)) {
                $response = response()->json([
                    'message' => 'There is no payouts amount for months',
                    'success' => true,
                ], 200);
                Log::notice("\n\n" . '::UserApiController::getTotalBookingAmountMonthly::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->json([
                'data'    => [
                    'bookingAmount' => $payoutAmount,
                ],
                'message' => 'Total booking amount for logged in user',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserApiController::getTotalBookingAmountMonthly::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4016,
                self::class,
                __FUNCTION__
            );

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4016,
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
     *      path="/v1/user-booking-amount-current-month",
     *      operationId="getCurrentMonthPayout",
     *      tags={"User"},
     *      summary="Method getCurrentMonthPayout of UserApiController",
     *      description="Method getCurrentMonthPayout of UserApiController",
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

    public function getCurrentMonthPayout(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserApiController::getCurrentMonthPayout::$request');
            Log::notice($request->all());

            $currentMonth = date('m');
            $currentYear  = date('Y');

            $userBookings = Booking::query()->where('state', Booking::STATE['paid'])
                ->whereMonth('start_date', $currentMonth)
                ->whereYear('start_date', $currentYear)
                ->where('teacher_user_id', $request->user()->id)
                ->pluck('id');

            $payoutAmount = BookingsPaymentDetails::query()->where('status', Booking::STATE['paid'])
                ->whereIn('booking_id', $userBookings)
                ->sum('amount_value');

            $response = response()->json([
                'data'    => $payoutAmount / 100,
                'message' => 'Total booking amount for logged in user',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserApiController::getCurrentMonthPayout::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4017,
                self::class,
                __FUNCTION__
            );

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4017,
                'success' => false,
            ], 500);
        }
    }

    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */

    /**
     * @OA\Post(
     *      path="/v1/user-payout-email",
     *      operationId="monthlyPayoutEmailInvoice",
     *      tags={"User"},
     *      summary="Method monthlyPayoutEmailInvoice of UserApiController",
     *      description="Method monthlyPayoutEmailInvoice of UserApiController",
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
    public function monthlyPayoutEmailInvoice(Request $request)
    {
        try {
            $loggedUser      = $request->user();
            $userBillingData = BillingAddress::query()->where('state', BillingAddress::STATE['valid'])
                ->where('id', $loggedUser->billing_address_id)
                ->first()
                ->toArray();
            $monthData       = $this->getRequestedMonthPayout($request, true)->getData(true);

            if (empty($monthData['errors'])) {
                $userData     = $monthData['data']['monthData'];
                $bookingsData = $monthData['data']['monthBookings'];
            } else {
                return $monthData;
            }

            $mentorData = \App\Models\User::query()->find($loggedUser->user_id);

            Mail::to('katic.bojan92@gmail.com')->send(
                new PayoutPerMonth(
                    $request->header('Application-Language', 'en'),
                    $mentorData->name ? $mentorData->name : $mentorData->username,
                    'mentor_url',
                    $userBillingData,
                    $userData,
                    $bookingsData
                )
            );

            $response = response()->json([
                'message' => 'Sent payout invoice.',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserApiController::monthlyPayoutEmailInvoice::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4019,
                self::class,
                __FUNCTION__
            );

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4019,
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
     * @OA\Post(
     *      path="/v1/user-bookings-requested-month",
     *      operationId="getRequestedMonthPayout",
     *      tags={"User"},
     *      summary="Method getRequestedMonthPayout of UserApiController",
     *      description="Method getRequestedMonthPayout of UserApiController",
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
    public function getRequestedMonthPayout(Request $request, $pagination = null)
    {
        try {
            Log::notice("\n\n" . '::UserApiController::getRequestedMonthPayout::$request');
            Log::notice($request->all());

            $loggedInUserId = $request->user()->id;
            $requestedMonth = $request->input('month');
            $requestedYear  = $request->input('year');

            $displayOffset = $request->input('offset', 0);
            $displayLimit  = !empty($pagination) ? 500 : $request->input('limit', 5);

            $dataErrors = [];

            if (empty($requestedMonth)) {
                $dataErrors['month'] = [
                    'The Month value is required.',
                ];
            }
            if (empty($requestedYear)) {
                $dataErrors['year'] = [
                    'The Year is required.',
                ];
            }

            if (!empty($dataErrors)) {
                $response = response()->json([
                    'errors'  => $dataErrors,
                    'message' => 'The given data was invalid.',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::getRequestedMonthPayout::$response');
                Log::notice($response);

                return $response;
            }

            $userBookings = Booking::query()->where('state', Booking::STATE['paid'])
                ->whereMonth('start_date', $requestedMonth)
                ->whereYear('start_date', $requestedYear)
                ->where('teacher_user_id', $loggedInUserId);

            $clonedBookingCondition = clone $userBookings;

            //  Calculate percent in decimal for calculation of 15% for commission
            $percentInDecimal = Booking::COMMISSION_PERCENT / 100;

            $profilePayout = ProfilPayoutMethod::query()->select('value', 'method')->where(
                'state',
                ProfilPayoutMethod::STATE['valid']
            )->first();

            if (empty($profilePayout)) {
                $response = response()->json([
                    'message' => 'There is no set payout method.',
                    'success' => false,
                ], 200);

                Log::notice("\n\n" . '::UserApiController::getRequestedMonthPayout::$profilePayout');
                Log::notice($response);

                return $response;
            }

            $mappedPayoutMethod = HelperModel::maskString($profilePayout);

            $monthBookingsData = $clonedBookingCondition->selectRaw(
                "SUM(price) AS total_all,
                                                                          COUNT(id) AS total_count,
                                                                          SUM(duration) as total_duration,
                                                                          ROUND(($percentInDecimal * SUM(price)), 2) as commission"
            )
                ->first()
                ->toArray();

            $monthBookingsData['name']             = $request->user()->name;
            $monthBookingsData['recipient_number'] = '1484-2356-123';
            $monthBookingsData['payout_type']      = $profilePayout->method;
            $monthBookingsData['payout_value']     = $mappedPayoutMethod;

            if (date('Y') == $requestedYear && date('m') == $requestedMonth) {
                $monthBookingsData['current_month'] = 1;
                $monthBookingsData['money_text']    = "Am 10.$requestedMonth.$requestedYear haben wir dier die Aberchung via E-mail geschuk";
            } else {
                $monthBookingsData['current_month'] = 0;
                $monthBookingsData['money_text']    = 'Am 10.12.2020 haben wir dier die Aberchung via E-mail geschuk';
            }

            $userBookings = $userBookings->pluck('id');
            $payoutAmount = BookingsPaymentDetails::query()->select(
                'booking_id',
                'payment_reference',
                'amount_currency',
                'creation_date'
            )
                ->selectRaw("(amount_value / 100) AS amount_value")
                ->where('status', Booking::STATE['paid'])
                ->whereIn('booking_id', $userBookings)
                ->orderByDesc('created_at')
                ->offset($displayOffset)->limit($displayLimit)
                ->get()
                ->toArray();

            $response = response()->json([
                'data'    => [
                    'monthData'     => $monthBookingsData,
                    'monthBookings' => $payoutAmount,
                ],
                'message' => 'All bookings and data from logged in user for requested month.',
                'success' => true,
            ], 200);

            Log::notice("\n\n" . '::UserApiController::getRequestedMonthPayout::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4018,
                self::class,
                __FUNCTION__
            );

            return response()->json([
                'message' => 'Error: ' . Handler::TYPE_EXCEPTION_4018,
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
     * @OA\Post(
     *      path="/v1/user-validate-username",
     *      operationId="checkUsernameUnique",
     *      tags={"User"},
     *      summary="Method checkUsernameUnique of UserApiController",
     *      description="Method checkUsernameUnique of UserApiController",
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

    public function checkUsernameUnique(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserApiController::checkUsernameUnique::$request');
            Log::notice($request->all());

            $dataForm = $request->all();

            $rules = [
                'username' => ['required', 'regex:/[a-zA-Z0-9]/', 'not_regex:/[!@#$%^&*()+={}\|\[\]]/', 'unique:users'],
            ];

            app()->setLocale($request->header('Application-Language', 'en'));

            $messages = [
                'username.required'  => __('ATTRIBUTE_REQUIRED', ['attribute' => 'username']),
                'username.string'    => __('ATTRIBUTE_STRING', ['attribute' => 'username']),
                'username.unique'    => __('ATTRIBUTE_UNIQUE', ['attribute' => 'username']),
                'username.regex'     => __('ATTRIBUTE_FORMAT', ['attribute' => 'username']),
                'username.not_regex' => __('ATTRIBUTE_FORMAT', ['attribute' => 'username']),
            ];

            $validator = validator($dataForm, $rules, $messages);

            if (!empty($validator->errors()->messages())) {
                $response = response()->error([
                    'message' => __('USERNAME_INVALID'),
                    'data'    => [
                        'errors' => $validator->errors()->messages(),
                    ],
                ]);

                Log::notice('::UserApiController::checkUsernameUnique::$response');
                Log::notice($response);

                return $response;
            }

            $validatedNameResponse = HelperModel::validateName($request->input('username'))->getData(true);

            if (!$validatedNameResponse['success']) {
                $object           = new \stdClass();
                $object->username = [$validatedNameResponse['message']];

                return response()->error([
                    'message' => __('USERNAME_INVALID'),
                    'data'    => [
                        'errors' => $object,
                    ],
                ]);
            }

            $response = response()->success(__('USERNAME_VALID'));

            Log::notice("\n\n" . '::UserApiController::checkUsernameUnique::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4020,
                self::class,
                __FUNCTION__
            );

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_4020, 500);
        }
    }

    /**
     * @param $path
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * @OA\Post(
     *      path="/v1/user-validate-email",
     *      operationId="checkEmailUnique",
     *      tags={"User"},
     *      summary="Method checkEmailUnique of UserApiController",
     *      description="Method checkEmailUnique of UserApiController",
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
    public function checkEmailUnique(Request $request)
    {
        try {
            Log::notice("\n\n" . '::UserApiController::checkEmailUnique::$request');
            Log::notice($request->all());

            $dataForm = $request->all();

            $rules = [
                'email' => 'required|string|email|unique:users',
            ];

            app()->setLocale($request->header('Application-Language', 'en'));

            $messages = [
                // 'email.email'    => 'The :attribute need to be of type email.',
                'email.email'    => __('ATTRIBUTE_EMAIL', ['attribute' => 'email']),
                // 'email.required' => 'The :attribute is required.',
                'email.required' => __('ATTRIBUTE_REQUIRED', ['attribute' => 'email']),
                // 'email.string'   => 'The :attribute need to be string.',
                'email.string'   => __('ATTRIBUTE_STRING', ['attribute' => 'email']),
                // 'email.unique'   => 'The :attribute need to be unique, already exist user with that email in the system.',
                'email.unique'   => __('ATTRIBUTE_UNIQUE', ['attribute' => 'email']),
            ];

            $validator = validator($dataForm, $rules, $messages);

            if (!empty($validator->errors()->messages())) {
                $response = response()->error([
                    'message' => __('EMAIL_INVALID'),
                    'data'    => [
                        'errors' => $validator->errors()->messages(),
                    ],
                ], 200);

                Log::notice('::UserApiController::checkEmailUnique::$response');
                Log::notice($response);

                return $response;
            }

            $response = response()->success(__('EMAIL_VALID'));

            Log::notice("\n\n" . '::UserApiController::checkEmailUnique::$response');
            Log::notice($response);

            return $response;
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report(
                $exception,
                Handler::PRIORITY['HIGH'],
                Handler::TYPE_EXCEPTION_4021,
                self::class,
                __FUNCTION__
            );

            // return response()->json([
            //     'message' => 'Error: '.Handler::TYPE_EXCEPTION_4021,
            //     'success' => false,
            // ], 500);

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_4021, 500);
        }
    }


    /**
     * Wrap web new email verification method to call from api
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */

    /**
     * @OA\Get(
     *      path="/v1/user-email-verify",
     *      operationId="verification",
     *      tags={"User"},
     *      summary="Method verification of UserApiController",
     *      description="Method verification of UserApiController",
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

    public function verification(Request $request)
    {
        try {
            $request->request->add(['api_call' => true]);

            return (new \App\Http\Controllers\Admin\UsersController)->verification($request);
        } catch (\Exception $e) {
            Log::error(var_export($e, true));

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_4023, 500);
        }
    }

    public function removeUserProfilePicture(Request $request)
    {
        try {
            $loggedUser = $request->user();

            User::query()->find($loggedUser->id)->update(['profile_picture' => null, 'profile_picture_tmp' => null]);

            $response = response()->success(__('SUCCESSFULLY_DELETED_IMAGE'));

            return $response;
        } catch (\Exception $e) {
            Log::error(var_export($e, true));

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_4024, 500);
        }
    }

    /**
     * Wrap web new account verification method to call from api
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function newAccountVerification(Request $request)
    {
        try {
            $request->request->add(['api_call' => true]);

            return (new \App\Http\Controllers\Admin\UsersController)->registrationVerification($request);
        } catch (\Exception $e) {
            Log::error(var_export($e, true));

            return response()->error(__('REQUEST_FAILED'), 500);
        }
    }

    /**
     * Resend verification email to the user.
     *
     * @param  ResendVerificationEmailRequest  $request
     *
     * @return JsonResponse
     */
    public function resendVerificationEmail(ResendVerificationEmailRequest $request): JsonResponse
    {
        try {
            $user = User::query()
                ->where('email', '=', $request->input('email'))
                ->first();

            app()->setLocale($request->header('Application-Language', 'de') ?? session('language'));

            if (!$user) {
                return response()->error(__('SOMETHING_WENT_WRONG'));
            }

            if ($user->verified) {
                return response()->error(__('ALREADY_VERIFIED'));
            }

            $diffInMinutes = now()->diffInMinutes($user->updated_at);

            if ($diffInMinutes < 5) {
                return response()->error(
                    __('EMAIL_RESEND_TIME_LIMIT_REACHED', [
                        'minutes' => (5 - $diffInMinutes),
                    ])
                );
            }

            $token = Str::random(64);
            $user->update([
                'verification_token' => $token,
            ]);

            $verificationMessage = config('app.frontend_url') . '/verification-account?id=' . $user->id . '&hash=' . $token . '&user_email=' . $user->email;

            $emailResponse = Mail::to($request->email)->queue(
                new AccountActivation(
                    $user->last_language ?? $request->header('Application-Language', 'de'),
                    $user->email,
                    $user->name,
                    $verificationMessage,
                    convertToUserTimezone(now(), 'Y-m-d H:i:s')
                )
            );

            Log::notice('::UserApiController::resendVerificationEmail::$emailResponse');
            Log::notice($emailResponse);

            return response()->success(__('A fresh verification link has been sent to your email address.'));
        } catch (Exception $exception) {
            Log::error(var_export($exception, true));

            return response()->error(__('REQUEST_FAILED'));
        }
    }

    /**
     * Update iOS Voip Token (VoIP token is required to show native (mobile app) calling/talk screen)
     * - this will be called when the user enables notification on iOS (user have the option on iOS to disable/enable notification)
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateIOSVoipToken(Request $request)
    {
        try {
            $loggedUser    = $request->user();
            $voip_token    = $request->input('voip_token');
            $firebase_type = $request->input('device_type');

            if (!empty($voip_token) && $voip_token != $loggedUser->voip_token) {
                Log::notice("\n\n" . '::UserApiController::updateIOSVoipToken::$voip_token');
                Log::notice($voip_token);

                User::query()->find($loggedUser->id)->update(['voip_token' => $voip_token]);

                User::query()->where('voip_token', $voip_token)->where('id', '!=', $loggedUser->id)->update(['voip_token' => null]);
            }

            if (!empty($firebase_type)) {
                if (!empty($voip_token) && $firebase_type == 'ios') {
                    SocketParticipant::query()->where('user_id', $loggedUser->id)->update(['firebase_id' => $voip_token]);

                    SocketParticipant::query()->where('user_id', '!=', $loggedUser->id)->where('firebase_id', $voip_token)->update(['firebase_id' => null]);
                }
            }

            $response = response()->success(__('SUCCESSFULLY_UPDATED_VOIP_TOKEN'));

            return $response;
        } catch (\Exception $e) {
            Log::error(var_export($e, true));

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_4024, 500);
        }
    }

    public function updateCountryOfResidence(Request $request)
    {
        try {
            // Update the User model.
            $request->user()->update([
                'vat_id' => $request->input('vat_id'),
            ]);

            return response()->success(__('SUCCESSFULLY_UPDATED_COUNTRY_OF_RESIDENCE'));
        } catch (\Exception $exception) {
            return response()->error(__('SOMETHING_WENT_WRONG'));
        }
    }

    public function deleteUser(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->user()->deactivate();
            DB::commit();

            return response()->success(__('SUCCESSFULLY_DELETED_USER_ACCOUNT'));
        } catch (\Exception $exception) {
            DB::rollBack();

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_4025, 500);
        }
    }

    public function restoreUser($user_id)
    {
        DB::beginTransaction();
        try {
            User::withTrashed()->find($user_id)->reactivate();

            DB::commit();

            return response()->success(__('SUCCESSFULLY_RESTORED_USER_ACCOUNT'));
        } catch (\Exception $exception) {
            DB::rollBack();

            return response()->error('Error: ' . Handler::TYPE_EXCEPTION_4025, 500);
        }
    }

    /**
     * Revoke Apple Access token and details.
     *
     * @param  Request  $request
     *
     * @return mixed
     */
    public function appleAccountNotification(Request $request)
    {
        Log::notice("\n\n" . '::UserApiController::appleAccountNotification::$request');
        Log::notice(json_encode($request->all()));

        $jtwEvent = $this->getPayloadEvent($request->input('payload'));

        $user = $this->getUserFromToken($jtwEvent->sub);

        if (!$user) {
            $response = response()->error(__('USER_NOT_FOUND'));

            Log::notice("\n\n" . '::UserApiController::appleAccountNotification::getUserFromToken::$response');
            Log::notice($response);

            return $response;
        }

        $user->update([
            'apple_token'   => null,
            'apple_details' => null,
            'login_type'    => User::LOGIN_TYPE['standard'],
        ]);

        $token = app(PasswordBroker::class)->createToken($user);

        DB::table(config('auth.passwords.users.table'))
            ->insert([
                'email'      => $user->email,
                'token'      => Hash::make($token),
                'created_at' => now(),
            ]);

        app()->setLocale($user->last_language);

        $user->notify(new ChooseNewPasswordNotification($token));
    }

    /**
     * Decode Apple Notification payload and return the Event.
     *
     * @param  string  $payload  Apple Notification payload.
     *
     * @return mixed
     */
    protected function getPayloadEvent(string $payload)
    {
        $tokenParts   = explode('.', $payload);
        $tokenHeaders = base64_decode($tokenParts[0]);
        $tokenPayload = base64_decode($tokenParts[1]);

        Log::notice("\n\n" . '::UserApiController::appleAccountNotification::$headers');
        Log::notice($tokenHeaders);

        Log::notice("\n\n" . '::UserApiController::appleAccountNotification::$payload');
        Log::notice($tokenPayload);

        $jwtHeader  = json_decode($tokenHeaders);
        $jwtPayload = json_decode($tokenPayload);
        $jtwEvent   = json_decode($jwtPayload->events);

        return $jtwEvent;
    }

    /**
     * Retrieve the User via Apple Token.
     *
     * @param  string  $token
     *
     * @return Builder|Model|object
     */
    protected function getUserFromToken(string $token)
    {
        return User::query()
            ->where('apple_token', $token)
            ->first();
    }
}
