<?php

namespace App\Http\Controllers\Admin;

use App\Entity\UserInactivityUpdate;
use App\Http\Controllers\Api\V1\Admin\UserApiController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\AccountActivation;
use App\Mail\AccountBlocked;
use App\Mail\JtcWelcome;
use App\Mail\NewEmailAddress;
use App\Mail\VerificationEmail;
use App\Models\Affiliates\Affiliate;
use App\Models\Affiliates\Affiliates;
use App\Models\Affiliates\AffiliatesRevenue;
use App\Models\Affiliates\Subaffiliate;
use App\Models\AuditLog;
use App\Models\Availability;
use App\Models\BillingAddress;
use App\Models\EmailChangeVerification;
use App\Models\EmailHistoriesLog;
use App\Models\JoinTheClub;
use App\Models\Notifications;
use App\Models\NotificationSettings;
use App\Models\ProfilPayoutMethod;
use App\Models\Role;
use App\Models\SocketParticipant;
use App\Models\StaticMetric;
use App\Models\Talk;
use App\Models\TalkCategories;
use App\Models\User;
use App\Models\UserFollowed;
use App\Models\UserImages;
use App\ModelsApi\Booking;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Laravel\Facades\Image;
use SendGrid\Mail\From;
use SendGrid\Mail\TemplateId;
use SendGrid\Mail\To;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

//use SendGrid\Mail\Mail;
//use SendGrid\Mail\From;
//use SendGrid\Mail\To;


class UsersController extends Controller
{
    use CsvImportTrait;

    const DIRECTORY_USER_IMAGES = 'assets/images/user/';

    public function index(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = User::with(['roles', 'talks'])->select(sprintf('%s.*', (new User)->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->addColumn('total_talk_income', function (User $row) {
                return $row->talksTotalIncome() ? '$' . $row->talksTotalIncome() : '$' . '0';
            });
            $table->addColumn('amount_of_followers', function (User $row) {
                return $row->followerUserUserFolloweds()->count();
            });
            $table->editColumn('actions', function ($row) {
                $bookings_count = $row->loadCount('bookings')->bookings_count;
                $booked_count   = $row->loadCount('booked')->booked_count;
                $role           = $row->role()->title;

                $viewGate      = 'user_show';
                $editGate      = 'user_edit';
                $deleteGate    = 'user_delete';
                $hardDelete    = $bookings_count + $booked_count === 0 && $role != 'Admin';
                $crudRoutePart = 'users';

                return view('partials.datatablesUserActions', compact('viewGate', 'editGate', 'deleteGate', 'hardDelete', 'crudRoutePart', 'row'));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ?: "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ?: "";
            });
            $table->editColumn('email', function ($row) {
                return $row->email ?: "";
            });
            $table->editColumn('approved', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->approved ? 'checked' : null) . '>';
            });
            $table->editColumn('verified', function ($row) {
                return $row->verified ?: "";
            });
            $table->editColumn('roles', function ($row) {
                $labels = [];

                foreach ($row->roles as $role) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $role->title);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'approved', 'verified', 'roles']);

            return $table->make(true);
        }

        $roles             = Role::get()->pluck('title')->toArray();
        $nTalksTotalIncome = Talk::query()->selectRaw('SUM(price) AS total_all')->first();
        $aTeacherUsers     = User::query()->whereHas('roles', function ($q) {
            $q->where('id', 2);
        })->count();

        $nTotalUsersToday = User::query()->whereDate('created_at', date('Y-m-d'))->count();
        $totalUsers       = User::count();

        return view('admin.users.index', compact('totalUsers', 'roles', 'nTalksTotalIncome', 'nTotalUsersToday', 'aTeacherUsers'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $billing_addresses = BillingAddress::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.users.create', compact('roles', 'billing_addresses'));
    }

    public function store(StoreUserRequest $request)
    {
        try {
            if (preg_match('@^(?:https://(?:www\\.)?youtube.com/)(watch\\?v=|v/)([a-zA-Z0-9_]*)@', $request->input('youtube_video'), $match)) {
                $youtubeVideo = $request->input('youtube_video');
            } else {
                $youtubeVideo = '';
            }
            DB::beginTransaction();
            $request->request->add(['youtube_video' => $youtubeVideo]);

            $user = User::create($request->all());
            $user->roles()->sync($request->input('roles', []));

            if ($request->has('profile_picture')) {
                $file = $request->file('profile_picture');

                $validateImage = UserApiController::detectImageSafeSearch($file->getRealPath())->getData('true');

                if ($validateImage['data']) {
                    $extension = $file->getClientOriginalExtension();

                    $imageName       = "{$user->id}.{$extension}";
                    $imagePath       = self::DIRECTORY_USER_IMAGES . $user->id;
                    $imagePathPublic = public_path($imagePath);

                    if (!is_dir($imagePathPublic)) {
                        mkdir($imagePathPublic, 0777, true);
                    }

                    Image::read($file)->resize(300, 300)->save($imagePathPublic . DIRECTORY_SEPARATOR . $imageName);

                    $userImage          = new UserImages;
                    $userImage->user_id = $user->id;
                    $userImage->image   = asset('/') . $imagePath . DIRECTORY_SEPARATOR . $imageName;
                    $userImage->state   = 1;
                    $userImage->size    = 300;
                    $userImage->save();
//                    $user->profile_picture = $userImage->image;
                } else {
                    DB::rollBack();
                    Session::flash('error', 'Your image doesnt fit with our privacy police.');

                    return redirect()->back();
                }
            }

            $user->save();

            $verificationMessage = config('app.frontend_url') . '/verification-account?id=' . $user->id . '&hash=' . $user->verification_token;

//            EmailsHolderController::accountActivation('en', $user->email, $user->name, $user->username_url, $verificationMessage, $user->created, $user->created_at);
            Mail::to($request->email)->queue(new AccountActivation($request->header('Application-Language', 'en'), $request->email, $request->name, 'moj-url', $verificationMessage, date('Y-m-d H:i:s')));


            DB::commit();

            return redirect()->route('admin.users.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error(var_export($exception, true));

            return response()->json([
                'message' => 'Request failed',
                'success' => false,
            ], 200);
        }
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $user->load('roles');

        $billing_addresses = $user->billings()->get([
            'id',
            'company_name as name',
            'street',
            'zipcode as zip',
            'city',
        ]);

        return view('admin.users.edit', compact('roles', 'user', 'billing_addresses'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        if (preg_match('@^(?:https://(?:www\\.)?youtube.com/)(watch\\?v=|v/)([a-zA-Z0-9_]*)@', $request->input('youtube_video'), $match)) {
            $youtubeVideo = $request->input('youtube_video');
        } else {
            $youtubeVideo = '';

            if (!empty($request->input('youtube_video'))) {
                Session::flash('error', 'Video need to be youtube.');

                return redirect()->back();
            }
        }

        if ($user->email != $request->input('email')) {
            $emailChangeRequest                    = new EmailChangeVerification;
            $emailChangeRequest->requested_email   = $request->input('email');
            $emailChangeRequest->user_id           = $user->id;
            $emailChangeRequest->verification_code = Hash::make(substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!$<>"), 0, 10));
            $emailChangeRequest->status            = 0;
            $emailChangeRequest->save();

            $data = [
                'verificationMessage' => route('users.user-email-verify', ['id' => 1, 'hash' => Hash::make(substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6))]),
                'message'             => 'This is message',
                'recipient'           => $request->input('email'),
            ];
//            Mail::to('katic.bojan92@gmail.com')->send(new VerificationEmail($data));
        }

        if ($request->input('state') == 3 && (empty($request->input('deactivation_reason')) || $request->input('deactivation_reason') == '')) {
            Session::flash('error', 'Reason for deactivation of user is needed.');

            return redirect()->back();
        } else {
            if ($request->input('state') == 3) {
                // TODO CHECK ALL COURSES AND PAUSE THEM, AND REFUND BOOKINGS IF THERE IS SOME PAYED BOOKINS

                $this->userDeactivated($user);

                Mail::to('katic.bojan92@gmail.com')->queue(new AccountBlocked('Account blocked', $user->email, $user->username, $request->input('deactivation_reason')));
            }
        }

        if ($request->input('state') == 2) {
            $this->userSpam($user);
        }

        $request->request->add(['youtube_video' => $youtubeVideo]);

        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user->load('roles', 'userUserBlockeds', 'participiantBookings', 'userTalks', 'blockedUserUserBlockeds', 'UserBookmarkedTalks', 'userUserFolloweds', 'followerUserUserFolloweds', 'userEmailHistories', 'userUserDontShowAgains', 'dontShowAgainUserUserDontShowAgains', 'userProfilCvs', 'userLanguagesProfils', 'userAvailabilities', 'participiantFeedback', 'userUserReporteds', 'reporterUserUserReporteds', 'userUserVisiteds', 'visitedUserUserVisiteds', 'userSearches', 'billingAddress', 'payouts');

        $categories = TalkCategories::select('english')
            ->groupBy('english')
            ->get();

        // dd(EmailHistoriesLog::with('user')->where('to_user', $user->email)->get());
        $clubStatus        = $user->jtc;
        $billingAddress    = $user->billingAddress->count();
        $payouts           = $user->payouts->count();
        $booking           = $user->participiantBookings->count();
        $talk              = $user->userTalks->count();
        $reviews           = $user->participiantFeedback->count();
        $blocked           = $user->userUserBlockeds->count();
        $followed          = $user->userUserFolloweds->count();
        $profilCv          = $user->userProfilCvs->count();
        $reported          = $user->userUserReporteds->count();
        $visited           = $user->userUserVisiteds->count();
        $userDontShowAgain = $user->userUserDontShowAgains->count();
        $userSearch        = $user->userSearches->count();
        $userBookTalks     = $user->userBookmarkedTalks->count();
        $emailHistoryCount = $user->receivedEmailHistory->count();

        $bookingRevenue = 0;
        $talkRevenue    = 0;

        foreach ($user->participiantBookings as $ub) {
            $bookingRevenue += $ub->price;
        }

        foreach ($user->userTalks as $ut) {
            $talkRevenue += $ut->price;
        }

        return view('admin.users.show', compact('user', 'clubStatus', 'booking', 'talk', 'reviews', 'blocked', 'followed', 'reported', 'visited', 'userDontShowAgain', 'userSearch', 'profilCv', 'userBookTalks', 'billingAddress', 'payouts', 'categories', 'bookingRevenue', 'talkRevenue', 'emailHistoryCount'));
    }

    public function destroy(Request $request, User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        DB::transaction(function () use ($request, $user) {
            if ($request->boolean('hard')) {
                $rows = EmailChangeVerification::query()->where('user_id', $user['id'])->where('requested_email', $user['email'])->forceDelete();
                Log::notice("Deleted {$rows} rows for EmailChangeVerification Model for user {$user['email']}");

                $rows = UserFollowed::query()->where('user_id', $user['id'])->forceDelete();
                Log::notice("Deleted {$rows} rows for UserFollowed Model for user {$user['email']} as a user");

                $rows = UserFollowed::query()->where('follower_user_id', $user['id'])->forceDelete();
                Log::notice("Deleted {$rows} rows for UserFollowed Model for user {$user['email']} as a follower");

                $rows = Booking::query()->where('participant_user_id', $user['id'])->forceDelete();
                Log::notice("Deleted {$rows} rows for Booking Model for user {$user['email']} as a participant");

                $rows = Booking::query()->where('teacher_user_id', $user['id'])->forceDelete();
                Log::notice("Deleted {$rows} for Booking Model for user {$user['email']} as a teacher");

                $rows = Talk::query()->where('teacher_user_id', $user['id'])->forceDelete();
                Log::notice("Deleted {$rows} rows for Talk Model for user {$user['email']}");

                $rows = ProfilPayoutMethod::query()->where('user_id', $user['id'])->forceDelete();
                Log::notice("Deleted {$rows} rows for ProfilPayoutMethod Model for user {$user['email']}");

                $rows = Availability::query()->where('user_id', $user['id'])->forceDelete();
                Log::notice("Deleted {$rows} rows for Availability Model for user {$user['email']}");

                $rows = AuditLog::query()->where('user_id', $user['id'])->forceDelete();
                Log::notice("Deleted {$rows} rows for AuditLog Model for user {$user['email']}");

                $rows = UserImages::query()->where('user_id', $user['id'])->forceDelete();
                Log::notice("Deleted {$rows} rows for UserImages Model for user {$user['email']}");

                $rows = StaticMetric::query()->where('user_id', $user['id'])->forceDelete();
                Log::notice("Deleted {$rows} rows for StaticMetric Model for user {$user['email']}");

                $rows = JoinTheClub::query()->where('users_id', $user['id'])->forceDelete();
                Log::notice("Deleted {$rows} rows for JoinTheClub Model for user {$user['email']}");

                $rows = Notifications::query()->where('users_id', $user['id'])->forceDelete();
                Log::notice("Deleted {$rows} rows for Notifications Model for user {$user['email']}");

                $rows = NotificationSettings::query()->where('user_id', $user['id'])->forceDelete();
                Log::notice("Deleted {$rows} rows for NotificationSettings Model for user {$user['email']}");

                $rows = BillingAddress::query()->where('user_id', $user['id'])->forceDelete();
                Log::notice("Deleted {$rows} rows for BillingAddress Model for user {$user['email']}");

                $rows = User::query()->where('id', $user['id'])->forceDelete();
                Log::notice("Deleted {$rows} rows for User Model for user {$user['email']}");
            } else {
                $user->deactivate();
            }
        });

        return redirect()->route('admin.users.index')->with('success', 'User successfully deleted.');
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function verification(Request $request)
    {
        try {
            $api_call = $request->input('api_call');

            $emailChangeVerificationEmail = EmailChangeVerification::query()->where('user_id', $request->input('id'))
                ->where('verification_code', $request->input('hash'))
                ->where('status', 0)
                ->first();

            if (!empty($emailChangeVerificationEmail)) {
                $requested_user = User::query()->find($request->input('id'));
                User::query()->find($request->input('id'))->update(['email' => $emailChangeVerificationEmail->requested_email]);
                $emailChangeVerificationEmail->update(['status' => 1]);
                $message = 'User email address successfully updated';

                Mail::to($emailChangeVerificationEmail->requested_email)->queue(new NewEmailAddress($request->header('Application-Language', 'en'), $emailChangeVerificationEmail->requested_email, $requested_user->name, 'url', 'temporary_url', date('Y-m-d H:i:s')));

                StaticMetric::query()->where('user_id', $requested_user->id)->increment('received_emails');
            } else {
                $message = 'Not found request for requested code.';
            }

            if (empty($api_call)) {
                session()->flash('message', $message);

                return redirect()->route('admin.home');
            } else {
                session()->flash('message', $message);

                return response()->success($message);
            }
        } catch (\Exception $e) {
            Log::error(var_export($e, true));

            return response()->error(__('REQUEST_FAILED'), 500);
        }
    }

    public function registrationVerification(Request $request)
    {
        try {
            $api_call = $request->input('api_call');
            $user     = User::query()
                ->where('id', $request->input('id'))
                ->where('verification_token', $request->input('hash'))
                ->first();

            if (!empty($user)) {
                if (!$user->verified) {
                    $response = [
                        'success' => true,
                        'message' => 'User successfully verified',
                    ];

                    if ($user->userRole() == 'Affiliate') {
                        $user->update(['verified' => 1, 'verified_at' => date('Y-m-d H:i:s')]);
                    } else {
                        $user->update(['verified' => 1, 'approved' => 1, 'verified_at' => date('Y-m-d H:i:s')]);

                        if (!$request->user()) {
                            $firebase_token = $request->input('fcm_token');
                            $firebase_type  = $request->input('device_type');
                            $voip_token     = $request->input('voip_token');
                            $tokenResult    = $user->createToken('Personal Access Token');
                            $token          = $tokenResult->token;
                            $token->save();

                            if (!empty($firebase_type)) {
                                if (!empty($firebase_token) && $firebase_token != $user->firebase_id) {
                                    Log::notice("\n\n" . '::UsersController::registrationVerification::$firebase_token');
                                    Log::notice($firebase_token);

                                    $user->update([
                                        'firebase_id' => $firebase_token,
                                    ]);

                                    User::query()
                                        ->where('firebase_id', $firebase_token)
                                        ->where('id', '!=', $user->id)
                                        ->update([
                                            'firebase_id' => null,
                                        ]);
                                }

                                if ($voip_token != $user->voip_token) {
                                    Log::notice("\n\n" . '::UsersController::registrationVerification::$firebase_token');
                                    Log::notice($voip_token);

                                    $user->update([
                                        'voip_token' => $voip_token,
                                    ]);

                                    if (!empty($voip_token)) {
                                        User::query()
                                            ->where('voip_token', $voip_token)
                                            ->where('id', '!=', $user->id)
                                            ->update([
                                                'voip_token' => null,
                                            ]);
                                    }
                                }

                                if (!empty($voip_token) && $firebase_type == 'ios' && $voip_token != $user->voip_token) {
                                    SocketParticipant::query()
                                        ->where('user_id', $user->id)
                                        ->update([
                                            'firebase_id' => $voip_token
                                        ]);

                                    SocketParticipant::query()
                                        ->where('user_id', '!=', $user->id)
                                        ->where('firebase_id', $voip_token)
                                        ->update([
                                            'firebase_id' => null
                                        ]);
                                } elseif (!empty($firebase_token) && $firebase_type == 'android' && $firebase_token != $user->firebase_id) {
                                    SocketParticipant::query()
                                        ->where('user_id', $user->id)
                                        ->update([
                                            'firebase_id' => $firebase_token
                                        ]);

                                    SocketParticipant::query()
                                        ->where('user_id', '!=', $user->id)
                                        ->where('firebase_id', $firebase_token)
                                        ->update([
                                            'firebase_id' => null
                                        ]);
                                }
                            }

                            if (!empty($firebase_type) && $firebase_type != $user->device_type) {
                                Log::notice("\n\n" . '::UsersController::registrationVerification::$firebase_type');
                                Log::notice($firebase_type);

                                $user->update([
                                    'device_type' => $firebase_type
                                ]);
                            }

                            session()->put('access_token', 'Bearer ' . $tokenResult->accessToken);
                            auth()->loginUsingId($user->id);

                            $response['data'] = [
                                'email' => $user->email,
                                'token' => [
                                    'access_token' => $tokenResult->accessToken,
                                    'token_type'   => 'Bearer',
                                    'expires_at'   => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
                                ],
                            ];
                        }
                    }

                    $existJoinTheClub = JoinTheClub::query()
                        ->where('users_id', '=', $user->id)
                        ->exists();

                    if (!$existJoinTheClub) {
                        $joinTheClubStepOne           = new JoinTheClub();
                        $joinTheClubStepOne->users_id = $user->id;
                        $joinTheClubStepOne->save();
                    }

                    $existStaticMetric = StaticMetric::query()
                        ->where('user_id', '=', $user->id)
                        ->exists();

                    if (!$existStaticMetric) {
                        //Create static metric
                        $staticMetric          = new StaticMetric();
                        $staticMetric->user_id = $user->id;
                        $staticMetric->save();
                    }

                    Mail::to($user->email)->queue(new JtcWelcome($user->email));
                } else {
                    $response = [
                        'success' => true,
                        'message' => 'User is already verified',
                        'data'    => [
                            'email' => $user->email,
                        ],
                    ];
                }
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Something went wrong, user not verified',
                ];
            }

            if (empty($api_call)) {
                session()->flash('message', $response['message']);

                if ($user->userRole() == 'Affiliate') {
                    return redirect()->route('affiliate.home');
                } else {
                    return redirect()->route('home');
                }
            } else {
                // TODO: Check with Milorad if this is needed.
                // Remove Verification Message cookie once the user has been verified.
                // setcookie('verificationMessage', 'Please verify your account', time() - 3600, '/account/login');

                return response()->json($response);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine() . "\n" . $e->getTraceAsString());

            return response()->error(__('REQUEST_FAILED'), 500);
        }
    }

    public function userSpam($user)
    {
        try {
            Booking::query()->where('participant_user_id', $user->id)
                ->where('start_call', '>', date('Y-m-d H:i:s'))
                ->update([
                    'state'                  => 2,
                    'cancellation_reason_id' => 4,
                ]);

            return response()->success(__('FUTURE_BOOKING_CANCELLED'));
        } catch (\Exception $e) {
            Log::error(var_export($e, true));

            return response()->error(__('REQUEST_FAILED'), 500);
        }
    }

    public function userDeactivated($user)
    {
        try {
            Booking::query()->where('participant_user_id', $user->id)
                ->where('start_call', '>', date('Y-m-d H:i:s'))
                ->where('start_call', '<', date('Y-m-d H:i:s', strtotime('+48 hours')))
                ->update([
                    'state'                  => 2,
                    'cancellation_reason_id' => 4,
                ]);

            return response()->success(__('FUTURE_BOOKING_CANCELLED'));
        } catch (\Exception $e) {
            Log::error(var_export($e, true));

            return response()->error(__('REQUEST_FAILED'), 500);
        }
    }

    public function sendEmail($subject = null, $message = null, $recipiant = null)
    {
        $from  = new From("mail@talkila.com", "Test User");
        $tos   = [
            new To(
                $recipiant,
                "Bojan",
                [
                    'subject' => $subject,
                    'message' => $message,
                    'name'    => 'Bojan',
                    'city2'   => 'Denver',
                ]
            ),
        ];
        $email = new \SendGrid\Mail\Mail(
            $from,
            $tos
        );

        $email->setSubject($subject);
        $email->setTemplateId(
            new TemplateId("d-2394f6d0066344a7a578bec47afc5637")
        );

        $sendgrid = new \SendGrid(config('talkila.sendgrid_api_key'));
        try {
            $response = $sendgrid->send($email);
            if ($response) {
                /**
                 * @var $emailHistoriesLog \App\Models\EmailHistoriesLog;
                 */
                $emailHistoriesLog              = new EmailHistoriesLog();
                $emailHistoriesLog->from_user   = "talkila@blazingsun.space";
                $emailHistoriesLog->to_user     = $recipiant;
                $emailHistoriesLog->subject     = $subject;
                $emailHistoriesLog->message     = $message;
                $emailHistoriesLog->template_id = "d-2394f6d0066344a7a578bec47afc5637";
                $emailHistoriesLog->save();
            }

            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
    }

    public function checkAndUpdateInactiveUsers()
    {
        try {
            $currentDateSevenDays = date('Y-m-d H:i:s', strtotime('-' . UserInactivityUpdate::DAYS . ' days'));

            $inactiveUsers = User::query()->whereNotNull('last_login')->where('last_login', '<', $currentDateSevenDays)->get()->toArray();
            DB::beginTransaction();
            foreach ($inactiveUsers as $user) {
                User::query()->where('id', $user['id'])->update(['username' => null]);
                JoinTheClub::query()->where('user_id', $user['id'])->update(['step_1' => 0, 'state' => 0]);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice("\n\n" . '::UsersController::checkAndUpdateInactiveUsers::kernel');
            Log::notice($exception->getMessage());
        }
    }

    public function checkNotVerifiedUsers()
    {
        try {
            $currentDateSevenDays = date('Y-m-d H:i:s');

            $unverifiedUsers = User::query()->where('verified', '0')->get()->toArray();
            DB::beginTransaction();

            foreach ($unverifiedUsers as $user) {
                $createdUser     = strtotime($user['created_at']);
                $hoursDifference = abs(strtotime($currentDateSevenDays) - $createdUser) / (60 * 60);
                if ($hoursDifference > 24) {
                    $rows = EmailChangeVerification::query()->where('user_id', $user['id'])->where('requested_email', $user['email'])->forceDelete();
                    Log::notice("Deleted {$rows} rows for EmailChangeVerification Model for user {$user['email']}");

                    $rows = UserFollowed::query()->where('user_id', $user['id'])->forceDelete();
                    Log::notice("Deleted {$rows} rows for UserFollowed Model for user {$user['email']} as a user");

                    $rows = UserFollowed::query()->where('follower_user_id', $user['id'])->forceDelete();
                    Log::notice("Deleted {$rows} rows for UserFollowed Model for user {$user['email']} as a follower");

                    $rows = Booking::query()->where('participant_user_id', $user['id'])->forceDelete();
                    Log::notice("Deleted {$rows} rows for Booking Model for user {$user['email']} as a participant");

                    $rows = Booking::query()->where('teacher_user_id', $user['id'])->forceDelete();
                    Log::notice("Deleted {$rows} for Booking Model for user {$user['email']} as a teacher");

                    $rows = Talk::query()->where('teacher_user_id', $user['id'])->forceDelete();
                    Log::notice("Deleted {$rows} rows for Talk Model for user {$user['email']}");

                    $rows = ProfilPayoutMethod::query()->where('user_id', $user['id'])->forceDelete();
                    Log::notice("Deleted {$rows} rows for ProfilPayoutMethod Model for user {$user['email']}");

                    $rows = Availability::query()->where('user_id', $user['id'])->forceDelete();
                    Log::notice("Deleted {$rows} rows for Availability Model for user {$user['email']}");

                    $rows = AuditLog::query()->where('user_id', $user['id'])->forceDelete();
                    Log::notice("Deleted {$rows} rows for AuditLog Model for user {$user['email']}");

                    $rows = UserImages::query()->where('user_id', $user['id'])->forceDelete();
                    Log::notice("Deleted {$rows} rows for UserImages Model for user {$user['email']}");

                    $rows = StaticMetric::query()->where('user_id', $user['id'])->forceDelete();
                    Log::notice("Deleted {$rows} rows for StaticMetric Model for user {$user['email']}");

                    $rows = JoinTheClub::query()->where('users_id', $user['id'])->forceDelete();
                    Log::notice("Deleted {$rows} rows for JoinTheClub Model for user {$user['email']}");

                    $rows = Notifications::query()->where('users_id', $user['id'])->forceDelete();
                    Log::notice("Deleted {$rows} rows for Notifications Model for user {$user['email']}");

                    $rows = NotificationSettings::query()->where('user_id', $user['id'])->forceDelete();
                    Log::notice("Deleted {$rows} rows for NotificationSettings Model for user {$user['email']}");

                    $rows = BillingAddress::query()->where('user_id', $user['id'])->forceDelete();
                    Log::notice("Deleted {$rows} rows for BillingAddress Model for user {$user['email']}");

                    $rows = User::query()->where('id', $user['id'])->forceDelete();
                    Log::notice("Deleted {$rows} rows for User Model for user {$user['email']}");
                }
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice("\n\n" . '::UsersController::checkNotVerifiedUsers::kernel');
            Log::notice($exception->getMessage());
        }
    }

    public function affiliateUsers(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = User::with(['roles', 'talks'])->whereHas(
                'roles', function ($q) {
                $q->where('id', 4);
            }
            )->select(sprintf('%s.*', (new User)->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                return view(
                    'partials.datatablesAffiliateActions',
                    compact(
                        'row'
                    )
                );
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : "";
            });

            $table->editColumn('approved', function ($row) {
                return $row->approved;
            });


            $table->rawColumns(['actions', 'placeholder', 'approved']);

            return $table->make(true);
        }

        $affiliateUsers       = User::query()->whereHas(
            'roles',
            function ($q) {
                $q->where('id', 4);
            }
        );
        $clonedAffiliateusers = clone $affiliateUsers;

        $totalAffiliateUsers = $clonedAffiliateusers->count();
        $totalApproved       = $clonedAffiliateusers->where('approved', true)->count();
        $totalDisapproved    = User::query()->whereHas(
            'roles',
            function ($q) {
                $q->where('id', 4);
            }
        )
            ->where('approved', false)->count();

        $totalRevenue = AffiliatesRevenue::query()->sum('revenue');


        //  dd($totalUsers);

        return view('admin.users.affiliate_users', [
            'totalAffiliateUsers' => $totalAffiliateUsers,
            'totalApproved'       => $totalApproved,
            'totalDisapproved'    => $totalDisapproved,
            'totalRevenue'        => $totalRevenue,
        ]);
    }

    public function actionAffiliate(Request $request)
    {
        try {
            DB::beginTransaction();

            $requestedUser  = $request->input('user');
            $requestedState = $request->input('state');

            $user = User::query()->where('id', $requestedUser);

            if ($user->exists()) {
                User::query()->where('id', $requestedUser)->update(['approved' => $requestedState]);

                $userAffilaite = Affiliate::query()->where('user_id', $requestedUser)->first();

                Affiliate::query()->where('user_id', $requestedUser)->update(['state' => $requestedState]);

                Subaffiliate::query()->where('affiliate_id', $userAffilaite->id)->update(['state' => $requestedState]);

                Session::flash('alert-success', __('USER_APPROVE_STATE_UPDATED'));
            } else {
                Session::flash('alert-danger', __('REQUESTED_USER_NOT_FOUND'));
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice("\n\n" . '::UsersController::insertAffiliate');
            Log::notice($exception->getMessage());

            Session::flash('alert-danger', __('SOMETHING_WENT_WRONG'));
        }

        return redirect()->route('admin.users.affiliateUsers');
    }

    public function insertAffiliate($userId, $roles)
    {
        try {
            DB::beginTransaction();

            foreach ($roles as $role) {
                if ($role == 4) {
                    $payPalAddress = null;

                    $payoutMethods = ProfilPayoutMethod::query()->where('user_id', $userId)->where('method', ProfilPayoutMethod::METHOD['paypal'])->exists();
                    if ($payoutMethods) {
                        $payPalAddress = $payoutMethods->value;
                    }
                    Affiliate::insert(['user_id' => $userId, 'paypal_address' => $payPalAddress]);
                }
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::notice("\n\n" . '::UsersController::insertAffiliate');
            Log::notice($exception->getMessage());
        }
    }
}
