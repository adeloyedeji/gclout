<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['onboard', 'auth', 'blocked']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function notifications() {
        \Auth::user()->unreadNotifications->markAsRead();
        
        return view('notifications.index')->with('notifications', \Auth::user()->notifications);
    }
}
