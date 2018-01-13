<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilityController extends Controller
{
    //
    public function get_countries($type) {
        $countries;
        try {
            if($type == 'all') {
                $countries = \App\Country::all();
            }
        } catch(\Exception $ex) {
            return $ex;
        }
        return $countries;
    }

    public function get_states($type) {
        $states;
        try {
            if($type == 'all') {
                $states = \App\State::all();
            }
        } catch(\Exception $ex) {
            return $ex;
        }
        return $states;
    }

    public function username_check($username) {
        $status = "available";
        $check = \App\User::where('username', $username)->first();
        if(count($check) > 0):
            $status = "not available";
        endif;
        return $status;
    }

    public function get_lga_by_state($state) {
        $lga;
        if($state == 800):
            $lga = \App\Lga::all();
        else:
            $lga = \App\Lga::where('state_id', $state)->get();
        endif;
        return $lga;
    }
    public function get_leader_identity($role, $state) {
        $profile = "not defined";
        $identity;
        if($state == 0) {
            $identity = \App\Profile::where('role', $role)->first();
        } else {
            $identity = \App\Profile::where('role', $role)
                                    ->where('state_id', $state)
                                    ->first();
        }
        if( count($identity) > 0 ) {
            $profile = \App\User::find($identity->user_id);
        }
        return $profile;
    }
}
