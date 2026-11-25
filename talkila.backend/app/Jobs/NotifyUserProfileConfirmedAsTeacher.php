<?php

namespace App\Jobs;

use App\Models\HelperModel;
use App\Models\Notifications;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyUserProfileConfirmedAsTeacher implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string|int Supplier ID.
     */
    protected $supplierId;

    /**
     * @var string Supplier username.
     */
    protected $username;

    /**
     * Create a new job instance.
     *
     * @param $supplierId
     * @param $username
     *
     * @return void
     */
    public function __construct($supplierId, $username)
    {
        $this->supplierId = $supplierId;
        $this->username   = $username;
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
            'action'             => Notifications::VALUE['account_verified'],
            'type'               => __('NOTIFICATION_PROFILE_CONFIRMED_AS_SUPPLIER'),
            'notification_title' => __('NOTIFICATION_PROFILE_CONFIRMED_AS_SUPPLIER_TITLE'),
            'notification_body'  => __('NOTIFICATION_PROFILE_CONFIRMED_AS_SUPPLIER_BODY', [
                'username' => $this->username,
            ]),
        ];

        HelperModel::sendPushNotification($data);
    }
}