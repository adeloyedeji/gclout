<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function messaging() {
        return view('messaging.index');
    }

    public function show($username) {
        $user = \App\User::where('username', $username)->first();

        if($user) {
            return view('messaging.show', [
                'user'  =>  $user,
            ]);
        } else {
            abort(404);
        }
    }
}
