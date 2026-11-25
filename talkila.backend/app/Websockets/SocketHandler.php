<?php

namespace App\Websockets;

use Illuminate\Support\Facades\Log;

/**
 * Stub SocketHandler - the BeyondCode\LaravelWebSockets package has been
 * replaced by laravel/reverb. This class is kept as a placeholder.
 * WebSocket functionality is now handled by Laravel Reverb.
 */
class SocketHandler
{
    public function onOpen($connection)
    {
        Log::info('WebSocket connection opened');
    }

    public function onMessage($connection, $message)
    {
        Log::info('WebSocket message received');
    }
}
