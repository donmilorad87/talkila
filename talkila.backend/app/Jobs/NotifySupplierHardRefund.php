<?php

namespace App\Jobs;

use App\Models\HelperModel;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifySupplierHardRefund implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string|int Supplier ID
     */
    protected $supplierId;

    /**
     * @var string Talk name.
     */
    protected string $talkName;

    /**
     * @var string Talk refund date.
     */
    protected string $talkDate;

    /**
     * @var string Talk refund time.
     */
    protected string $talkTime;

    /**
     * Create a new job instance.
     *
     * @param $supplierId
     * @param $talkName
     * @param $talkDate
     * @param $talkTime
     */
    public function __construct($supplierId, $talkName, $talkDate, $talkTime)
    {
        $this->supplierId = $supplierId;
        $this->talkName   = $talkName;
        $this->talkDate   = $talkDate;
        $this->talkTime   = $talkTime;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Query the User.
        $user = User::find($this->supplierId);

        // If the User exists, set app localization to users' last language.
        if ($user) {
            app()->setLocale($user->last_language);
        }

        $data = [
            'user_id'            => $this->supplierId,
            'notification_value' => $this->supplierId,
            'type'               => __('NOTIFICATION_SUPPLIER_HARD_REFUND'),
            'notification_title' => __('NOTIFICATION_SUPPLIER_HARD_REFUND_TITLE'),
            'notification_body'  => __('NOTIFICATION_SUPPLIER_HARD_REFUND_BODY', [
                'talkName' => $this->talkName,
                'talkDate' => $this->talkDate,
                'talkTime' => $this->talkTime,
            ]),
        ];

        HelperModel::sendPushNotification($data);
    }
}
