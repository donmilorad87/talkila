<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use App\Models\User;
use Illuminate\Console\Command;

class ConvertEmailMessageToFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:convert {user?* :  The ID of the user/users. (optional) }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert Email message from string to a file.';

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
     */
    public function handle()
    {
        $userId = $this->argument('user');

        $users = User::query()
            ->withTrashed()
            ->when($userId, function ($query) use ($userId) {
                $query->whereIn('id', $userId);
            })
            ->get();

        foreach ($users as $user) {
            $emails = $user->receivedEmailHistory()->get();

            if ($emails->isNotEmpty()) {
                $this->line("Converting emails for user \"{$user->email}\".");
                $this->newLine();
                $this->withProgressBar($emails, function ($email) use ($user) {
                    if (! $email->is_html) {
                        $file = EmailHistoriesLogController::createHTMLFile($user, $email);

                        $email->update([
                            'message' => $file['name'],
                        ]);
                    }
                });
                $this->newLine(2);
            }
        }
    }
}
