<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\V1\Admin\CalendarController;
use App\Models\CalendarAccount;
use Illuminate\Console\Command;

class FetchCalendarEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendars:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Events for all unsynchronized Calendars.';

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
            ->where('is_synchronized', false)
            ->with('calendars', 'calendars.user')
            ->get();

        // Loop through all Calendar Accounts
        foreach ($calendar_accounts as $calendar_account) {
            $calendars = $calendar_account->calendars;

            // Loop through each calendar.
            foreach ($calendars as $calendar) {
                // Get Calendar Events
                $this->calendar->events(request(), $calendar->user, $calendar);
            }

            $calendar_account->update([
                'is_synchronized' => true,
            ]);
        }
    }
}
