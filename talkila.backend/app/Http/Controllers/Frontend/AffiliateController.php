<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Api\V1\Admin\TalksApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/* use App\Http\Controllers\Api\V1\Admin\ProfileVerificationApiController; */


class AffiliateController extends Controller
{

    public function index(Request $request)
    {


        $affiliateUserId = 3; //this is id of affilaite user,

        $request->request->add(['talk_type' => 1]);
        $userPrivateTalksObject = new TalksApiController();
        $userPrivateTalks = $userPrivateTalksObject->teacherTalks($request, $affiliateUserId)->getData(true);

        return view('frontend.pages.affiliate_discount', [
            'page_name'         => trans('Affiliate Discount') ?? 'Affiliate Discount',
            'userPrivateTalks'  => $userPrivateTalks['data'] ?? []
        ]);

    }
}
