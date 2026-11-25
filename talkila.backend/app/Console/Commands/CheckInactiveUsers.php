<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\UsersController;
use Illuminate\Console\Command;

class CheckInactiveUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:users_inactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all inactive users in last 7 days and remove username from their profile. Also remove Step with username from JTC process';

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
     * @return mixed
     */
    public function handle()
    {
        $updateUsers = new UsersController();
        $updateUsers->checkAndUpdateInactiveUsers();
    }
}
