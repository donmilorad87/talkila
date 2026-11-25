<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Seeder;

class BookingVATSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookings = Booking::all();

        foreach ($bookings as $booking) {
            $booking->update([
                'vat' => $booking->vat->vat_value,
            ]);
        }
    }
}
