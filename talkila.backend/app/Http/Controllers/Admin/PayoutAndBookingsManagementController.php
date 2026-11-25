<?php


namespace App\Http\Controllers\Admin;


use App\Exceptions\Handler;
use App\Models\Booking;
use App\Models\BookingsPayout;
use App\Models\Payment;
use App\Models\Payout;
use App\Models\WalletHistory;
use App\ModelsApi\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PayoutAndBookingsManagementController
{
    const TALKILA_COMMISSION = 0.80;

    public function processCompletedBookings()
    {
        try {
            DB::beginTransaction();

            $dTodayDate   = date('Y-m-d 00:00:00');
            $dCaptureDate = date('Y-m-d H:i:00', strtotime("-2 days"));

            $oBookings = Booking::query()
                ->select('id', 'price', 'start_call', 'state')
                ->whereIn('state', [Booking::STATE['paid'], Booking::STATE['captured']])
                ->where('start_call', '<', $dTodayDate)
                ->with('talksFeedback:id,stars_content');


            $oBookings->chunk(50, function ($batch) use ($dCaptureDate) {
                /**
                 * @var $oBookingItem \App\Models\Booking
                 */

                foreach ($batch as $oBookingItem) {
                    if (isset($oBookingItem->talksFeedback->stars_content) &&
                        $oBookingItem->talksFeedback->stars_content < 2 &&
                        $oBookingItem->booking_type != Booking::BOOKING_TYPE['extended_call'] &&
                        $oBookingItem->booking_type != Booking::BOOKING_TYPE['extension'] &&
                        ($oBookingItem->state == Booking::STATE['paid'] || $oBookingItem->state == Booking::STATE['captured'])
                    ) {
                        BookingsController::createBookingProtocolEvent($oBookingItem->id, Booking::STATE['review']);

                        $oBookingItem->state = Booking::STATE['review'];
                        $oBookingItem->save();
                    } else {
                        if ($oBookingItem->start_call < $dCaptureDate && $oBookingItem->state == Booking::STATE['paid']) {
                            BookingsController::createBookingProtocolEvent($oBookingItem->id, Booking::STATE['completed']);

                            $oBookingItem->state = Booking::STATE['completed'];
                            $oBookingItem->save();
                        }
                    }
                }
            });

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_1001, self::class, __FUNCTION__);
        }
    }

    public function processPayoutPerMonth()
    {
        try {
            DB::beginTransaction();

            $dFromPayoutDate = date('Y-m-25 00:00:00', strtotime('-1 month'));
            $dToPayoutDate   = date('Y-m-25 00:00:00');

            $oBookings = Booking::query()
                ->select("bookings.id", "talk_id", "teacher_user_id", "currency", "state", "price", "vat_id", "vat")
                ->where(function ($q) use ($dToPayoutDate, $dFromPayoutDate) {
                    /* @var $q \Illuminate\Database\Eloquent\Builder */

                    $q->where(function ($q2) use ($dToPayoutDate) {
                        /* @var $q2 \Illuminate\Database\Eloquent\Builder */
                        $q2->whereNull('payout_id');

                        $q2->where('state', '!=', Booking::STATE['review']);

                        // TODO Change start_call with Payed Date here so we know on what month to put this invoice
                        $q2->where('start_call', '<', $dToPayoutDate);
                    });
                })
                ->orderBy('teacher_user_id');

            $teacherUserId = 0;
            $teachersWithPayouts = [];
            $oPayout       = [];
            $bookingsForUpdate = [];

            $batch = $oBookings->limit(50)->get();
            while(count($batch) > 0) {
                /**
                 * @var $oBookingItem \App\Models\Booking
                 */

                foreach ($batch as $oBookingItem) {
                    if ($teacherUserId != $oBookingItem->teacher_user_id) {
                        // Commented out doing payout in wallet
                        /*if (isset($oPayout->price) && $oPayout->price > 0 && isset($teacherUser->wallet_balance)) {
                            $wallethistory             = new WalletHistory();
                            $responseFromWalletHistory = $wallethistory->addFundsInWallet($teacherUser, $oPayout->price, WalletHistory::TYPE['CREDIT'], 0, $dToPayoutDate, null, WalletHistory::STATUS['COMPLETED'], WalletHistory::SOURCE['PAYOUT']);
                        }*/

                        $uuid = (string)Str::uuid();

                        $oPayout = new Payout();

                        $oPayout->user_id               = $oBookingItem->teacher_user_id;
                        $oPayout->finance_currencies_id = $oBookingItem->currency;
                        $oPayout->payout_date           = $dToPayoutDate;
                        $oPayout->price                 = 0;
                        $oPayout->sales_tax             = [];
                        $oPayout->reference             = $uuid;
                        $oPayout->save();

                        $teacherUserId = $oBookingItem->teacher_user_id;
                    }

                    $teachersWithPayouts[$oBookingItem->teacher_user_id] = $oBookingItem->teacher_user_id;

                    $oBookingPayouts = new BookingsPayout();

                    $oBookingPayouts->payouts_id  = $oPayout->id;
                    $oBookingPayouts->bookings_id = $oBookingItem->id;

                    if(in_array($oBookingItem->state, [Booking::STATE['completed'], Booking::STATE['canceled_without_refund']])) {
                        $billingAddressVat = $oBookingItem->vat;
                        $billingAddressVatId = (int)$oBookingItem->vat_id;
                        $gross2 = $oBookingItem->price * self::TALKILA_COMMISSION;

                        $oPayout->price += $gross2;

                        $vatNew = $gross2 - ($gross2 / (1 + ($billingAddressVat / 100)));


                        $salesTax = $oPayout->sales_tax;
                        $vatOld = $salesTax[$billingAddressVatId]["" . $billingAddressVat . ""]['tax'] ?? 0;

                        $salesTax[$billingAddressVatId]["" . $billingAddressVat . ""]['tax'] = $vatOld + $vatNew;
                        $salesTax[$billingAddressVatId][$billingAddressVat]['bookings'] = ($salesTax[$billingAddressVatId][$billingAddressVat]['bookings'] ?? 0) + 1;
                        $salesTax[$billingAddressVatId][$billingAddressVat]['revenue'] = ($salesTax[$billingAddressVatId][$billingAddressVat]['revenue'] ?? 0) + $oBookingItem->price;
                        $salesTax[$billingAddressVatId][$billingAddressVat]['payout'] = ($salesTax[$billingAddressVatId][$billingAddressVat]['payout'] ?? 0) + $gross2;
                        $salesTax[$billingAddressVatId][$billingAddressVat]['net'] = ($salesTax[$billingAddressVatId][$billingAddressVat]['net'] ?? 0) + ($gross2 - $vatNew);
                        $oPayout->sales_tax = $salesTax;

                        $talkilaRevenue = $oBookingItem->price - $gross2;

                        $oPayout->talkila_revenue += $talkilaRevenue;

                        $talkilaVatNew = $talkilaRevenue - ($talkilaRevenue / (1 + ($billingAddressVat / 100)));

                        $talkilaSalesTax = $oPayout->talkila_sales_tax;
                        $talkilaVatOld = $talkilaSalesTax[$billingAddressVatId]["" . $billingAddressVat . ""]['tax'] ?? 0;
                        $talkilaSalesTax[$billingAddressVatId]["" . $billingAddressVat . ""]['tax'] = $talkilaVatOld + $talkilaVatNew;
                        $talkilaSalesTax[$billingAddressVatId][$billingAddressVat]['bookings'] = ($talkilaSalesTax[$billingAddressVatId][$billingAddressVat]['bookings'] ?? 0) + 1;
                        $talkilaSalesTax[$billingAddressVatId][$billingAddressVat]['revenue'] = ($talkilaSalesTax[$billingAddressVatId][$billingAddressVat]['revenue'] ?? 0) + $oBookingItem->price;
                        $talkilaSalesTax[$billingAddressVatId][$billingAddressVat]['payout'] = ($talkilaSalesTax[$billingAddressVatId][$billingAddressVat]['payout'] ?? 0) + $talkilaRevenue;
                        $talkilaSalesTax[$billingAddressVatId][$billingAddressVat]['net'] = ($talkilaSalesTax[$billingAddressVatId][$billingAddressVat]['net'] ?? 0) + ($talkilaRevenue - $talkilaVatNew);

                        $oPayout->talkila_sales_tax = $talkilaSalesTax;
                        $oPayout->save();
                    }

                    BookingsController::createBookingProtocolEvent($oBookingItem->id, Booking::STATE['payout']);

//                    $oBookingItem->state     = Booking::STATE['payout'];
                    $bookingsForUpdate[$oBookingItem->id] = $oPayout->id;
                    $oBookingItem->payout_id     = $oPayout->id;
                    $oBookingItem->save();

                    // TODO: Talk with Jure About this case:
                    //  Solution 1: In admin panel report
                    // Solution 2: Talkila takes all revenue and VAT
//                    $teacherUser = User::query()->find($oBookingItem->teacher_user_id);

//                    if($oBookingItem->state == Booking::STATE['completed']) {
//                        if(!empty($teacherUser->affiliates_sub_id) && !$teacherUser->affiliate_revenue_limit_reached && isset($teacherUser->wallet_balance)) {
//                            dd($teacherUser);
//                            $affiliatesController = New AffiliatesController();
//                            $affiliatesController->assignRevenueToAffiliate($teacherUser, $oBookingItem);
//                        }
//                    }
                    $oBookingPayouts->save();

                    unset($oBookingPayouts);
                }

                // Commented out doing payout in wallet
                /*if (isset($oPayout->price) && $oPayout->price > 0 && isset($teacherUser->wallet_balance)) {
                    $wallethistory             = new WalletHistory();
                    $responseFromWalletHistory = $wallethistory->addFundsInWallet($teacherUser, $oPayout->price, WalletHistory::TYPE['CREDIT'], null, $dToPayoutDate, null, WalletHistory::STATUS['COMPLETED'], WalletHistory::SOURCE['PAYOUT']);
                }*/
                $batch = $oBookings->limit(50)->get();
            };

            // Get all teachers that don't have any bookings
            $teachers_without_payouts = User::where('type', User::TYPE['supplier'])->whereNotIn('id', $teachersWithPayouts)->get();

            // Add an empty entry for all teachers that do not have any bookings.
            foreach ($teachers_without_payouts as $teacher) {
                $teacher->payouts()->create([
                    'finance_currencies_id' => 1,
                    'payout_date'           => $dToPayoutDate,
                    'price'                 => 0,
                    'talkila_revenue'       => 0,
                    'reference'             => (string)Str::uuid(),
                ]);
            };

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::notice(self::class . '::' . __FUNCTION__ . ' (ERROR)::');

            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_1002, self::class, __FUNCTION__);
        }
    }
}
