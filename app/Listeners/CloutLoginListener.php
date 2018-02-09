<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CloutLoginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = \Auth::user();

        $total_logon = (int)$user->profile->total_login + 1;

        $user->profile()->update([
            'online_status' =>  1,
            'total_login'   =>  $total_logon
        ]);

        $user->notify(new \App\Notifications\CloutLoginNotification($user->id));

        $friends = $user->friends();

        foreach($friends as $friend):
            if($friend->id != $user->id):
                $friend->notify(new \App\Notifications\CloutLoginNotification($user->id));
            endif;
        endforeach;
    }
}
