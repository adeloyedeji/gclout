<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function __construct() {
        
    }
    //
    public function index($username) {
        $user           =   \App\User::where('username', $username)->first();
        if(count($user) > 0):
            $president      =   app('App\Http\Controllers\UtilityController')->get_leader_identity(2, 0);
            $governor       =   app('App\Http\Controllers\UtilityController')->get_leader_identity(3, \Auth::user()->profile->state_id);
            $senator        =   app('App\Http\Controllers\UtilityController')->get_leader_identity(4, \Auth::user()->profile->state_id);
            $ward_leader    =   app('App\Http\Controllers\UtilityController')->get_leader_identity(5, \Auth::user()->profile->state_id);
            $lga            =   app('App\Http\Controllers\UtilityController')->get_leader_identity(6, \Auth::user()->profile->state_id);
            $federal_rep    =   app('App\Http\Controllers\UtilityController')->get_leader_identity(7, \Auth::user()->profile->state_id);
            $state_rep      =   app('App\Http\Controllers\UtilityController')->get_leader_identity(8, \Auth::user()->profile->state_id);
            return view('profiles.index', [
                'user'  =>  $user,
                'president'		=>	$president,
                'governor'		=>	$governor,
                'senator'		=>	$senator,
                'ward'          =>	$ward_leader,
                'lga'    		=>	$lga,
                'federal'       =>	$federal_rep,
                'state'    	    =>	$state_rep,
            ]);
        else:
            abort(404);
        endif;
    }

    public function about($username) {
        $user = \App\User::where('username', $username)->first();
        return view('profiles.about', [
            'user'  =>  $user,
            'about' =>  $user->profile->about
        ]);
    }

    public function edit() {
        return view('profiles.edit')->with('profile', \Auth::user()->profile);
    }

    public function update(Request $request) {
        $this->validate($request, [
            'location'  =>  'nullable|string',
            'about'     =>  'nullable|string|max:255',
        ]);
        \Auth::user()->profile()->update([
            'location'  =>  $request->location,
            'about'     =>  $request->about,
        ]);
        if($request->hasFile('avatar')) {
            \Auth::user()->update([
                'avatar'    =>  $request->avatar->store('public/avatars'),
            ]);
        }
        \Session::flash('success', 'Profile updated.');
        return redirect()->back();
    }

    public function intro(Request $request) {
        $validator = \Validator::make($request->all(), [
            'gender'        =>  'required|integer',
            'username'      =>  'required|string|max:10|unique:users',
            'dob'           =>  'required|max:10',
            'nationality'   =>  'required|integer',
            'residence'     =>  'required|integer',
            'state'         =>  'required|integer',
            'lga'           =>  'required|integer',
        ]);

        if($validator->fails()) {
            return $validator->errors();
        }

        $avatar = "public/defaults/avatars/female.jpg";
        if($request->gender == 1) {
            $avatar = "public/defaults/avatars/male.jpg";
        }

        \Auth::user()->update([
            'username'  =>  $request->username,
            'gender'    =>  $request->gender,
            'avatar'    =>  $avatar
        ]);

        \Auth::user()->profile()->update([
            'date_of_birth' =>  $request->dob,
            'state_id'      =>  $request->state,
            'lga_id'        =>  $request->lga,
            'country_id'    =>  $request->nationality,
            'residence'     =>  $request->residence,
            'account_status'=>  1,
            'online_status' =>  1,
            'total_login'   =>  \Auth::user()->profile->total_login + 1
        ]);

        return "success";
    }

    public function save_bio(Request $request) {
        $data = array(
            'id'        =>  \Auth::user()->id,
            'name'      =>  $request->name,
            'username'  =>  $request->uname
        );

        $validator = \Validator::make($data, [
            'name'      =>  'required|string',
            'username'  =>  'required|string|max:16'
        ]);

        if($validator->fails()) {
            return $validator->errors();
        }

        $update = \Auth::user()->update($data);
        return response()->json($update);
    }

    public function save_phone(Request $request) {
        $data = array(
            'id'            =>  \Auth::user()->id,
            'phone_number'  =>  $request->phone
        );

        $validator = \Validator::make($data, [
            'phone_number' =>  'required|numeric|min:11'
        ]);

        if($validator->fails()) {
            return $validator->errors();
        }

        $update = \Auth::user()->profile()->update($data);

        return response()->json($update);
    }

    public function save_address(Request $request) {
        $data = array(
            'id'        =>  \Auth::user()->id,
            'address'   =>  $request->street ? $request->street : \Auth::user()->profile->address,
            'ward'      =>  $request->ward ? $request->ward : \Auth::user()->profile->ward,
            'lga_id'    =>  $request->lga ? $request->lga : \Auth::user()->profile->lga_id,
            'state_id'  =>  $request->state ? $request->state : \Auth::user()->profile->state_id
        );

        $validator = \Validator::make($data, [
            'address'   =>  'nullable|string',
            'ward'      =>  'nullable|string',
            'lga_id'    =>  'nullable|integer',
            'state_id'  =>  'nullable|integer'
        ]);

        if($validator->fails()) {
            return $validator->errors();
        }
        $update = \Auth::user()->profile()->update($data);

        return response()->json($update);
    }

    public function save_others(Request $request) {
        $data = array(
            'id'            =>  \Auth::user()->id,
            'gender'        =>  $request->gender,
            'date_of_birth' =>  $request->dob,
            'job'           =>  $request->job
        );

        $validator = \Validator::make($data, [
            'gender'            =>  'nullable|integer',
            'date_of_birth'     =>  'nullable|date_format:Y-m-d',
            'job'               =>  'nullable|string'
        ]);

        if($validator->fails()) {
            return $validator->errors();
        }

        \Auth::user()->update(['gender' => $data['gender']]);
        $update = \Auth::user()->profile->update([
            'date_of_birth' =>  $data['date_of_birth'],
            'job'           =>  $data['job']
        ]);

        return response()->json($update);
    }

    public function save_about(Request $request) {
        $data = array(
            'about'     =>  $request->about
        );

        $validator = \Validator::make($data, [
            'about' =>  'required|string'
        ]);

        if($validator->fails()) {
            return $validator->errors();
        }

        $saveUpdate = \Auth::user()->profile()->update($data);

        return response()->json($saveUpdate);
    }

    public function save_avatar(Request $request) {
        if($request->hasFile('file')) {
            $file = $request->file('file');
            
            /*
            $validator = \Validator::make($request->all(), [
                'file' =>  'required|mimes:jpeg,jpg,png,PNG,svg'
            ]);
    
            if($validator->fails()) {
                return $validator->errors();
            }
            */

            $update = \Auth::user()->update([
                'avatar'    =>  $file->store('public/avatars')
            ]);

            if(\Auth::user()->avatar == "public/defaults/avatars/female.jpg" || \Auth::user()->avatar == "public/defaults/avatars/male.jpg"):
                $update = 2;
            else:
                $update = 1;
            endif;
            return $update;
        }
    }

    public function save_cover_photo(Request $request) {
        if($request->hasFile('file')) {
            $file = $request->file('file');
        
            $update = \Auth::user()->update([
                'cover'    =>  $file->store('public/covers')
            ]);

            if(\Auth::user()->cover == "public/defaults/avatars/default.jpg"):
                $update = 2;
            else:
                $update = 1;
            endif;
            return $update;
        }
    }
}
