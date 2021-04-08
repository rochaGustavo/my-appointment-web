<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FirebaseController extends Controller
{
    public function postToken(Request $request){

        $user = Auth::guard('api')->user();
        $user->device_token = $request->input('device_token');
        $user->save();
    }
}
