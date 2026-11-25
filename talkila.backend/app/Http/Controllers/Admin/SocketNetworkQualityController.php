<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SocketNetworkQualityRequest;
use Illuminate\Http\Request;
use App\Models\SocketNetworkQuality;
use Exception;
use Illuminate\Support\Facades\DB;

class SocketNetworkQualityController extends Controller
{
    public function store(SocketNetworkQualityRequest $request)
    {
        try {
            DB::beginTransaction();
            $socketNetworkQuality = SocketNetworkQuality::create($request->all());
            DB::commit();
        } catch(Exception $exception) {
            DB::rollBack();
        }
        return redirect()->route('index');
    }
}
