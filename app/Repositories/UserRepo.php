<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

use App\Repositories\Interfaces\UserInterface;

class UserRepo implements UserInterface 
{

	public function getUser($id)	
	{
		$user;
		try {
			$user = \App\User::where('id', $id)->first();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $user;
	}

	public function getIDFromName($name)
	{
		$id = 0;
		try {
			$id = \App\User::where('phone', $name)->select('id')->first();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $id;
	}

	public function getUsers($role, $random=null)
	{
		$users;
		try {
			if($random != NULL)
			{
				$users = \App\User::where('role', $role)
					   ->join('states', 'states.id', 'users.state')
					   ->join('l_g_as', 'l_g_as.id', 'users.lga')
					   ->select('users.*', 'states.state', 'l_g_as.lga')
					   ->inRandomOrder()->take(10)->get();
			}
			else
			{
				$users = \App\User::where('role', $role)->get();
			}
		} catch(\Exception $ex) {
			return $ex;
		}
		return $users;
	}

	public function isFollowing($uid, $fid)
	{
		$isFollowing = 0;
		try {
			$user = \App\User::where('id', $fid)->first();
			if($user['role'] == 1)
			{
				$following = \App\FriendRequest::where('uid', $data['uid'])->where('fid', $data['fid'])->first();
			}
			else
			{
				$following = \App\Follow::where('uid', $uid)->where('fid', $fid)->first();
			}
			if(count($following) > 0)
			{
				$isFollowing = 1;
			}
		} catch(\Exception $ex) {
			return $ex;
		}
		return $isFollowing;
	}

	public function follow(array $data)
	{
		$status = 0;
		try {
			$user = \App\User::where('id', $data['fid'])->first();
			if($user['role'] == 1)
			{
				$follow = \App\FriendRequest::where('uid', $data['uid'])->where('fid', $data['fid'])->first();
				if(count($follow) <= 0)
				{
					$follow = \App\FriendRequest::create($data);
				}
				$status = 2;
			}
			else
			{
				$follow = \App\Follow::create($data);
				$status = 1;
			}
		} catch(\Exception $ex) {
			return $ex;
		}
		return $status;
	}

	public function updateCloutName($id, $gclout_name)
	{
		$status = 0;
		try {
			$update = \App\User::where('id', $id)->update([
				'gclout_name' => $gclout_name
				]);
			$status = 1;
		} catch(\Exception $ex) {
			return $ex;
		}
		return $status;
	}

	public function updateImage($id, $imagename)
	{
		$status = 0;
		try {
			$update = \App\User::where('id', $id)->update([
				'image'	=> $imagename
				]);
			$status = 1;
		} catch(\Exception $ex) {
			return $ex;
		}
		return $status;
	}

	public function updateCoverPhoto($id, $coverPhoto)
	{
		$status = 0;
		try {
			$update = \App\User::where('id', $id)->update([
				'cover_image'	=>	$coverPhoto
				]);
			$status = 1;
		} catch(\Exception $ex) {
			return $ex;
		}
		return $status;
	}

	public function updateUserLogon($uid)
	{
		$status = 0;
		try {
			$update = \App\User::where('id', $uid)->update(['login_total' => 2]);
			$status = 1;
		} catch(\Exception $ex) {
			return $ex;
		}
		return $status;
	}

	public function getUserExperience($uid, $records)
	{
		$experience;
		try {
			$experience = \App\CloutExperience::where('uid', $uid)->take($records)->orderBy('created_at', 'desc')->get();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $experience;
	}

	public function getUserEducation($uid, $records)
	{
		$education;
		try {
			$education = \App\CloutEducation::where('uid', $uid)->take($records)->orderBy('created_at', 'desc')->get();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $education;
	}

	public function getFollowers($uid, $records)
	{
		$followers;
		try {
			$followers = \App\Follow::where('uid', $uid)->take($records)->orderBy('created_at', 'desc')->get();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $followers;
	}

	public function getFollowersCount($uid)
	{
		$followers = 0;
		try {
			$followers = \App\Follow::where('fid', $uid)->count();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $followers;
	}

	public function getFollowing($uid, $id)
	{
		$following;
		try {
			if($id == 'all')
			{
				$following = \App\Following::all();
			}
			else if($id == 'paginate') 
			{
				$following = \App\Following::paginate(33);
			}
		} catch(\Exception $ex) {
			return $ex;
		}
		return $following;
	}

	public function getFollowingCount($uid)
	{
		$following = 0;
		try {
			$following = \App\Follow::where('uid', $uid)->count();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $following;
	}

	public function findUserByAtName($at_name) {
		$user;
		try {
			$user = \App\User::where('at_name', $at_name)->first();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $user;
	}

	public function getPresident() {
		$president;
		try {
			$president = \App\User::where('role', 2)->first();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $president;
	}

	public function searchForClout($needle) {
		$result;
		try {
			$result = \App\User::where('name', 'LIKE', '%' . $needle . '%')->paginate(20);
		} catch(\Exception $ex) {
			return $ex;
		}
		return $result;
	}
}