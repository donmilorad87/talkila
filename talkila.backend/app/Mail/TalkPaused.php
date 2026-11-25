<?php

namespace App\Mail;

use App\Http\Controllers\Admin\EmailHistoriesLogController;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Markdown;
use Illuminate\Queue\SerializesModels;

/**
 * Class BookingCancellationClient
 * @package App\Mail
 */
class TalkPaused extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $language;
    public $email_mentor;
    public $course_id;
    public $course_name;
    public $talk_price;
    public $talk_duration;
    public $talk_type;
    public $talk_anonymous;
    public $talk_language;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($language, $email_mentor, $course_id, $course_name, $talk_price, $talk_duration, $talk_type, $talk_anonymous, $talk_language)
    {
        $this->language       = $language;
        $this->email_mentor   = $email_mentor;
        $this->course_id      = $course_id;
        $this->course_name    = $course_name;
        $this->talk_price     = $talk_price;
        $this->talk_duration  = $talk_duration;
        $this->talk_type      = $talk_type;
        $this->talk_anonymous = $talk_anonymous;
        $this->talk_language  = $talk_language;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'mail@talkila.com';
        $subject = __('TALK_PAUSED_SUBJECT', ['talk_name' => $this->course_name]);

        $name = 'Talkila';

        $courseUrl = config('app.frontend_url') . '/?talk_paused=' . $this->course_id;
        // $talkUrl    = config('app.frontend_url').'/booking-summary/'. $this->course_id ;
        $talkUrl = config('app.frontend_url') . '/?talk_paused=' . $this->course_id;
        $message = $this->getMessage($talkUrl, $courseUrl);

        EmailHistoriesLogController::createHistoryEmailLog($this->email_mentor, $subject, $message);

        return $this->markdown('emails.talk_paused')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'course_name'    => $this->course_name,
                'talk_price'     => $this->talk_price,
                'talk_duration'  => $this->talk_duration,
                'talk_type'      => $this->talk_type,
                'talk_anonymous' => $this->talk_anonymous,
                'talk_language'  => $this->talk_language,
                'talkUrl'        => $talkUrl,
                'courseUrl'      => $courseUrl,
            ]);
    }

    public function getMessage($talkUrl = null, $courseUrl = null)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html     = $markdown->render('emails.talk_paused', [
            'course_name'    => $this->course_name,
            'talk_price'     => $this->talk_price,
            'talk_duration'  => $this->talk_duration,
            'talk_type'      => $this->talk_type,
            'talk_anonymous' => $this->talk_anonymous,
            'talk_language'  => $this->talk_language,
            'talkUrl'        => $talkUrl,
            'courseUrl'      => $courseUrl,
        ]);

        return $html;
    }
}
