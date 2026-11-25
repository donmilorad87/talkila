<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailHistoriesLog;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EmailHistoriesLogController extends Controller
{
    public function showUserEmails(Request $request, $id)
    {
        abort_if(Gate::denies('email_history_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $user  = User::query()->find($id);
            $query = EmailHistoriesLog::with('receiver')->where('to_user', $user->email)->get();

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '');

            return $table->make(true);
        }
    }

    public static function createHistoryEmailLog($receiverEmail, $subject, $message)
    {
        $emailHistoriesLog              = new EmailHistoriesLog();
        $emailHistoriesLog->from_user   = "mail@talkila.com";
        $emailHistoriesLog->to_user     = $receiverEmail;
        $emailHistoriesLog->subject     = $subject;
        $emailHistoriesLog->message     = $message;
        $emailHistoriesLog->template_id = "";
        $emailHistoriesLog->save();
        $user = User::query()
            ->where('email', $receiverEmail)
            ->first();
        $file = self::createHTMLFile($user, $emailHistoriesLog);

        $emailHistoriesLog->update([
            'message' => $file['name'],
        ]);
    }

    /**
     * Create an HTML file from email message.
     *
     * @param  User               $user   User that the email was sent to.
     * @param  EmailHistoriesLog  $email  Email History Model.
     *
     * @return array{path:string, directory:string, name:string}
     */
    public static function createHTMLFile(User $user, EmailHistoriesLog $email): array
    {
        $directory = storage_path("mails/$user->id");
        $name      = Str::slug("$email->id $email->subject");
        $path      = "$directory/$name.html";

        if (!File::isDirectory($path)) {
            File::makeDirectory($directory, 0777, true, true);
        }

        File::put($path, $email->message);

        return [
            'directory' => $directory,
            'name'      => basename($path),
            'path'      => $path,
        ];
    }
}
