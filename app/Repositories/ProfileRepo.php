<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ProfileInterface;

class ProfileRepo implements ProfileInterface
{
	public function updateBasic(array $data)
	{
		$update;
		try {
			$update = \App\User::where('id', $data['id'])->update($data);
		} catch(\Exception $ex) {
			return $ex;
		}
		return $update;
	}

	public function updateContact(array $data) 
	{
		$update;
		try {
			$update = \App\User::where('id', $data['id'])->update($data);
		} catch(\Exception $ex) {
			return $ex;
		}
		return $update;
	}

	public function updateAddress(array $data) 
	{
		$update;
		try {
			$update = \App\User::where('id', $data['id'])->update($data);
		} catch(\Exception $ex) {
			return $ex;
		}
		return $update;
	}

	public function updateOthers(array $data) 
	{
		$update;
		try {
			$update = \App\User::where('id', $data['id'])->update($data);
		} catch(\Exception $ex) {
			return $ex;
		}
		return $update;
	}

	public function getAbout($user_id)
	{
		$about;
		try {
			$about = \App\AboutUser::where('user_id', $user_id)->first();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $about;
	}

	public function updateAboutUser(array $data)
	{
		$saveUpdate;
		try {
			$checkAbout = \App\AboutUser::where('user_id', $data['user_id'])->first();
			$checkAbout ? \App\AboutUser::where('user_id', $data['user_id'])->update($data) : \App\AboutUser::firstOrCreate($data);
			$saveUpdate = 1;
		} catch(\Exception $ex) {
			return $ex;
		}
		return $saveUpdate;
	}

	public function updateUserImage($user_id, $filename)
	{
		$save;
		try{
			$save = \App\User::where('id', $user_id)->update(['image'=>$filename]);
		} catch(\Exception $exe) {
			return $ex;
		}
		return $save;
	}

	public function updateUserCoverPhoto($user_id, $filename)
	{
		$save;
		try{
			$save = \App\User::where('id', $user_id)->update(['cover_image'=>$filename]);
		} catch(\Exception $ex) {
			return $ex;
		}
		return $save;
	}

	public function updateUserPassword($user_id, $password)
	{
		$update;
		try {
			$update = \App\User::where('id', $user_id)->update(['password'=>$password]);
		} catch(\Exception $ex) {
			return $ex;
		}
		return $update;
	}
}