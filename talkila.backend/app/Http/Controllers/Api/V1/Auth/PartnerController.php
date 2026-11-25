<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerCreateRequest;
use App\Http\Requests\PartnerLoginRequest;
use App\Http\Requests\PartnerLogoutRequest;
use App\Http\Requests\PartnerSaveRequest;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class PartnerController extends Controller
{
    /**
     * User model.
     *
     * @var User
     */
    protected User $user;

    /**
     * Create a new Controller instance.
     */
    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * Retrieve Partner via identifier.
     *
     * @param  string|int  $identifier
     *
     * @return JsonResponse
     */
    public function show($identifier): JsonResponse
    {
        $partner = Partner::query()
            ->where('id', $identifier)
            ->orWhere('slug', $identifier)
            ->select([
                'id',
                'name',
                'slug',
                'logo',
                'url'
            ])
            ->first();

        if (! $partner) {
            throw new ModelNotFoundException();
        }

        return response()->success([
            'message' => 'Partner retrieved successfully.',
            'data'    => $partner,
        ]);
    }

    public function login(PartnerLoginRequest $request)
    {
        if (auth()->guard('partner')->attempt($request->validated())) {
            return $request->user('partner');
        } else {
            return response()->error('Whoops! Invalid email or password.');
        }
    }

    public function logout(PartnerLogoutRequest $request)
    {
        if (!$request->user('partner')) {
            return response()->error('Unauthorized.', 401);
        }

        auth()->guard('partner')->logout();

        return response()->success('Logged out successfully.');
    }

    public function dashboard()
    {
        return auth()->guard('partner')->user()->dashboard;
    }

    /**
     * Save the user data to Partner Users table.
     *
     * @param  PartnerSaveRequest  $request
     * @param  Partner             $partner
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function save(PartnerSaveRequest $request, Partner $partner): JsonResponse
    {
        try {
            $email            = $request->input('email');
            $username         = $request->input('username');
            $isVerified       = $this->user->isVerified($email);
            $isUniqueEmail    = $this->user->hasUniqueEmail($email);
            $isUniqueUsername = $this->user->hasUniqueUsername($username);
            $type             = $isUniqueEmail
                ? Partner::NEW_ACCOUNT
                : ($isVerified ? Partner::HAS_ACCOUNT_VERIFIED : Partner::HAS_ACCOUNT_NOT_VERIFIED);
            $errors           = [];
            $response         = [
                'success' => true,
                'message' => 'Partner account saved.',
                'data'    => [
                    'type' => $type,
                ],
            ];

            if ($type === Partner::NEW_ACCOUNT) {
                if (!$username) {
                    $errors['username'] = [
                        __('ATTRIBUTE_REQUIRED', ['attribute' => 'username']),
                    ];
                }

                if (!$isUniqueUsername) {
                    $errors['username']            = [
                        __('ATTRIBUTE_UNIQUE', ['attribute' => 'username']),
                    ];
                    $response['data']['suggested'] = $this->user->generateUsername($username, 5);
                }
            }

            if (!empty($errors) && $type === Partner::NEW_ACCOUNT) {
                $response['data']['errors'] = $errors;
            }

            $partner->createAccount($request->validated(), $isUniqueEmail);

            Log::notice("\n\n" . '::PartnerController::save::$response');
            Log::notice(json_encode($response));

            return response()->json($response);
        } catch (\Exception $exception) {
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_12000, self::class, __FUNCTION__);

            return response()->error(__('SOMETHING_WENT_WRONG'));
        }
    }

    /**
     * Create a new User and attach it to the Partner if possible.
     *
     * @param  PartnerCreateRequest  $request
     * @param  Partner               $partner
     *
     * @return mixed
     */
    public function create(PartnerCreateRequest $request, Partner $partner)
    {
        return (new AuthController())->register($request);
    }
}
