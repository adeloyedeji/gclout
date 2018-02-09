<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpeechController extends Controller
{
    public function index($username) {
        $user = \App\User::where('username', $username);

        if( count($user) > 0 ):
            return view('speech.index', [
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

            $speech = \Auth::user()->speech()->create($data);

            if($speech):
                if($request->hasFile('file')):
                    $has_photo = !$has_photo;
                    $files = $request->file('file');
                    foreach($files as $file):
                        $photo = \App\SpeechPhoto::create([
                            'speeches_id'   =>  $speech->id,
                            'photo'         =>  $file->store('public/speech'),
                        ]);
                    endforeach;
                endif;                
                $saved_speech = \App\Speech::find($speech->id);
                $element = $saved_speech;
            else:
                $element = -1;
            endif;
        else:
            $element = 'invalid method';
        endif;

        return $element;
    }

    public function speech_feed($id) {
        $speech_feed =   [];
        $user       =   \App\User::find($id);
        $friends    =   $user->friends();

        foreach($friends as $friend):
            foreach($friend->speech as $speech):
                array_push($speech_feed, $speech);
            endforeach;
        endforeach;

        foreach($user->speech as $speech):
            array_push($speech_feed, $speech);
        endforeach;
        
        usort($speech_feed, function($p1, $p2) {
            return $p1->id < $p2->id;
        });

        return $speech_feed;
    }

    public function like($speech_id) {
        $speech = \App\Speech::find($speech_id);

        $like = \App\SpeechLike::create([
            'user_id'       =>  \Auth::id(),
            'speeches_id'   =>  $speech->id
        ]);

        $saved_like = \App\SpeechLike::find($like->id);

        return $saved_like;
    }

    public function unlike($speech_id) {
        $id = 0;
        $speech = \App\Speech::find($speech_id);

        $like = \App\SpeechLike::where('user_id', \Auth::id())->where('speeches_id', $speech->id)->first();

        $id = $like->id;

        $like->delete();

        return $id;
    }
}
