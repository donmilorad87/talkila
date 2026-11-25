<?php

namespace App\Http\Controllers;

use App\Exceptions\Handler;
use App\Http\Requests\SocketCallsProtocolRequest;
use Illuminate\Http\Request;
use App\Models\SocketCallsProtocol;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SocketCallsProtocolController extends Controller
{
    public static function store(Request $request)
    {
        Log::notice("\n\n" .self::class.'::'. __FUNCTION__ .'::$request');
        Log::notice($request);
        DB::beginTransaction();

        try {
            $request->headers->set('Time-Zone-Offset-UTC', $_COOKIE['timezone'] ?? '');
            $socketCallProtocol = SocketCallsProtocol::create($request->all());
            DB::commit();
        } catch(Exception $exception) {
            DB::rollBack();

            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_9000, self::class, __FUNCTION__);
        }
    }
}
