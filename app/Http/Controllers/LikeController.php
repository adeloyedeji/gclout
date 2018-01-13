<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like($post_id) {
        $post = \App\Post::find($post_id);

        $like = \App\Like::create([
            'user_id'   =>  \Auth::id(),
            'post_id'   =>  $post->id
        ]);

        $user = \App\User::find($post->user_id);

        $user->notify(new \App\Notifications\LikeNotification(\Auth::user(), $post));

        $friends = $user->friends();

        foreach($friends as $friend):
            $friend->notify(new \App\Notifications\ShareLikeActivity(\Auth::user(), $user, $post));
        endforeach;

        return \App\Like::find($like->id);
    }

    public function unlike($post_id) {
        $post = \App\Post::find($post_id);
        $like = \App\Like::where('user_id', \Auth::id())
                         ->where('post_id', $post->id)
                         ->first();
        //$id = $like->id;
        $like->delete();
        return $like->id;
    }
}
