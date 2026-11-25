<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\PayoutAndBookingsManagementController;
use Illuminate\Console\Command;

class CompleteBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'complete:bookings';

    /**
     * The console command description.
     * IMPORTANT: NEED TO RUN EVERY DAY AT 00:10
     * @var string
     */
    protected $description = 'Bookings State Management';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $static_matric = new PayoutAndBookingsManagementController();
        $static_matric->processCompletedBookings();
    }
}
