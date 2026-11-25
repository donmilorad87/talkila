<?php

namespace App\Jobs;

use App\Models\HelperModel;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyClientTalkCanceled implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string|int Client ID.
     */
    protected $clientId;

    /**
     * @var string|int Booking ID.
     */
    protected $bookingId;

    /**
     * @var string Supplier username.
     */
    protected string $talkSupplier;

    /**
     * @var string Talk name.
     */
    protected string $talkName;

    /**
     * @var string Talk cancellation date.
     */
    protected string $talkDate;

    /**
     * @var string Talk cancellation time.
     */
    protected string $talkTime;

    /**
     * Create a new job instance.
     *
     * @param $clientId
     * @param $bookingId
     * @param $talkSupplier
     * @param $talkName
     * @param $talkDate
     * @param $talkTime
     */
    public function __construct($clientId, $bookingId, $talkSupplier, $talkName, $talkDate, $talkTime)
    {
        $this->clientId     = $clientId;
        $this->bookingId    = $bookingId;
        $this->talkSupplier = $talkSupplier;
        $this->talkName     = $talkName;
        $this->talkDate     = $talkDate;
        $this->talkTime     = $talkTime;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public
    function handle()
    {
        // Query the User.
        $user = User::find($this->clientId);

        // If the User exists, set app localization to users' last language.
        if ($user) {
            app()->setLocale($user->last_language);
        }

        $data = [
            'user_id'            => $this->clientId,
            'notification_value' => $this->bookingId,
            'type'               => __('NOTIFICATION_TALK_CANCELED_BY_SUPPLIER', [
                'talkName' => $this->talkName,
            ]),
            'notification_title' => __('NOTIFICATION_TALK_CANCELED_BY_SUPPLIER_TITLE', [
                'talkName' => $this->talkName,
            ]),
            'notification_body'  => __('NOTIFICATION_TALK_CANCELED_BY_SUPPLIER_BODY', [
                'talkSupplier' => $this->talkSupplier,
                'talkName'     => $this->talkName,
                'talkDate'     => $this->talkDate,
                'talkTime'     => $this->talkTime,
            ]),
        ];

        HelperModel::sendPushNotification($data);
    }
}