<?php

namespace App\Http\Controllers;

use App\Exceptions\Handler;
use App\Http\Requests\SocketNetworkQualityRequest;
use Illuminate\Http\Request;
use App\Models\SocketNetworkQuality;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SocketNetworkQualityController extends Controller
{
    public function store(Request $request)
    {
        Log::notice("\n\n" .self::class.'::'. __FUNCTION__ .'::$request');
        Log::notice($request);
        DB::beginTransaction();

        try {
            $socketNetworkQuality = SocketNetworkQuality::create($request->all());
            DB::commit();

            return response()->success('Network Quality info added.');

        } catch(Exception $exception) {
            DB::rollBack();

            Log::notice(self::class.'::'. __FUNCTION__ .' (ERROR)::');
            app(Handler::class)->report($exception, Handler::PRIORITY['URGENT'], Handler::TYPE_EXCEPTION_9100, self::class, __FUNCTION__);

            // return response()->error('Failed to retrieve Network Quality info.');
        }
    }
}
