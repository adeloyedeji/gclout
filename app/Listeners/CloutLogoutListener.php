<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CloutLogoutListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
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

        $user->profile()->update([
            'online_status' =>  0
        ]);

        $user->notify(new \App\Notifications\CloutLogoutNotification($user->id));

        $friends = $user->friends();

        foreach($friends as $friend):
            if($friend->id != $user->id):
                $friend->notify(new \App\Notifications\CloutLogoutNotification($user->id));
            endif;
        endforeach;
    }
}
