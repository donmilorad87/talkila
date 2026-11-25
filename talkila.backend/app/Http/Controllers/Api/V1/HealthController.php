<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Liveness check for the deploy smoke test and uptime monitors: the app boots and the database answers.
 */
class HealthController extends Controller
{
    public function __invoke(): JsonResponse
    {
        try {
            DB::select('SELECT 1');
        } catch (Throwable $exception) {
            Log::error('Health check: database unreachable', ['error' => $exception->getMessage()]);

            return response()->json(['status' => 'error', 'database' => 'error'], 503);
        }

        return response()->json(['status' => 'ok', 'database' => 'ok']);
    }
}
