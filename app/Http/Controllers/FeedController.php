<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedController extends Controller
{
    //
    public function feed($id) {
        $user = \App\User::find($id);
        $friends = $user->friends();

        $feed = array();

        foreach($friends as $friend):
            foreach($friend->posts as $post):
                array_push($feed, $post);
            endforeach;
        endforeach;

        foreach($user->posts as $post):
            array_push($feed, $post);
        endforeach;

        usort($feed, function($p1, $p2) {
            return $p1->id < $p2->id;
        });

        /*
        usort($feed, function($p1, $p2) {
            $t1 = strtotime($p1->created_at);
            $t2 = strtotime($p2->created_at);
            return $t1 > $t2;
        });
        */

        return $feed;
    }
}
