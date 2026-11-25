<?php

namespace App\Http\Controllers\Affiliate;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Affiliates\AffiliateRevenuePerMonth;
use App\Models\Affiliates\AffiliatesRevenue;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = AffiliateRevenuePerMonth::query()->select(sprintf('%s.*', (new AffiliateRevenuePerMonth)->table));
            $table = Datatables::of($query);

            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $viewGate      = true;
                $editGate      = false;
                $deleteGate    = false;
                $crudRoutePart = 'reports';

                return view('affiliate.layout.partials.affiliateDatatableActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('date', function ($row) {
                return $row->date ? date('d.m.Y', strtotime($row->date)) : "";
            });
            $table->editColumn('month', function ($row) {
                return $row->month ? date('m Y', strtotime($row->month)) : "";
            });
            $table->editColumn('registrations', function ($row) {
                return $row->registrations;
            });
            $table->editColumn('revenue', function ($row) {
                return $row->revenue;
            });

            $table->rawColumns(['actions']);

            return $table->make(true);
        }
        return view('affiliate.reports.index', [
            'referral_link' => Helpers::createAffiliateReferralLink($request)
        ]);
    }

    public function show(Request $request, $id)
    {
        $selectedMonth = AffiliateRevenuePerMonth::query()
            ->select('month')
            ->where('id', $id)
            ->first();

        $registrations = User::query()
            ->selectRaw('COUNT(*) registrations, TO_CHAR(created_at, \'DD.MM.YYYY\') date, TO_CHAR(created_at, \'DD\') day')
            ->where('affiliates_sub_affiliate_id', $request->user()->affiliate->id)
            ->where('created_at','LIKE',Carbon::parse($selectedMonth->month)->format('Y-m').'%')
            ->groupBy('date')
            ->get()
            ->toArray()
        ;
        $registrationDates = [];

        foreach ($registrations as $registration) {
            $registrationDates[(int)$registration['day']] = $registration['registrations'];
        }

        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date('n', strtotime($selectedMonth->month)),date('Y', strtotime($selectedMonth->month)));
        $structure = [];

        for ($a = 0; $a<=$daysInMonth; $a++) {

            if(!empty($registrationDates[$a])) {
                $structure[$a] = $registrationDates[$a];
            } else {
                $structure[$a] = 0;
            }
        }

        if ($request->ajax()) {
            $query = AffiliateRevenuePerMonth::query()->where('id', $id)->with('affiliate_sub')->select(sprintf('%s.*', (new AffiliateRevenuePerMonth)->table));
            $table = Datatables::of($query);

            $table->editColumn('name', function ($row) {
                return $row->affiliate_sub ? $row->affiliate_sub->name : "";
            });
            $table->editColumn('stage_1', function ($row) {
                return $row->stage_1 ? $row->stage_1 : "";
            });
            $table->editColumn('stage_2', function ($row) {
                return $row->stage_2 ? $row->stage_2 : "";
            });
            $table->editColumn('stage_3', function ($row) {
                return $row->stage_3 ? $row->stage_3 : "";
            });
            $table->editColumn('revenue', function ($row) {
                return $row->revenue ? $row->revenue : "";
            });

            return $table->make(true);
        }
        return view('affiliate.reports.show', [
            'requestedId'               => $id,
            'referral_link'             => Helpers::createAffiliateReferralLink($request),
            'registrations'             => $registrations,
            'registrationData'          => array_values($structure),
            'registrationCategories'    => array_keys($structure),
        ]);
    }
}
