<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function store(Request $request) {
        $postData = array(
            'uid'           =>  \Auth::id(),
            'content'       =>  $request->content,
            'video'         =>  $request->video,
            'location'      =>  $request->location,
        );

        $validator = \Validator::make($postData, [
            'content'       =>  'nullable|string|max:200',
            'video'         =>  'nullable|url',
            'location'      =>  'nullable|string',
        ]);

        $post = \Auth::user()->posts()->create([ 
            'content'   =>  $request->content,
            'video'     =>  $request->video,
            'location'  =>  $request->location
        ]);

        if($post) {
            \Auth::user()->notify(new \App\Notifications\PostNotification($post, \Auth::user()));
            if($request->hasFile('file')) {
                $file = $request->file('file');
                foreach($file as $f):
                    $photo = \App\PostPhoto::create([
                        'post_id'   =>  $post->id,
                        'photo'     =>  $f->store('public/posts')
                    ]);
                endforeach;
                return $post;
            }
        } else {
            return "unable to save post";
        }

        return $post;
    }
}
