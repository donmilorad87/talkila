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
class ProfileVerified extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $email_mentor;
    public $talk_price;
    public $talk_anonym_call;
    public $talk_call_type;
    public $talk_teacher_name;
    public $talk_language_name;
    public $talk_subcategory_name;
    public $talk_category_name;
    public $talk_headline;
    public $talk_teacher_username;
    public $teacher_profile_picture;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email_mentor, $talk_price, $talk_anonym_call, $talk_call_type, $talk_teacher_name, $talk_language_name, $talk_subcategory_name, $talk_category_name, $talk_headline, $talk_teacher_username, $teacher_profile_picture)
    {
        $this->email_mentor            = $email_mentor;
        $this->talk_price              = $talk_price;
        $this->talk_anonym_call        = $talk_anonym_call;
        $this->talk_call_type          = $talk_call_type;
        $this->talk_teacher_name       = $talk_teacher_name;
        $this->talk_language_name      = $talk_language_name;
        $this->talk_subcategory_name   = $talk_subcategory_name;
        $this->talk_category_name      = $talk_category_name;
        $this->talk_headline           = $talk_headline;
        $this->talk_teacher_username   = $talk_teacher_username;
        $this->teacher_profile_picture = $teacher_profile_picture;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'mail@talkila.com';
        $subject = __('PROFILE_VERIFIED_SUBJECT');

        $name = 'Talkila';

        $talksUrl = config('app.frontend_url') . '/';

        $message = $this->getMessage($talksUrl);

        EmailHistoriesLogController::createHistoryEmailLog($this->email_mentor, $subject, $message);

        return $this->markdown('emails.profile_verified')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'talksUrl'                => $talksUrl,
                'talk_price'              => $this->talk_price,
                'talk_anonym_call'        => $this->talk_anonym_call,
                'talk_call_type'          => $this->talk_call_type,
                'talk_teacher_name'       => $this->talk_teacher_name,
                'talk_language_name'      => $this->talk_language_name,
                'talk_subcategory_name'   => $this->talk_subcategory_name,
                'talk_category_name'      => $this->talk_category_name,
                'talk_headline'           => $this->talk_headline,
                'talk_teacher_username'   => $this->talk_teacher_username,
                'teacher_profile_picture' => $this->teacher_profile_picture,
            ]);
    }

    public function getMessage($talksUrl = null)
    {
        $markdown = Container::getInstance()->make(Markdown::class);
        $html     = $markdown->render('emails.profile_verified', [
            'talksUrl'                => $talksUrl,
            'talk_price'              => $this->talk_price,
            'talk_anonym_call'        => $this->talk_anonym_call,
            'talk_call_type'          => $this->talk_call_type,
            'talk_teacher_name'       => $this->talk_teacher_name,
            'talk_language_name'      => $this->talk_language_name,
            'talk_subcategory_name'   => $this->talk_subcategory_name,
            'talk_category_name'      => $this->talk_category_name,
            'talk_headline'           => $this->talk_headline,
            'talk_teacher_username'   => $this->talk_teacher_username,
            'teacher_profile_picture' => $this->teacher_profile_picture,
        ]);

        return $html;
    }
}
