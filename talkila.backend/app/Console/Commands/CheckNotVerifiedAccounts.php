<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\UsersController;
use Illuminate\Console\Command;

class CheckNotVerifiedAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:not_verified_users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if user verified, if not verified 24 hours from creation, delete that user.';

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
        $updateUsers->checkNotVerifiedUsers();
    }
}
