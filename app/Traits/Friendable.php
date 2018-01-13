<?php

namespace App\Traits;

trait Friendable {

    public function add_friend($user_requested_id) {
        if($this->id === $user_requested_id) {
            return 0;
        }

        if($this->has_pending_friend_request_sent_to($user_requested_id)) {
            return "already sent a friend request.";
        }

        if($this->has_pending_friend_request_from($user_requested_id) === 1) {
            return $this->accept_friend($user_requested_id);
        }

        if($this->is_friends_with($user_requested_id) === 1) {
            return "already friends";
        }

        $friendship = \App\Friendship::create([
            'requester'         =>  $this->id,
            'user_requested'    =>  $user_requested_id
        ]);

        if($friendship) {
            return 1;
        }

        return 0;
    }

    public function accept_friend($requester) {
        if($this->has_pending_friend_request_from($requester) === 0) {
            return 0;
        }

        $friendship = \App\Friendship::where('requester', $requester)
                                     ->where('user_requested', $this->id)
                                     ->first();
        if($friendship) {
            $friendship->update([
                'status'    =>  1,
            ]);
            return 1;
        }

        return 0;
    }

    public function friends() {
        $friends1 = array();
        $friends2 = array();

        $f1 = \App\Friendship::where('status', 1)
                             ->where('requester', $this->id)
                             ->get();

        foreach($f1 as $friendship):
            array_push($friends1, \App\User::find($friendship->user_requested));
        endforeach;
        
        $f2 = \App\Friendship::where('status', 1)
                             ->where('user_requested', $this->id)
                             ->get();

        foreach($f2 as $friendship):
            array_push($friends2, \App\User::find($friendship->requester));
        endforeach;

        return array_merge($friends1, $friends2);
    }

    public function pending_friends_requests() {
        $users = array();

        $friendships = \App\Friendship::where('status', 0)
                                     ->where('user_requested', $this->id)
                                     ->get();

        foreach($friendships as $friendship):
            array_push($users, \App\User::find($friendship->requester));
        endforeach;

        return $users;
    }

    public function friends_ids() {
        return collect($this->friends())->pluck('id');
    }

    public function is_friends_with($user_id) {
        if(in_array($user_id, $this->friends_ids()->toArray())) {
            return 1;
        }
        return 0;
    }

    public function pending_friends_requests_ids() {
        return collect($this->pending_friends_requests())->pluck('id')->toArray();
    }

    public function pending_friends_requests_sent() {
        $users = array();

        $friendships = \App\Friendship::where('status', 0)
                                      ->where('requester', $this->id)
                                      ->get();

        foreach($friendships as $friendship):
            array_push($users, \App\User::find($friendship->user_requested));
        endforeach;

        return $users;
    }

    public function pending_friends_requests_sent_ids() {
        return collect($this->pending_friends_requests_sent())->pluck('id')->toArray();
    }

    public function has_pending_friend_request_from($user_id) {
        if(in_array($user_id, $this->pending_friends_requests_ids())) {
            return 1;
        }
        return 0;
    }

    public function has_pending_friend_request_sent_to($user_id) {
        if(in_array($user_id, $this->pending_friends_requests_sent_ids())) {
            return 1;
        }
        return 0;
    }

    public function get_clouts_from_same_state() {
        $users = [];

        $profiles = \App\Profile::where('state_id', $this->profile->state_id)->limit(11)->get();
        if( count($profiles) > 0):
            foreach($profiles as $profile):
                array_push($users, \App\User::find($profile->user_id));
            endforeach;
        endif;

        return $users;
    }

    public function get_clouts_from_same_state_id() {
        return collect($this->get_clouts_from_same_state())->pluck('id')->toArray();
    }

    public function get_user_from_id($id) {
        return \App\User::find($id);
    }
}