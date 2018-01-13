<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FriendshipController extends Controller
{
    //
    public function check($id) {
        if(\Auth::user()->is_friends_with($id) === 1) {
            return ['status' => 'friends'];
        }

        if(\Auth::user()->has_pending_friend_request_from($id)) {
            return ['status' => 'pending'];
        }

        if(\Auth::user()->has_pending_friend_request_sent_to($id)) {
            return ['status' => 'waiting'];
        }

        return ['status' => 0];
    }

    public function check_friendship($id) {
        $isfriends = 0;
        if(\Auth::user()->is_friends_with($id) === 1 || 
            \Auth::user()->has_pending_friend_request_from($id) || 
            \Auth::user()->has_pending_friend_request_sent_to($id) || 
            \Auth::id() === $id) {
            $isfriends = 1;
        }
        return $isfriends;
    }

    public function add_friend($id) {
        $resp = \Auth::user()->add_friend($id);

        \App\User::find($id)->notify(new \App\Notifications\NewFriendRequest(\Auth::user()));

        return $resp;
    }

    public function accept_friend($id) {
        $resp =  \Auth::user()->accept_friend($id);

        $user = \App\User::find($id);

        $user->notify(new \App\Notifications\FriendRequestAccepted(\Auth::user()));

        $friends = $user->friends();

        foreach($friends as $friend):
            $friend->notify(new \App\Notifications\ShareFriendActivity(\Auth::user(), $user));
        endforeach;
        
        return $resp;
    }

    public function get_friend_suggestions() {
        $list = [];
        $suggestions = [];
        $clouts = \Auth::user()->get_clouts_from_same_state_id();

        if(count($clouts) > 0):
            foreach($clouts as $clout):
                if(!$this->check_friendship($clout)):
                    array_push($suggestions, $clout);
                endif;
            endforeach;
        endif;

        if(count($suggestions) > 10):
            $suggestions = array_slice($suggestions, 10);
        endif;

        foreach($suggestions as $suggestion):
            array_push($list, \Auth::user()->get_user_from_id($suggestion));
        endforeach;

        return $list;
    }

    public function get_user_suggested($suggestion) {
        $user = \Auth::user()->get_user_from_id($suggestion);

        return $user;
    }
}
