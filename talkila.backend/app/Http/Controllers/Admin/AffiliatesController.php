<?php

namespace App\Http\Controllers\Admin;

use App\Models\Affiliates\AffiliateRevenuePerMonth;
use App\Models\Affiliates\AffiliatesRevenue;
use App\Models\Payment;
use App\Models\Booking;
use App\ModelsApi\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AffiliatesController
{
    const STAGE_LIMITS = [
        'stage_1' => '500',
        'stage_2' => '1000',
        'stage_3' => '5000'
    ];

    const STAGE_EARNINGS = [
        'stage_1' => '50',
        'stage_2' => '50',
        'stage_3' => '200'
    ];

    public function assignRevenueToAffiliate(User $teacher, Booking $booking) {
        $dFromPayoutDate = date('Y-m-25 00:00:00', strtotime('-1 month'));
        $dToPayoutDate = date('Y-m-25 00:00:00');

        $affiliateRevenue = AffiliatesRevenue::query()
            ->where('user_id', $teacher->id)
            ->where('affiliates_sub_id', $teacher->affiliates_sub_id)
            ->where('affiliates_sub_affiliate_id', $teacher->affiliates_sub_affiliate_id)
            ->first();

        if(!isset($affiliateRevenue->id)) {
            $affiliateRevenue = new AffiliatesRevenue([
                'user_id'                       => $teacher->id,
                'affiliates_sub_id'             => $teacher->affiliates_sub_id,
                'affiliates_sub_affiliate_id'   => $teacher->affiliates_sub_affiliate_id,
                'revenue'                       => 0
            ]);
        }

        $affiliateRevenuePerMonth = AffiliateRevenuePerMonth::query()
            ->where('affiliates_sub_id', $teacher->affiliates_sub_id)
            ->where('date', Carbon::now())
            ->first();

        if(!isset($affiliateRevenuePerMonth->id)) {
            $registrations = User::query()
                ->where('affiliates_sub_id', $teacher->affiliates_sub_id)
                ->whereBetween('created_at', [$dToPayoutDate, $dFromPayoutDate])
                ->count()
            ;
            $affiliateRevenuePerMonth = new AffiliateRevenuePerMonth([
                'user_id'                       => $teacher->id,
                'affiliates_sub_id'             => $teacher->affiliates_sub_id,
                'affiliates_sub_affiliate_id'   => $teacher->affiliates_sub_affiliate_id,
                'date'                          => Carbon::now(),
                'paypal'                        => $teacher->userOfAffiliate()->paypal_address,
                'registrations'                 => $registrations
            ]);
        }

        $newRevenue = $affiliateRevenue->revenue + $booking->price;

        if($affiliateRevenue->revenue < self::STAGE_LIMITS['stage_1'] && $newRevenue >= self::STAGE_LIMITS['stage_1']) {
            $affiliateRevenue->stage_1          = self::STAGE_EARNINGS['stage_1'];
            $affiliateRevenue->stage_1_month    = Carbon::now();

            $affiliateRevenuePerMonth->stage_1 += self::STAGE_EARNINGS['stage_1'];
            $affiliateRevenuePerMonth->revenue += $booking->price;
        } else if($affiliateRevenue->revenue < self::STAGE_LIMITS['stage_2'] && $newRevenue >= self::STAGE_LIMITS['stage_2']) {
            $affiliateRevenue->stage_2          = self::STAGE_EARNINGS['stage_2'];
            $affiliateRevenue->stage_2_month    = Carbon::now();

            $affiliateRevenuePerMonth->stage_2 += self::STAGE_EARNINGS['stage_2'];
            $affiliateRevenuePerMonth->revenue += $booking->price;
        } else if($affiliateRevenue->revenue < self::STAGE_LIMITS['stage_3'] && $newRevenue >= self::STAGE_LIMITS['stage_3']) {
            $affiliateRevenue->stage_3          = self::STAGE_EARNINGS['stage_3'];
            $affiliateRevenue->stage_3_month    = Carbon::now();

            $affiliateRevenuePerMonth->stage_3 += self::STAGE_EARNINGS['stage_3'];
            $affiliateRevenuePerMonth->revenue += $booking->price;
        }

        $affiliateRevenue->revenue = $newRevenue;
        $affiliateRevenue->save();

        $affiliateRevenuePerMonth->save();
    }
}
