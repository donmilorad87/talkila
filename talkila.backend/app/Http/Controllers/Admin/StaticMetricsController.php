<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyStaticMetricRequest;
use App\Http\Requests\StoreStaticMetricRequest;
use App\Http\Requests\UpdateStaticMetricRequest;
use App\Models\StaticMetric;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class StaticMetricsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('static_metric_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = StaticMetric::with(['user'])->select(sprintf('%s.*', (new StaticMetric)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'static_metric_show';
                $editGate      = 'static_metric_edit';
                $deleteGate    = 'static_metric_delete';
                $crudRoutePart = 'static-metrics';

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
                return $row->id ? $row->id : "";
            });
            $table->addColumn('user_email', function ($row) {
                return $row->user ? $row->user->email : '';
            });

            $table->editColumn('follower', function ($row) {
                return $row->follower ? $row->follower : "";
            });
            $table->editColumn('reviews', function ($row) {
                return $row->reviews ? $row->reviews : "";
            });
            $table->editColumn('talks', function ($row) {
                return $row->talks ? $row->talks : "";
            });
            $table->editColumn('revenue', function ($row) {
                return $row->revenue ? $row->revenue : "";
            });
            $table->editColumn('bad_reports', function ($row) {
                return $row->bad_reports ? $row->bad_reports : "";
            });
            $table->editColumn('send_emails', function ($row) {
                return $row->send_emails ? $row->send_emails : "";
            });
            $table->editColumn('searches_per_day', function ($row) {
                return $row->searches_per_day ? $row->searches_per_day : "";
            });
            $table->editColumn('visited_user_profils_per_day', function ($row) {
                return $row->visited_user_profils_per_day ? $row->visited_user_profils_per_day : "";
            });
            $table->editColumn('dont_show_again', function ($row) {
                return $row->dont_show_again ? $row->dont_show_again : "";
            });
            $table->editColumn('visited', function ($row) {
                return $row->visited ? $row->visited : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'user']);

            return $table->make(true);
        }

        $users = User::get()->pluck('email')->toArray();

        return view('admin.staticMetrics.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('static_metric_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.staticMetrics.create', compact('users'));
    }

    public function store(StoreStaticMetricRequest $request)
    {
        $staticMetric = StaticMetric::create($request->all());

        return redirect()->route('admin.static-metrics.index');
    }

    public function edit(StaticMetric $staticMetric)
    {
        abort_if(Gate::denies('static_metric_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $staticMetric->load('user');

        return view('admin.staticMetrics.edit', compact('users', 'staticMetric'));
    }

    public function update(UpdateStaticMetricRequest $request, StaticMetric $staticMetric)
    {
        $staticMetric->update($request->all());

        return redirect()->route('admin.static-metrics.index');
    }

    public function show(StaticMetric $staticMetric)
    {
        abort_if(Gate::denies('static_metric_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $staticMetric->load('user');

        return view('admin.staticMetrics.show', compact('staticMetric'));
    }

    public function destroy(StaticMetric $staticMetric)
    {
        abort_if(Gate::denies('static_metric_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $staticMetric->delete();

        return back();
    }

    public function massDestroy(MassDestroyStaticMetricRequest $request)
    {
        StaticMetric::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function dailyUpdate()
    {
        $query = User::select('id')->withCount('userUserFolloweds', 'userUserReporteds', 'userUserVisiteds', 'userEmailHistories', 'userUserDontShowAgains')->limit(10)->get();

        $users = StaticMetric::limit(10)->get()->pluck('user_id')->toArray();

        foreach ($query as $q) {
            if (in_array($q->id, $users)) {
                StaticMetric::where('user_id', $q->id)->update([
                    // 'follower' => $q->user_user_followeds_count,
                    'my_follows'                    => $q->user_user_followeds_count,
                    // 'reviews' => 0,
                    'talks'                         => 0,
                    'revenue'                       => 0,
                    // 'bad_reports' => $q->user_user_reporteds_count,
                    'my_reports'                    => $q->user_user_reporteds_count,
                    'send_emails'                   => $q->user_email_histories_count,
                    'searches_per_day'              => 0,
                    'visited_user_profiles_per_day' => 0,
                    // 'dont_show_again' => $q->user_user_dont_show_agains_count,
                    'my_dont_show_again'            => $q->user_user_dont_show_agains_count,
                    'visited'                       => $q->user_user_visiteds_count,
                ]);
            } else {
                StaticMetric::create([
                    // 'follower' => $q->user_user_followeds_count,
                    'my_follows'                    => $q->user_user_followeds_count,
                    // 'reviews' => 0,
                    'talks'                         => 0,
                    'revenue'                       => 0,
                    // 'bad_reports' => $q->user_user_reporteds_count,
                    'my_reports'                    => $q->user_user_reporteds_count,
                    'send_emails'                   => $q->user_email_histories_count,
                    'searches_per_day'              => 0,
                    'visited_user_profiles_per_day' => 0,
                    // 'dont_show_again' => $q->user_user_dont_show_agains_count,
                    'my_dont_show_again'            => $q->user_user_dont_show_agains_count,
                    'visited'                       => $q->user_user_visiteds_count,
                    'user_id'                       => $q->id,
                ]);
            }
        }

        return true;
    }
}
