<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotosController extends Controller
{
    public function index($username) {
        $user   =   \App\User::where('username', $username)->first();

        $president      =   app('App\Http\Controllers\UtilityController')->get_leader_identity(2, 0);
        $governor       =   app('App\Http\Controllers\UtilityController')->get_leader_identity(3, \Auth::user()->profile->state_id);
        $senator        =   app('App\Http\Controllers\UtilityController')->get_leader_identity(4, \Auth::user()->profile->state_id);
        $ward_leader    =   app('App\Http\Controllers\UtilityController')->get_leader_identity(5, \Auth::user()->profile->state_id);
        $lga            =   app('App\Http\Controllers\UtilityController')->get_leader_identity(6, \Auth::user()->profile->state_id);
        $federal_rep    =   app('App\Http\Controllers\UtilityController')->get_leader_identity(7, \Auth::user()->profile->state_id);
        $state_rep      =   app('App\Http\Controllers\UtilityController')->get_leader_identity(8, \Auth::user()->profile->state_id);

        return view('photos.index', [
            'user'          =>  $user,
            'president'		=>	$president,
            'governor'		=>	$governor,
            'senator'		=>	$senator,
            'ward'          =>	$ward_leader,
            'lga'    		=>	$lga,
            'federal'       =>	$federal_rep,
            'state'    	    =>	$state_rep,
        ]);
    }

    public function get_photo($id) {
        $photos = [];
        $user   =   \App\User::find($id);
        $posts =   $user->posts;

        foreach($posts as $post):
            foreach($post->photos as $photo):
                array_push($photos, $photo->photo);
            endforeach;
        endforeach;

        return $photos;
    }
}
