<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SocketRoomErrorRequest;
use Illuminate\Http\Request;
use App\Models\SocketRoomError;
use Exception;
use Illuminate\Support\Facades\DB;

class SocketRoomErrorController extends Controller
{
    public function store(SocketRoomErrorRequest $request)
    {
        try {
            DB::beginTransaction();
            $socketRoomError = SocketRoomError::create($request->all());
            DB::commit();
        } catch(Exception $exception) {
            DB::rollBack();
        }
        return redirect()->route('index');
    }
}
