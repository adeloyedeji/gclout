<?php 

namespace App\Repositories;

use App\Repositories\Interfaces\IntroInterface;

class IntroRepo implements IntroInterface
{
	public function updateProfile(array $data)
	{
		$status = 0;
		try {
			$update = \App\User::where('id', \Auth::user()->id)->update($data);
			$status = 1;
		} catch(\Exception $ex) {
			return $ex;
		}
		return $status;
	}

	public function follow(array $payLoad, $option)
	{
		$status = 0;
		switch($option)
		{
			case 1:
				try {
					$update = \App\FollowState::create($payLoad);
					$status = 1;
				} catch(\Exception $ex) {
					return $ex;
				}

				//follow state
				break;
		}
		return $status;
	}

	public function isFollowing(array $payLoad, $option)
	{
		$status = 0;
		switch ($option) 
		{
			case 1:
				try {
					$check = \App\FollowState::where('uid', $payLoad['uid'])->where('sid', $payLoad['sid'])->first();
					if(count($check) > 0)
					{
						//is already following
						$status = 1;
					}
				} catch(\Exception $ex) {
					return $ex;
				}
				//check if is following state
				break;
			
			default:
				# code...
				break;
		}
		return $status;
	}

	public function finish()
	{
		$status = 0;
		try {
			$update = \App\User::where('id', \Auth::user()->id)->update(['first_time' => 1]);
			$status = 1;
		} catch(\Exception $ex) {
			return $ex;
		}
		return $status;
	}

	public function checkUser()
	{
		$user;
		try {
			$name = $request->username;
			$check = \App\User::where('name', $name)->first();
			if(count($check) > 0)
			{
				Auth::login();
			}
		} catch(\Exception $ex) {
			abort(500);
		}
	}
}