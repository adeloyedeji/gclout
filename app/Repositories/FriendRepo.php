<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

use App\Repositories\Interfaces\FriendInterface;

class FriendRepo implements FriendInterface 
{
	public function getFriendsCount($uid)
	{
		$count;
		try {
			$count = \App\Friend::where('uid', $uid)->count();
		} catch(\Exception $ex) {
			return $ex;
		}
		return  $count;
	}

	public function getFriends($uid)
	{
		$friends;
		try {
			$friends = \App\Friend::where('uid', $uid)->paginate(15);
		} catch(\Exception $ex) {
			return $ex;
		}
		return $friends;
	}

	public function getFriendsFromFriendRequest($uid) {
		$friends;
		try {
			$friends = \App\FriendRequest::where('status', 1)->where('uid', $uid)->orWhere('fid', $uid)->get();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $friends;
	}

	public function getFriendsFromFriendRequestCount($uid) {
		$friends;
		try {
			$friends = \App\FriendRequest::where('status', 1)
					 ->where('uid', $uid)
					 ->orWhere('fid', $uid)
					 ->count();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $friends;
	}

	public function getPeople($id, $param_id)
	{
		$people;
		try {
			if($id == 'state')
			{
				$people = \App\User::where('state', $param_id)->take(10)->get();
			}
		} catch(\Exception $ex) {
			return $ex;
		}
		return $people;
	}

	public function getSuggestedFriends($state)
	{
		$suggesteds;
		try {
			$suggesteds = \App\User::where('state', $state)->where('role', 1)->inRandomOrder()->take(10)->get();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $suggesteds;
	}

	public function checkFriend($uid, $fid)
	{
		$isFriend = 0;
		try {
			$isFriend = \App\Friend::where('uid', $uid)->where('fid', $fid)->first();
			if(count($isFriend) > 0)
			{
				$isFriend = 1;
			}
		} catch(\Exception $ex) {
			return $ex;
		}
		return $isFriend;
	}

	public function checkFriendRequest($uid, $fid)
	{
		$requestSent = 0;
		try {
			$isRequestSent = \App\FriendRequest::where('uid', $uid)->where('fid', $fid)->first();
			$isRequestSent ? $requestSent = 1 : $requestSent = 0;
		} catch(\Exception $ex) {
			return $ex;
		}
		return $requestSent;
	}

	public function sendFriendRequest($data) {
		$request = 0;
		try {
			if(
				$this->checkFriendRequest($data['uid'], $data['fid']) == 0 
				&& 
				$this->checkFriendRequest($data['fid'], $data['fid']) == 0
			) {
				$request = \App\FriendRequest::firstOrCreate($data);
			}
		} catch(\Exception $ex) {
			return $ex;
		}
		return $request;
	}

	public function acceptFriendRequest($uid, $fid) {
		$accept;
		try {
			$accept = \App\FriendRequest::where('uid', $uid)
					 ->where('fid', $fid)
					 ->update(['status' => 1]);
		} catch(\Exception $ex) {
			return $ex;
		}
		return $accept;
	}
}