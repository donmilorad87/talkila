<?php

namespace App\Jobs;

use App\Models\HelperModel;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifySupplierFollowRequested implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string|int Supplier ID
     */
    protected $supplierId;

    /**
     * @var string|int Client username.
     */
    protected $clientUsername;

    /**
     * Create a new job instance.
     *
     * @param $supplierId
     * @param $clientUsername
     */
    public function __construct($supplierId, $clientUsername)
    {
        $this->supplierId     = $supplierId;
        $this->clientUsername = $clientUsername;
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
            'type'               => 'NOTIFICATION_SUPPLIER_FOLLOW_REQUESTED_TYPE',
            'notification_title' => __('NOTIFICATION_SUPPLIER_FOLLOW_REQUESTED_TITLE', [
                'username' => $this->clientUsername,
            ]),
            'notification_body'  => __('NOTIFICATION_SUPPLIER_FOLLOW_REQUESTED_BODY'),
        ];

        HelperModel::sendPushNotification($data);
    }
}