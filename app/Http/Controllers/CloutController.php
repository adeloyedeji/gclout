<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CloutController extends Controller
{
    public function total_clout() {
        return count(\Auth::user()->friends());
    }

    public function total_clout_photo() {
        return 1 + \Auth::user()->clout_photos_count();
    }

    public function clout_list($profile) {
        $user           =   \App\User::where('username', $profile)->first();
        $president      =   app('App\Http\Controllers\UtilityController')->get_leader_identity(2, 0);
        $governor       =   app('App\Http\Controllers\UtilityController')->get_leader_identity(3, \Auth::user()->profile->state_id);
        $senator        =   app('App\Http\Controllers\UtilityController')->get_leader_identity(4, \Auth::user()->profile->state_id);
        $ward_leader    =   app('App\Http\Controllers\UtilityController')->get_leader_identity(5, \Auth::user()->profile->state_id);
        $lga            =   app('App\Http\Controllers\UtilityController')->get_leader_identity(6, \Auth::user()->profile->state_id);
        $federal_rep    =   app('App\Http\Controllers\UtilityController')->get_leader_identity(7, \Auth::user()->profile->state_id);
        $state_rep      =   app('App\Http\Controllers\UtilityController')->get_leader_identity(8, \Auth::user()->profile->state_id);
        $friends        =   $user->friends();

        return view('clouts.list', [
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

    public function get_clouts($user_id) {
        $user       =   \App\User::find($user_id);

        $friends    =   $user->friends();

        return $friends;
    }

    public function get_pending_clouts($user_id) {
        $user       =   \App\User::find($user_id);

        $friends    =   $user->pending_friends_requests();

        return $friends;
    }

    public function get_pending_clouts_sent($user_id) {
        $user       =   \App\User::find($user_id);

        $friends    =   $user->pending_friends_requests_sent();

        return $friends;
    }

    public function user_data($id) {
        $user       =   \App\User::find($id);
        return $user;
    }

}
