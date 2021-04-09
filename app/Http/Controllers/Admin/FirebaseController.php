<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\User;

class FirebaseController extends Controller
{
    public function sendAll(Request $request){

        $recipients = User::WhereNotNUll('device_token')
                          ->pluck('device_token')->toArray();
       // dd($recipients);

        fcm()
    ->to($recipients) // $recipients must an array
    ->priority('high')
    ->timeToLive(0)
    ->notification([
        'title' => $request->input('tittle'),
        'body' => $request->input('body'),
    ])
    ->send();
    $notification = "Se envio notificaiones a todos los usuarios Android.";

    return back()->with(compact('notification'));

    }
}
