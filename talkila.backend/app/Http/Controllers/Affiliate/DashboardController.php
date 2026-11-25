<?php

namespace App\Http\Controllers\Affiliate;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Affiliates\Affiliate;
use App\Models\Affiliates\Subaffiliate;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Subaffiliate::query()
                ->where('affiliate_id', $request->user()->affiliate->id)
                ->where('state', Subaffiliate::STATE['active'])
                ->select(sprintf('%s.*', (new Subaffiliate)->table));

            $table = Datatables::of($query);

            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $viewGate      = false;
                $editGate      = false;
                $deleteGate    = true;
                $crudRoutePart = 'subaffiliate';

                return view('affiliate.layout.partials.affiliateDatatableActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });


            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : "";
            });
            $table->editColumn('registration', function ($row) {
                return $row->users->count();
            });
            $table->editColumn('revenue', function ($row) {
                return $row->users->sum('stage_1') + $row->affiliate_revenue->sum('stage_2') + $row->affiliate_revenue->sum('stage_3');
            });

            $table->editColumn('affiliate_id', function ($row) {
                return $row->tracking_id;
            });

            $table->rawColumns(['actions']);

            return $table->make(true);
        }

        return view('affiliate.home', [
            'referral_link' => Helpers::createAffiliateReferralLink($request)
        ]);
    }

    public function payout(Request $request)
    {
        return view('affiliate.payout', [
            'referral_link' => Helpers::createAffiliateReferralLink($request)
        ]);
    }

}
