<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function post_categories() {
        $categories = \App\PostCategory::all();

        return $categories;
    }

    public function store(Request $request) {
        $post_type = $request->type;

        if($post_type === 1):
        elseif($post_type === 2):
            //this is a petition
            $petition;
            $data = array(
                'title'      =>   $request->title,
                'body'       =>   $request->body,
                'category'   =>  $request->category,
                'target_arm' =>   $request->target,
                'time_frame' =>   $request->time
            );

            $validator  =   \Validator::make($data, [
                'title'     =>  'required|string',
                'body'      =>  'required|string',
                'category'  =>  'required|string',
                'target_arm'=>  'required|string',
                'time_frame'=>  'nullable',
            ]);

            if($validator->fails()):
                return $validator->errors();
            endif;

            if($data['target_arm'] == "President"):
                $data['target_number'] = 5000;
            elseif($data['target_arm'] == "Governor"):
                $data['target_number'] = 3000;
            elseif($data['target_arm'] == "Senate"):
                $data['target_number'] = 1500;
            elseif($data['target_arm'] == "House of Reps"):
                $data['target_number'] = 1000;
            elseif($data['target_arm'] == "State Reps"):
                $data['target_number'] = 750;
            elseif($data['target_arm'] == "Local Govt"):
                $data['target_number'] = 500;
            endif;

            $data['time_frame'] = "2d";
            $data['user_id'] = \Auth::id();

            $petition = \App\Petition::create($data);

            if(count($petition) > 0):
                if($request->hasFile('file')):
                    $files = $request->file('file');
                    foreach($files as $file):
                        $photo = $petition->photos()->create([
                            'photo' =>  $file->store('public/petitions')
                        ]);
                    endforeach;
                endif;
            else:
                $petition = -1;
            endif;
            return $petition;

        endif;
    }
}
