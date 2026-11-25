<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\V1\Admin\NotificationsApiController;
use App\Http\Controllers\Controller;
use App\Jobs\NotifyUserProfileConfirmedAsTeacher;
use App\Jobs\NotifyUserVerificationDeclined;
use App\Mail\ProfileNotVerified;
use App\Mail\ProfileVerified;
use App\Models\Language;
use App\Models\Notifications;
use App\Models\StaticProfession;
use App\Models\User;
use App\Models\UserVerificationRequests;
use App\ModelsApi\Talk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class ProfileVerificationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = UserVerificationRequests::query()->where('status', 0)->with(['user'])->select(sprintf('%s.*', (new UserVerificationRequests)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $approveVerification    = true;
                $disapproveVerification = true;
                $viewUser               = true;
                $crudRoutePart          = 'profile-verifications';

                return view('partials.verificationActions', compact('approveVerification', 'disapproveVerification', 'viewUser', 'crudRoutePart', 'row'));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ?: "";
            });
            $table->editColumn('user_id', function ($row) {
                return $row->user->name ?: "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ?: "";
            });
            $table->editColumn('image', function ($row) {
                return $row->image ?: "";
            });
            $table->editColumn('request_date', function ($row) {
                return $row->request_date ?: "";
            });
            $table->editColumn('approve_date', function ($row) {
                return $row->approve_date ?: "";
            });
            $table->editColumn('status', function ($row) {
                return $row->status ?: "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        $talk = 0;

        $followers = 0;

        $talk = 0;

        $verifications = UserVerificationRequests::with('user', 'user.userUserFolloweds', 'user.userTalks', 'user.userAvailabilities', 'user.billingAddress.countries')
            ->where('status', 0)
            ->orderBy('updated_at')
            ->get();

        $approvalHistory = UserVerificationRequests::select('updated_at', 'name', 'status')
            ->where('status', '!=', 0)
            ->orderBy('updated_at', 'desc')
            ->first();

        $user = $verifications->first();

        $total = $verifications->count('id');

        $talk = 0;

        if (isset($user->user)) {
            if ($user->user->userTalks->count()) {
                $talk = $user->user->userTalks->count();
            }

            if ($user->user->userUserFolloweds->count()) {
                $followers = $user->user->userUserFolloweds->where('state', 1)->count();
            }
        }

        return view('admin.verifications.index', compact('user', 'total', 'followers', 'approvalHistory', 'talk'));
    }

    public function show(Request $request, $id)
    {
        $requestedUser = User::query()->find($id);

        if ($request->ajax()) {
            $query = UserVerificationRequests::query()->where('user_id', $id)
                ->orderByDesc('id')
                ->with(['user'])
                ->select(sprintf('%s.*', (new UserVerificationRequests)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');

            $table->editColumn('user_id', function ($row) {
                return $row->user->name ? $row->user->name : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('image', function ($row) {
                return $row->image ? $row->image : "";
            });
            $table->editColumn('request_date', function ($row) {
                return $row->request_date ? $row->request_date : "";
            });
            $table->editColumn('approve_date', function ($row) {
                return $row->approve_date ? $row->approve_date : "";
            });
            $table->editColumn('status', function ($row) {
                return UserVerificationRequests::STATUS[$row->status];
            });

            $table->rawColumns(['placeholder']);

            return $table->make(true);
        }

        return view('admin.verifications.show', [
            'user' => $requestedUser,
        ]);
    }

    public function approveProfile(Request $request)
    {
        DB::beginTransaction();
        try {
            UserVerificationRequests::query()->find($request->input('id'))->update(['status' => 1, 'approve_date' => date('Y-m-d H:i:s')]);

            $verification = UserVerificationRequests::query()->find($request->input('id'));

            $user = User::query()->find($verification->user_id);
            $user->update(['approved' => 1, 'username' => $user->username]);
            $user->roles()->sync(2);

            if ($user->isPartner()) {
                $dashboard = $user->partner->dashboard;
                $dashboard->update([
                    'total_jtc_verified' => DB::raw('total_jtc_verified + 1'),
                ]);
            }

            $addressUser = User::query()->where('id', $verification->user_id)->first();
            $talk        = Talk::query()->where('teacher_user_id', $addressUser->id)->with(['teacher', 'category', 'subcategory'])->first();
            $languages   = Language::query()->select('id', StaticProfession::DATABASE_LANGUAGE[$request->header('Application-Language', 'en')] . ' as language_name')->where('id', $talk->languages_id)->first();


            Mail::to($addressUser->email)
                ->queue(
                    new ProfileVerified(
                        $addressUser->email,
                        $talk->price,
                        $talk->anonym_call,
                        $talk->call_type,
                        $talk->teacher->name,
                        $languages->language_name,
                        $talk->subcategory->name,
                        $talk->category->name,
                        $talk->headline,
                        $talk->teacher->username,
                        $talk->teacher->profile_picture
                    )
                );

            $notificationData = [
                'user_id' => $user->id,
                'type'    => 'custom',
                'value'   => Notifications::VALUE['account_verified'],
            ];

            NotificationsApiController::sendNotification($request, $notificationData);

            app()->setLocale($user->last_language);

            NotifyUserProfileConfirmedAsTeacher::dispatch($user->id, $user->username);

            session()->flash('message', 'User successfully approved.');

            DB::commit();

            return redirect()->route('admin.profile-verifications.index')->with('message', __('User successfully approved.'));
        } catch (\Exception $exception) {
            DB::rollBack();
            session()->flash('error', 'Something went wrong, please try again.');

            return redirect()->route('admin.profile-verifications.index');
        }
    }

    public function skipProfile(Request $request)
    {
        try {
            UserVerificationRequests::query()->find($request->input('id'))->update(['updated_at' => date('Y-m-d H:i:s')]);

            return redirect()->route('admin.profile-verifications.index')->with('message', __('User skipped.'));
        } catch (\Exception $exception) {
            session()->flash('error', 'Something went wrong, please try again.');

            return redirect()->route('admin.profile-verifications.index');
        }
    }

    public function disapproveProfile(Request $request)
    {
        try {
            $userVerificationRequest = UserVerificationRequests::query()->find($request->input('id'));
            $userVerificationRequest->update(['status' => 2]);

            session()->flash('error', 'User successfully disapproved.');

            $notificationData = [
                'user_id' => $userVerificationRequest->user_id,
                'type'    => 'custom',
                'value'   => Notifications::VALUE['account_not_verified'],
            ];

            NotificationsApiController::sendNotification($request, $notificationData);

            app()->setLocale($userVerificationRequest->user->last_language);

            NotifyUserVerificationDeclined::dispatch($userVerificationRequest->user_id);

            Mail::to($userVerificationRequest->user->email)->queue(
                new ProfileNotVerified(
                    $userVerificationRequest->name,
                    changeDateFormatLocale('Y-m-d H:i:s', getTimeZonedDate2('Y-m-d H:i:s', now()->toDateTimeString()), true)
                )
            );

            return redirect()->route('admin.profile-verifications.index')->with('message', __('User successfully disapproved.'));
        } catch (\Exception $exception) {
            session()->flash('error', 'Something went wrong, please try again.');

            return redirect()->route('admin.profile-verifications.index');
        }
    }
}