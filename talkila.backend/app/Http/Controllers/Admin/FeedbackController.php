<?php

namespace App\Http\Controllers\Admin;

use App\Entity\TalkTypes;
use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFeedbackRequest;
use App\Http\Requests\StoreFeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;
use App\Jobs\NotifyClientHardRefund;
use App\Jobs\NotifyClientSoftRefund;
use App\Jobs\NotifySupplierHardRefund;
use App\Jobs\NotifySupplierSoftRefund;
use App\Mail\BookingHardRefundedTalkClient;
use App\Mail\BookingRefundedTalkClient;
use App\Mail\BookingRefundedTalkSupplier;
use App\Models\Booking;
use App\Models\Feedback;
use App\Models\SocketParticipant;
use App\Models\Talk;
use App\Models\User;
use App\Models\WalletHistory;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FeedbackController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('feedback_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Feedback::with(['reviewer', 'calls.talk', 'calls.teacher_user'])->select(sprintf('%s.*', (new Feedback)->table));

            $table = Datatables::of($query);

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'feedback_show';
                $editGate      = 'feedback_edit';
                $deleteGate    = 'feedback_delete';
                $crudRoutePart = 'feedback';

                return view(
                    'partials.datatablesApproveDecline',
                    compact(
                        'viewGate',
                        'editGate',
                        'deleteGate',
                        'crudRoutePart',
                        'row'
                    )
                );
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });

            $table->editColumn('participiant_email', function ($row) {
                return $row->reviewer ? $row->reviewer->email : '';
            });

            $table->editColumn('reviewer.name', function ($row) {
                if ($row->reviewer !== null) {
                    return $row->reviewer->name ? $row->reviewer->name : '';
                }
                return '';
            });

            $table->editColumn('supplier', function ($row) {
                return $row->calls->teacher_user->name ? $row->calls->teacher_user->name : '';
            });

            $table->editColumn('talk', function ($row) {
                return $row->calls->talk->headline ? $row->calls->talk->headline : '';
            });

            $table->editColumn('calls_message', function ($row) {
                return $row->calls ? $row->calls->message : '';
            });

            $table->editColumn('stars_content', function ($row) {
                return $row->stars_content ? $row->stars_content : "";
            });
            $table->editColumn('stars_voice_quality', function ($row) {
                return $row->stars_voice_quality ? $row->stars_voice_quality : "";
            });
            $table->editColumn('state', function ($row) {
                return $row->state ? $row->state : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'reviewer', 'calls.talk', 'calls.teacher_user']);

            return $table->make(true);
        }

        $feedback = Feedback::with(['reviewer', 'calls.talk', 'calls.teacher_user'])
            ->where('state', 0)
            ->orWhere('state', 3)
            ->orderBy('updated_at')
            ->first();

        $feedbacks = Feedback::get();
        $pending   = Feedback::where('state', 0)->orWhere('state', 3)->count();
        $reviews   = $feedbacks->count();
        $approved  = $feedbacks->where('state', 1)->count();
        $rejected  = $feedbacks->where('state', 2)->count();

        $stars5 = $feedbacks->where('stars_content', 5)->count();
        $stars4 = $feedbacks->where('stars_content', 4)->count();
        $stars3 = $feedbacks->where('stars_content', 3)->count();
        $stars2 = $feedbacks->where('stars_content', 2)->count();
        $stars1 = $feedbacks->where('stars_content', 1)->count();

        $users    = User::get()->pluck('email')->toArray();
        $bookings = Booking::get()->pluck('message')->toArray();

        return view('admin.feedback.index', compact('users', 'feedback', 'bookings', 'reviews', 'approved', 'pending', 'rejected', 'stars5', 'stars4', 'stars3', 'stars2', 'stars1'));
    }

    public function create()
    {
        abort_if(Gate::denies('feedback_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $participiants = User::all()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $calls = Booking::all()->pluck('message', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.feedback.create', compact('participiants', 'calls'));
    }

    public function store(StoreFeedbackRequest $request)
    {
        $feedback = Feedback::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $feedback->id]);
        }

        return redirect()->route('admin.feedback.index');
    }

    public function edit(Feedback $feedback)
    {
        abort_if(Gate::denies('feedback_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $participiants = User::all()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $calls = Booking::all()->pluck('message', 'id')->prepend(trans('global.pleaseSelect'), '');

        $feedback->load('reviewer', 'calls');

        return view('admin.feedback.edit', compact('participiants', 'calls', 'feedback'));
    }

    public function update(UpdateFeedbackRequest $request, Feedback $feedback)
    {
        $feedback->update($request->all());

        return redirect()->route('admin.feedback.index');
    }

    public function show(Feedback $feedback)
    {
        abort_if(Gate::denies('feedback_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $feedback->load('reviewer', 'calls');

        return view('admin.feedback.show', compact('feedback'));
    }

    public function userFeedback(Request $request, $id)
    {
        if ($request->ajax()) {
            $query = Feedback::with(['reviewer', 'calls.talk'])->where('user_id', $id)->get();

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '');

            $table->editColumn('actions', function ($row) {
                $editGate      = 'feedback_edit';
                $crudRoutePart = 'feedback';

                return view(
                    'partials.datatablesActionsEdit',
                    compact(
                        'editGate',
                        'crudRoutePart',
                        'row'
                    )
                );
            });

            return $table->make(true);
        }
    }

    public function destroy(Feedback $feedback)
    {
        abort_if(Gate::denies('feedback_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $feedback->delete();

        return back();
    }

    public function massDestroy(MassDestroyFeedbackRequest $request)
    {
        Feedback::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('feedback_create') && Gate::denies('feedback_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Feedback();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function updateStatus(Request $request, $feedback_id)
    {
        /**
         * @var $oFeedback \App\Models\Feedback
         */
        $oFeedback             = Feedback::query()->find($feedback_id);
        $oFeedback->state      = $request->input('status');
        $oFeedback->updated_at = now();
        $oFeedback->save();

        return back();
    }

    public function waitingForApproval(Request $request)
    {
        abort_if(Gate::denies('feedback_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $feedback = Feedback::with(['reviewer', 'calls.talk', 'calls.teacher_user'])
            ->where('state', 0)
            ->orWhere('state', 3)
            ->orderBy('updated_at')
            ->first();

        $feedbacks = Feedback::get();
        $pending   = Feedback::where('state', 0)->orWhere('state', 3)->count();
        $reviews   = $feedbacks->count();
        $approved  = $feedbacks->where('state', 1)->count();
        $rejected  = $feedbacks->where('state', 2)->count();

        $stars5 = $feedbacks->where('stars_content', 5)->count();
        $stars4 = $feedbacks->where('stars_content', 4)->count();
        $stars3 = $feedbacks->where('stars_content', 3)->count();
        $stars2 = $feedbacks->where('stars_content', 2)->count();
        $stars1 = $feedbacks->where('stars_content', 1)->count();

        $users    = User::get()->pluck('email')->toArray();
        $bookings = Booking::get()->pluck('message')->toArray();

        return view('admin.feedback.waitingForApproval', compact('users', 'feedback', 'bookings', 'reviews', 'approved', 'pending', 'rejected', 'stars5', 'stars4', 'stars3', 'stars2', 'stars1'));
    }

    public function feedbackUnderReview(Request $request)
    {
        abort_if(Gate::denies('feedback_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $client   = User::withTrashed()->select('id', 'name')->withCount('participiantBookings as bookingsCount');
            $talk     = Talk::query()->select('id', 'headline');
            $bookings = Booking::query()->select('bookings.id as bookingId', 'talk_id', 'teacher_user_id', 'price', 'duration', 'talks.id as talkId', 'talks.headline as talkName', 'users.id as teacherId', 'users.name as teacherName')
                ->leftJoinSub($talk, 'talks', function ($join) {
                    $join
                        ->on('talks.id', '=', 'bookings.talk_id');
                })
                ->leftJoinSub($client, 'users', function ($join) {
                    $join
                        ->on('users.id', '=', 'bookings.teacher_user_id');
                });

            $feedback = Feedback::query()->select('user_id', 'feedback.id as id', 'feedback.updated_at as date', 'feedback.user_id as participantId', 'users.name as participantName', 'users.bookingsCount', 'bookings.*')
                ->where('stars_content', 1)
//                ->where(function($query) {
//                    $query->where('under_review_status', Feedback::REVIEW_STATUS['not_reviewed']);
//                    $query->orWhere('under_review_status', Feedback::REVIEW_STATUS['no_action_refund']);
//                })
                ->where('under_review_status', Feedback::REVIEW_STATUS['not_reviewed'])
                ->leftJoinSub($bookings, 'bookings', function ($join) {
                    $join
                        ->on('bookings.bookingId', '=', 'feedback.booking_id');
                })
                ->leftJoinSub($client, 'users', function ($join) {
                    $join
                        ->on('users.id', '=', 'feedback.user_id');
                })
                ->orderBy('updated_at')//                ->get()
            ;

            $table = Datatables::of($feedback);

            $table->editColumn('id', function ($row) {
                return view(
                    'admin.includes._feedback_under_review_table_id',
                    compact(
                        'row'
                    )
                );
            });

            $table->editColumn('date', function ($row) {
                return $row->date ? $row->date : '';
            });

            $table->editColumn('talkName', function ($row) {
                return view(
                    'admin.includes._feedback_under_review_table_talk_name',
                    compact(
                        'row'
                    )
                );
            });

            $table->editColumn('participantName', function ($row) {
                return view('admin.includes._feedback_under_review_table_user', [
                    'id'       => $row->participantId,
                    'userName' => $row->participantName,
                ]);
            });

            $table->editColumn('teacherName', function ($row) {
                return view('admin.includes._feedback_under_review_table_user', [
                    'id'       => $row->teacherId,
                    'userName' => $row->teacherName,
                ]);
            });

            $table->editColumn('bookingsCount', function ($row) {
                return $row->bookingsCount ? $row->bookingsCount : '';
            });

            $table->editColumn('price', function ($row) {
                return $row->price ? $row->price : '';
            });

            $table->editColumn('duration', function ($row) {
                return $row->duration ? $row->duration : '';
            });

            return $table->make(true);
        }

        return view('admin.feedback.feedbackUnderReview');
    }

    public function feedbackUnderReviewShow(Request $request, $feedbackId)
    {
        $requestedFeedback         = Feedback::query()->where('id', $feedbackId)->first();
        $requestedBooking          = Booking::query()->where('id', $requestedFeedback->booking_id)->first();
        $talk                      = Talk::query()->select('id', 'headline')->where('id', $requestedBooking->talk_id)->first();
        $talkTeacher               = User::withTrashed()->select('id', 'name', 'email', 'created_at')->withCount('participiantBookings')->where('id', $requestedBooking->teacher_user_id)->first();
        $talkParticipant           = User::withTrashed()->select('id', 'name', 'email', 'created_at')->withCount('participiantBookings')->where('id', $requestedBooking->participant_user_id)->first();
        $socketParticipantsTeacher = SocketParticipant::query()->where('booking_id', $requestedFeedback->booking_id)->where('user_id', $talkTeacher->id)->first();
        $socketParticipantsUser    = SocketParticipant::query()->where('booking_id', $requestedFeedback->booking_id)->where('user_id', $talkParticipant->id)->first();


        $clientLastFeedback  = Feedback::query()->where('user_id', $talkParticipant->id)->orderByDesc('created_at')->with(['calls.talk.teacher_user'])->limit(10)->get();
        $teacherLastFeedback = Feedback::query()->where('user_id', $talkTeacher->id)->orderByDesc('created_at')->with(['calls.talk'])->limit(10)->get();

        $lastClientFeedback  = [];
        $lastTeacherFeedback = [];
        foreach ($clientLastFeedback as $feedbackClient) {
            $lastClientFeedback[] = [
                'talk_id'      => ! empty($feedbackClient['calls']['talk']) ? $feedbackClient['calls']['talk']['id'] : 'Undefined',
                'talk_name'    => ! empty($feedbackClient['calls']['talk']) ? $feedbackClient['calls']['talk']['headline'] : 'Undefined',
                'talk_teacher' => ! empty($feedbackClient['calls']['talk']['teacher_user']) ? $feedbackClient['calls']['talk']['teacher_user']['name'] : 'Undefined',
                'teacher_id'   => ! empty($feedbackClient['calls']['talk']['teacher_user']) ? $feedbackClient['calls']['talk']['teacher_user']['id'] : 'Undefined',
                'talk_reviews' => ! empty($feedbackClient['calls']['talk']) ? round($feedbackClient['calls']['talk']['ratings'] / $feedbackClient['calls']['talk']['reviews'], 2) : 'Undefined',
            ];
        }
        foreach ($teacherLastFeedback as $feedbackTeacher) {
            $lastTeacherFeedback[] = [
                'talk_id'      => ! empty($feedbackTeacher['calls']['talk']) ? $feedbackTeacher['calls']['talk']['id'] : 'Undefined',
                'talk_name'    => ! empty($feedbackTeacher['calls']['talk']) ? $feedbackTeacher['calls']['talk']['headline'] : 'Undefined',
                'talk_teacher' => ! empty($feedbackTeacher['calls']['talk']['teacher_user']) ? $feedbackTeacher['calls']['talk']['teacher_user']['name'] : 'Undefined',
                'teacher_id'   => ! empty($feedbackTeacher['calls']['talk']['teacher_user']) ? $feedbackTeacher['calls']['talk']['teacher_user']['id'] : 'Undefined',
                'talk_reviews' => ! empty($feedbackTeacher['calls']['talk']) ? round($feedbackTeacher['calls']['talk']['ratings'] / $feedbackTeacher['calls']['talk']['reviews'], 2) : 'Undefined',
            ];
        }

        return view('admin.feedback.feedbackUnderReviewShow', [
            'requestedFeedback'   => $requestedFeedback,
            'requestedBooking'    => $requestedBooking,
            'talk'                => $talk,
            'talkTeacher'         => $talkTeacher,
            'talkParticipant'     => $talkParticipant,
            'participantTeacher'  => $socketParticipantsTeacher,
            'participantUser'     => $socketParticipantsUser,
            'clientLastFeedback'  => $lastClientFeedback,
            'teacherLastFeedback' => $lastTeacherFeedback,
        ]);
    }

    public function updateReviewStatus(Request $request, $feedback_id)
    {
        try {
            \DB::beginTransaction();
            $status = $request->input('status');

            /**
             * @var $oFeedback \App\Models\Feedback
             */
            $oFeedback                      = Feedback::query()->find($feedback_id);
            $oFeedback->under_review_status = $status;
            $oFeedback->updated_at          = now();
            $oFeedback->save();

            $feedback    = Feedback::query()->where('id', $feedback_id)->first();
            $booking     = Booking::query()->where('id', $feedback->booking_id)->with('talk')->first();
            $participant = User::withTrashed()->select('id', 'email')->where('id', $booking->participant_user_id)->first();
            $teacher     = User::withTrashed()->select('id', 'email')->where('id', $booking->teacher_user_id)->first();


            if ($status == 2) {
                NotifyClientSoftRefund::dispatch($participant->id, $booking->talk->headline, Carbon::parse($booking->start_date)->format('d.m.Y'), convertToUserTimezone($booking->start_time, 'H:i'));
                NotifySupplierSoftRefund::dispatch($teacher->id, $booking->talk->headline, Carbon::parse($booking->start_date)->format('d.m.Y'), convertToUserTimezone($booking->start_time, 'H:i'));

                Mail::to($participant->email)
                    ->queue(
                        new BookingRefundedTalkClient(
                            $participant->last_language,
                            $teacher->email,
                            $participant->email,
                            $booking->talk->headline,
                            convertToUserTimezone($booking->start_date, 'd.m.Y'),
                            convertToUserTimezone($booking->start_time, 'H:i'),
                            convertToUserTimezone($booking->end_time, 'H:i'),
                            $booking->duration,
                            $booking->price,
                            $booking->talk->talk_type == TalkTypes::VOICE_CALL ? 'Phone-Talk' : 'Video-Talk',
                            $booking->id
                        )
                    );

                \Mail::to($teacher->email)->queue(
                    new BookingRefundedTalkSupplier(
                        $participant->last_language,
                        $teacher->email,
                        $teacher->name,
                        $booking->talk->headline,
                        // $booking->start_call,
                        convertToUserTimezone($booking->start_call,'d.m.Y'),
                        // $booking->start_time,
                        convertToUserTimezone($booking->start_time,'H:i'),
                        // $booking->end_time,
                        convertToUserTimezone($booking->end_time, 'H:i'),
                        $booking->duration,
                        $booking->price,
                        $booking->talk->talk_type == TalkTypes::VOICE_CALL ? 'Phone-Talk' : 'Video-Talk',
                        $booking->id
                    )
                );

                $this->addFundsInWalletAfterFeedback($participant, $booking);
            } elseif ($status == 3) {
                NotifyClientHardRefund::dispatch($participant->id, $booking->talk->headline, convertToUserTimezone($booking->start_date, 'd.m.Y'), convertToUserTimezone($booking->start_time, 'H:i'));
                NotifySupplierHardRefund::dispatch($teacher->id, $booking->talk->headline, convertToUserTimezone($booking->start_date, 'd.m.Y'), convertToUserTimezone($booking->start_time, 'H:i'));

                \Mail::to($participant->email)->queue(
                    new BookingHardRefundedTalkClient(
                        $participant->last_language,
                        $teacher->email,
                        $participant->email,
                        $booking->talk->headline,
                        // $booking->start_call,
                        convertToUserTimezone($booking->start_date, 'd.m.Y'),
                        // $booking->start_time,
                        convertToUserTimezone($booking->start_time, 'H:i'),
                        // $booking->end_time,
                        convertToUserTimezone($booking->end_time, 'H:i'),
                        $booking->duration,
                        $booking->price,
                        $booking->talk->talk_type == TalkTypes::VOICE_CALL ? 'Phone-Talk' : 'Video-Talk',
                        $booking->id
                    )
                );

                \Mail::to($teacher->email)->queue(
                    new BookingHardRefundedTalkClient(
                        $participant->last_language,
                        $teacher->email,
                        $teacher->name,
                        $booking->talk->headline,
                        // $booking->start_call,
                        convertToUserTimezone($booking->start_call, 'd.m.Y'),
                        // $booking->start_time,
                        convertToUserTimezone($booking->start_time, 'H:i'),
                        // $booking->end_time,
                        convertToUserTimezone($booking->end_time, 'H:i'),
                        $booking->duration,
                        $booking->price,
                        $booking->talk->talk_type == TalkTypes::VOICE_CALL ? 'Phone-Talk' : 'Video-Talk',
                        $booking->id
                    )
                );

                $walletLedger = WalletHistory::query()->where('booking_id', $booking->id)->where('transaction_type', 'credit')->first();


                if ($walletLedger->card_details == 'Paid By PayPal') {
                } elseif (! empty($walletLedger->card_details)) {
                    $stripeController = new StripeController();
                    $stripeController->refundCharge($participant, $walletLedger->transaction_id);
                } else {
                    $this->addFundsInWalletAfterFeedback($participant, $booking);
                }
            }
            \DB::commit();

            return route('feedback-under-review');
        } catch (\Exception $exception) {
            \DB::rollBack();
            \Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['HIGH'], Handler::TYPE_EXCEPTION_2002, self::class, __FUNCTION__);
            \Session::flash('error', 'Something went wrong while updating status please check log.');

            return back();
        }
    }

    public function addFundsInWalletAfterFeedback($participant, $booking)
    {
        $walletHistoryModel = new WalletHistory();
        $walletHistoryModel->addFundsInWallet($participant, $booking->price, WalletHistory::TYPE['CREDIT'], $booking->id, null, null, WalletHistory::STATUS['COMPLETED'], WalletHistory::SOURCE['REFUND']);
    }
}