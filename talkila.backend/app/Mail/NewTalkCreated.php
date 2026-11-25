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
class NewTalkCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $language;
    public $email_mentor;
    public $talk_id;
    public $course_name;
    public $talk_description;
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
    public function __construct($language, $email_mentor, $talk_id, $course_name, $talk_description, $talk_price, $talk_duration, $talk_type, $talk_anonymous, $talk_language)
    {
        $this->language         = $language;
        $this->email_mentor     = $email_mentor;
        $this->talk_id          = $talk_id;
        $this->course_name      = $course_name;
        $this->talk_description = $talk_description;
        $this->talk_price       = $talk_price;
        $this->talk_duration    = $talk_duration;
        $this->talk_type        = $talk_type;
        $this->talk_anonymous   = $talk_anonymous;
        $this->talk_language    = $talk_language;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'mail@talkila.com';
        $subject = __('NEW_TALK_CREATED_SUBJECT', ['talk' => $this->course_name]);

        $name = 'Talkila';

        $talkUrl = config('app.frontend_url') . '/?talk_created=' . $this->talk_id;

        $message = $this->getMessage($talkUrl);

        EmailHistoriesLogController::createHistoryEmailLog($this->email_mentor, $subject, $message);

        return $this->markdown('emails.new_talk_created')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'course_name'      => $this->course_name,
                'talk_description' => $this->talk_description,
                'talk_price'       => $this->talk_price,
                'talk_duration'    => $this->talk_duration,
                'talk_type'        => $this->talk_type,
                'talk_anonymous'   => $this->talk_anonymous,
                'talk_language'    => $this->talk_language,
                'talkUrl'          => $talkUrl,
            ]);
    }

    public function getMessage($talkUrl = null)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html     = $markdown->render('emails.new_talk_created', [
            'course_name'      => $this->course_name,
            'talk_description' => $this->talk_description,
            'talk_price'       => $this->talk_price,
            'talk_duration'    => $this->talk_duration,
            'talk_type'        => $this->talk_type,
            'talk_anonymous'   => $this->talk_anonymous,
            'talk_language'    => $this->talk_language,
            'talkUrl'          => $talkUrl,
        ]);

        return $html;
    }
}
