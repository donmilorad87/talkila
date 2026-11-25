<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

class FeedbackNew extends Mailable
{
    use Queueable, SerializesModels;

    public $language;
    public $email_mentor;
    public $user_id;
    public $stars_content;
    public $description;
    public $courseId;
    public $courseName;
    public $feedbackUserName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($language, $email_mentor, $user_id, $stars_content, $description , $courseId, $courseName, $feedbackUserName)
    {
        $this->language             = $language;
        $this->email_mentor         = $email_mentor;
        $this->user_id              = $user_id;
        $this->stars_content        = $stars_content;
        $this->description          = $description;
        $this->courseId             = $courseId;
        $this->courseName           = $courseName;
        $this->feedbackUserName     = $feedbackUserName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address    = 'mail@talkila.com';
        $subject    = __('FEEDBACK_NEW_SUBJECT', ['talk' => $this->courseName]);
        $name       = 'Talkila';
        $userUrl    = env('APP_FRONTEND_URL').'/'. $this->feedbackUserName;
        $courseUrl  = env('APP_FRONTEND_URL').'/booking-summary/'. $this->courseId ;
        $message    = $this->getMessage($userUrl, $courseUrl);

        EmailHistoriesLogController::createHistoryEmailLog($this->email_mentor, $subject, $message);

        return $this->markdown('emails.feedback_new')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'stars_content'     => $this->stars_content,
                'userUrl'           => $userUrl,
                'courseUrl'         => $courseUrl,
                'course_name'       => $this->courseName,
                'description'       => $this->description,
                'feedbackUserName'  => $this->feedbackUserName,
            ]);
    }

    public function getMessage($userUrl = null, $courseUrl = null)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html = $markdown->render('emails.feedback_new', [
            'stars_content'     => $this->stars_content,
            'userUrl'           => $userUrl,
            'courseUrl'         => $courseUrl,
            'course_name'       => $this->courseName,
            'description'       => $this->description,
            'feedbackUserName'  => $this->feedbackUserName,
        ]);

        return $html;
    }
}
