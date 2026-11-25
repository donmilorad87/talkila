<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\PayoutAndBookingsManagementController;
use Illuminate\Console\Command;

class PayoutProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payout:process';

    /**
     * The console command description.
     * IMPORTANT: NEED TO RUN AT 27 day of every month
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
        $static_matric->processPayoutPerMonth();
    }
}
