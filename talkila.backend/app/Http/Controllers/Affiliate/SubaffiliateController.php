<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\Affiliates\AffiliatesRevenue;
use App\Models\Affiliates\Subaffiliate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class SubaffiliateController extends Controller
{

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

                Subaffiliate::query()->where('id', $id)->update(['state'=>0]);
                Subaffiliate::query()->find($id)->delete();

                Session::flash('alert-success', 'The selected employee was successfully deleted.');

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();

                Session::flash('alert-danger', 'Something went wrong, the employee was not deleted.');
        }

        return redirect()->route('affiliate.home');
    }

    public function createEmployee()
    {
        return view('affiliate.create_employee');
    }

    public function storeEmployee(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        // Create a Subaffiliate
        Subaffiliate::create([
            'affiliate_id' => $request->user()->affiliate->id,
            'tracking_id' => uniqid(),
            'name'  => $request->input('name'),
            'email' => $request->input('email'),
            'state' => 1
        ]);

        return redirect('affiliate.home');
    }
}
