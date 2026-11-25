<?php

namespace App\Http\Controllers;

use App\Exceptions\Handler;
use App\Http\Requests\SocketRoomRequest;
use Illuminate\Http\Request;
use App\Models\SocketRoom;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SocketRoomController extends Controller
{
    public function store(SocketRoomRequest $request)
    {
        Log::notice("\n\n" .self::class.'::'. __FUNCTION__ .'::$request');
        Log::notice($request);
        DB::beginTransaction();

        try {
            $socketRoom = SocketRoom::create($request->all());
            DB::commit();
        } catch(Exception $exception) {
            DB::rollBack();

            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_9300, self::class, __FUNCTION__);
        }
    }
}
