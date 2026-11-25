<?php

namespace App\Http\Controllers\Admin;

use App\Entity\CallTypes;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTalkRequest;
use App\Http\Requests\StoreTalkRequest;
use App\Http\Requests\UpdateTalkRequest;
use App\Models\BillingAddress;
use App\Models\FinanceCurrency;
use App\Models\Language;
use App\Models\Talk;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TalkController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('talk_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Talk::query()
                ->where('talks.state', Talk::STATE['valid'])
                ->join('users', 'talks.teacher_user_id', '=', 'users.id')
                ->join('languages', 'talks.languages_id', '=', 'languages.id')
                ->select([
                    'talks.id',
                    'email',
                    'english',
                    'headline',
                    'duration',
                    'price',
                    'anonym_call',
                    'call_type',
                ]);

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'talk_show';
                $editGate      = 'talk_edit';
                $deleteGate    = 'talk_delete';
                $crudRoutePart = 'talks';

                return view(
                    'partials.datatablesActions',
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
                return $row->id ?: "";
            });
            $table->addColumn('email', function ($row) {
                return $row->email ?: '';
            });

            $table->addColumn('english', function ($row) {
                return $row->english ?: '';
            });

            $table->editColumn('anonym_call', function ($row) {
                return $row->anonym_call ? 'Yes' : 'No';
            });

            $table->editColumn('call_type', function ($row) {
                return $row->call_type === Talk::CALL_TYPE['voice_call'] ? 'Voice' : 'Video';
            });

            $table->editColumn('headline', function ($row) {
                return $row->headline ?: "";
            });

            $table->editColumn('duration', function ($row) {
                return $row->duration ?: "";
            });

            $table->editColumn('price', function ($row) {
                return $row->price ? "{$row->price}€" : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.talks.index');
    }

    public function create()
    {
        abort_if(Gate::denies('talk_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teacher_users = User::all()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $languages = Language::all()->pluck('english', 'id')->prepend(trans('global.pleaseSelect'), '');

        $finance_currencies = FinanceCurrency::all()->pluck('symbol', 'id')->prepend(trans('global.pleaseSelect'), '');

        $billing_addresses = BillingAddress::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.talks.create', compact('teacher_users', 'languages', 'finance_currencies', 'billing_addresses'));
    }

    public function store(StoreTalkRequest $request)
    {
        /* Talk Type Change */
        // if($request->input('talk_type') == 2) {
        if ($request->input('call_type') == CallTypes::GROUP) {
            if (empty($request->input('start_time_call')) || empty($request->input('end_time_call'))) {
                return redirect()->route('admin.talks.index')->with('message', 'For group talk start and end time is required.');
            } else {
                if (empty($request->input('weekday'))) {
                    return redirect()->route('admin.talks.index')->with('message', 'For group talk weekday is required.');
                }
            }
            // check if talk overlap with existing one
            $startCallTimeCheck = $request->input('start_time_call');
            $endCallTimeCheck   = $request->input('end_time_call');
            $weekday            = $request->input('weekday');

            $isTalkTaken = Talk::query()
                ->where('teacher_user_id', $request->user()->id)
                ->where('state', Talk::STATE['valid'])
                ->where('weekday', $weekday)
                ->where(function ($q) use ($startCallTimeCheck, $endCallTimeCheck) {
                    /* @var $q \Illuminate\Database\Eloquent\Builder */

                    $q->where(function ($q2) use ($startCallTimeCheck, $endCallTimeCheck) {
                        /* @var $q2 \Illuminate\Database\Eloquent\Builder */

                        $q2->where('start_time_call', '>', $startCallTimeCheck)->where('start_time_call', '<', $endCallTimeCheck);
                    });

                    $q->orWhere(function ($q2) use ($startCallTimeCheck, $endCallTimeCheck) {
                        /* @var $q2 \Illuminate\Database\Eloquent\Builder */

                        $q2->where('end_time_call', '>', $startCallTimeCheck)->where('end_time_call', '<=', $endCallTimeCheck);
                    });

                    $q->orWhere('start_time_call', $startCallTimeCheck)->orWhere('end_time_call', $endCallTimeCheck);

                    $q->orWhere(function ($q2) use ($startCallTimeCheck, $endCallTimeCheck) {
                        /* @var $q2 \Illuminate\Database\Eloquent\Builder */

                        $q2->whereRaw("'{$startCallTimeCheck}' > start_time_call")->whereRaw("'{$startCallTimeCheck}' < end_time_call");
                    });
                })
                ->first();

            if (! empty($isTalkTaken)) {
                return redirect()->route('admin.talks.index')->with('message', 'Already existing talk for requested time. Existing talk start time: ' . $isTalkTaken->start_time_call . ' - end time: ' . $isTalkTaken->end_time_call);
            }
        }

        $talk = Talk::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $talk->id]);
        }

        return redirect()->route('admin.talks.index');
    }

    public function edit(Talk $talk)
    {
        abort_if(Gate::denies('talk_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $supplier = $talk->supplier;
        $languages = Language::all()->pluck('english', 'id');
        $billing_addresses = $supplier->billings()->get([
            'id',
            'company_name as name',
            'street',
            'zipcode as zip',
            'city',
        ]);

        $talk->load('teacher_user', 'language', 'finance_currencies', 'billing_address');

        return view('admin.talks.edit', compact( 'languages', 'billing_addresses', 'talk'));
    }

    public function update(UpdateTalkRequest $request, Talk $talk)
    {
        $talk->update($request->validated());

        return redirect()->route('admin.talks.index');
    }

    public function show(Talk $talk)
    {
        abort_if(Gate::denies('talk_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $talk->load('teacher_user', 'language', 'finance_currencies', 'billing_address', 'talk_bookings');

        return view('admin.talks.show', compact('talk'));
    }

    public function userTalks(Request $request, $id)
    {
        if ($request->ajax()) {
            $query = Talk::with(['teacher_user', 'finance_currencies', 'billing_address', 'category', 'subcategory', 'talk_bookings.booking_payment_details'])->withCount('talk_bookings')->where('state', Talk::STATE['valid'])->where('teacher_user_id', $id)->get();

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '');

            $table->editColumn('actions', function ($row) {
                $editGate      = 'talk_edit';
                $crudRoutePart = 'talks';

                return view(
                    'partials.datatablesActionsEdit',
                    compact(
                        'editGate',
                        'crudRoutePart',
                        'row'
                    )
                );
            });


            $table->addColumn('talk_categories_english', function ($row) {
                if ($row->category) {
                    return $row->category ? $row->category->english : "";
                }

                return '';
            });


            $table->addColumn('talk_subcategories_english', function ($row) {
                if ($row->subcategory) {
                    return $row->subcategory->english ? $row->subcategory->english : "";
                }

                return '';
            });

            return $table->make(true);
        }
    }

    public function destroy(Talk $talk)
    {
        abort_if(Gate::denies('talk_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $talk->delete();

        return back();
    }

    public function massDestroy(MassDestroyTalkRequest $request)
    {
        Talk::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('talk_create') && Gate::denies('talk_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Talk();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
