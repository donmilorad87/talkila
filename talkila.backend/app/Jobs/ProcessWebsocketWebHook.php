<?php

namespace App\Jobs;

use App\Models\Booking;
use Illuminate\Support\Facades\Log;
use \Spatie\WebhookClient\ProcessWebhookJob as SpatieProcessWebhookJob;

/**
 * Class ProcessWebsocketWebHook
 * @package App\Jobs
 */
class ProcessWebsocketWebHook extends SpatieProcessWebhookJob
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::notice('Websocket Webhook:: ');
        Log::notice($this->webhookCall);

        $notificationRequest = json_decode($this->webhookCall, true);

        if(isset($notificationRequest['payload']["booking_id"])) {
            /*$oBooking = Booking::query()->where('id', $notificationRequest['payload']["booking_id"])->withTrashed()->exists();

            if(!empty($oBooking)) {
                $oBooking->state = 5;
                $oBooking->save();
            }*/
        }

        echo "[accepted]";
    }
}
