<?php

namespace App\Console\Commands;

use App\Models\EmailHistoriesLog;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RemoveEmailFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:remove {user?* :  The ID of the user/users. (optional) }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove Email files from the server.';

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
                $this->line("Removing email files for user \"{$user->email}\".");
                $this->newLine();
                $this->withProgressBar($emails, function ($email) use ($user) {
                    if ($email->is_html) {
                        $file = $this->getFile($user, $email);

                        $email->update([
                            'message' => File::get($file['path']),
                        ]);

                        File::delete($file['path']);

                        $fileCount = count(File::allFiles($file['directory']));

                        if ($fileCount === 0) {
                            File::deleteDirectory($file['directory']);
                        }
                    }
                });
                $this->newLine(2);
            }
        }
    }

    /**
     * Retrieve User Email path.
     *
     * @param  User               $user   User that the email was sent to.
     * @param  EmailHistoriesLog  $email  Email History Model.
     *
     * @return array{path:string, directory:string, name:string}
     */
    function getFile(User $user, EmailHistoriesLog $email): array
    {
        $name      = basename($email->message);
        $directory = storage_path("mails/$user->id");
        $path      = "$directory/$name";

        return [
            'directory' => $directory,
            'name'      => basename($path),
            'path'      => $path,
        ];
    }
}
