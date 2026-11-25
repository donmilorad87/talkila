<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ValidateWebsocketService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'validate:websocket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validates state of Laravel Websocket service.';

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
     * @return bool
     */
    public function handle(): bool
    {
        Log::notice('Validating Laravel Websockets service...');

        $output    = shell_exec("ps aux | grep -i websocket:serve");
        $isRunning = !empty($output);

        if (!$isRunning) {
            Log::error('Laravel Websockets service is not running!');

            return false;
        }

        Log::notice('Laravel Websockets service is running!');

        return true;
    }
}
