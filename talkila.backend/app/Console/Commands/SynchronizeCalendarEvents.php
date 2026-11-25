<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\V1\Admin\CalendarController;
use App\Models\CalendarAccount;
use Illuminate\Console\Command;

class SynchronizeCalendarEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendars:sync {calendar?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Events for all synchronized Calendars.';

    protected $calendar;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->calendar = new CalendarController();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $calendar_accounts = CalendarAccount::query()
            ->where('is_synchronized', true)
            ->with('calendars', 'calendars.user')
            ->get();

        request()->merge([
            'start_time' => now()->addMonths(2),
            'end_time'   => now()->addMonths(2)->addDay(),
        ]);

        // Loop through all Calendar Accounts
        foreach ($calendar_accounts as $calendar_account) {
            // Loop through each calendar.
            foreach ($calendar_account->calendars as $calendar) {
                // Get Calendar Events
                $this->calendar->events(request(), $calendar->user, $calendar);
            }
        }
    }
}
