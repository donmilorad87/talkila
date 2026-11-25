<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Country;
use Illuminate\Database\Seeder;

class BookingClientBillingAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookings = Booking::query()
            ->with('participant_user', function ($query) {
                $query->withTrashed()->get();
            })
            ->get();

        foreach ($bookings as $booking) {
            $booking->update([
                'vat_id'                    => $booking->participant_user->billing ? $booking->participant_user->billing->countries_id : Country::GERMANY,
                'vat'                       => $booking->participant_user->billing ? $booking->participant_user->billing->countries->vat_value : 19,
                'client_billing_address_id' => $booking->participant_user->billing_address_id,
            ]);
        }
    }
}
