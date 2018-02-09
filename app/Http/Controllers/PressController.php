<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PressController extends Controller
{
    public function index($username) {
        $user = \App\User::where('username', $username);

        if( count($user) > 0 ):
            return view('press.index', [
                'user'  =>  $user,
            ]);
        else:
            abort(404);
        endif;
    }

    public function store(Request $request) {
        if($request->ajax()):
            $body = $request->body;
            $has_photo = false;
            $data = array(
                'body'  =>  $request->body,
            );

            $validator = \Validator::make($data, [
                'body'  =>  'required|string',
            ]);

            if($validator->fails()):
                return $validator->errors();
            endif;

            $press = \Auth::user()->press()->create($data);

            if($press):
                if($request->hasFile('file')):
                    $has_photo = !$has_photo;
                    $files = $request->file('file');
                    foreach($files as $file):
                        $photo = $press->photos()->create([
                            'photo' =>  $file->store('public/press'),
                        ]);
                    endforeach;
                endif;                
                $saved_press = \App\Press::find($press->id);
                $element = $saved_press;
            else:
                $element = -1;
            endif;
        else:
            $element = 'invalid method';
        endif;

        return $element;
    }

    public function press_feed($id) {
        $press_feed =   [];
        $user       =   \App\User::find($id);
        $friends    =   $user->friends();

        foreach($friends as $friend):
            foreach($friend->press as $press):
                array_push($press_feed, $press);
            endforeach;
        endforeach;

        foreach($user->press as $press):
            array_push($press_feed, $press);
        endforeach;
        
        usort($press_feed, function($p1, $p2) {
            return $p1->id < $p2->id;
        });

        return $press_feed;
    }

    public function like($press_id) {
        $press = \App\Press::find($press_id);

        $like = $press->likes()->create([
            'user_id'   =>  \Auth::id()
        ]);

        $saved_like = \App\PressLike::find($like->id);

        return $saved_like;
    }

    public function unlike($press_id) {
        $id = 0;
        $press = \App\Press::find($press_id);

        $like = \App\PressLike::where('user_id', \Auth::id())->where('press_id', $press->id)->first();

        $id = $like->id;

        $like->delete();

        return $id;
    }
}
