<?php

namespace App\Console\Commands;

use App\Jobs\ProcessAdyenWebHook;
use Illuminate\Console\Command;
use Spatie\WebhookServer\WebhookCall;

class TestWebHookSending extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'webhook:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//        $homepage = file_get_contents('http://127.0.0.1:8000/admin/adyen-refund-payment-tmp');
//        echo $homepage;

//        ProcessAdyenWebHook::dispatchNow();

        WebhookCall::create()
            ->url('http://127.0.0.1/local.talkila.com/laravel/public/webhook-receiving-url')
            ->payload(['key' => 'value'])
            ->useSecret(env('WEBHOOK_CLIENT_SECRET'))
            ->dispatchNow();
    }
}
