<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\StaticMetric::class,
        Commands\CheckInactiveUsers::class,
        Commands\CheckNotVerifiedAccounts::class,
        Commands\CheckTalkStartTimeOneMinute::class,
        Commands\CheckTalkStartTimeTenMinutes::class,
        Commands\SynchronizeCalendarEvents::class,
        // Twilio commands (merged from twiliobackend)
        Commands\NotifyCallDuration::class,
        Commands\StartNewRooms::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('static:metric')
            ->dailyAt('00:05');

        $schedule->command('update:users_inactive')
            ->dailyAt('00:15');

        $schedule->command('remove:not_verified_users')
            ->everyThirtyMinutes();

        $schedule->command('check_talk_start_time_one_minute')
            ->everyMinute();

        $schedule->command('check_talk_start_time_ten_minutes')
            ->everyMinute();

        $schedule->command('calendar:fetch')
            ->everyMinute();

        $schedule->command('calendar:sync')
            ->dailyAt('00:00');

        // Twilio scheduled commands (merged from twiliobackend)
        $schedule->command('notify:duration')->everyMinute();
        $schedule->command('start:newroom')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
