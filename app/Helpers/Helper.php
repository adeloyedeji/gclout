<?php

namespace App\Helpers;

use App\Repositories\Interfaces\UtilityInterface;

class Helper 
{

	public static function getNotificationCount($id)
	{
		$notificationCount = app('App\Http\Controllers\NotificationController')->getNotificationCount($id);

		return $notificationCount;
	}

	public static function getStates($id)
	{
		if($id == 'all') {
			$states = \App\State::all();
		} else {
			$states = \App\State::find($id);
		}

		return $states;

	}

	public static function getStateLGA($state_id)
	{
		if($id == 'all') {
			$lgas = \App\LGA::all();
		}
		else if($id == 'paginate') {
			$lgas = \App\LGA::paginate(10);
		}
		else {
			$lgas = \App\LGA::where('state_id', $id)->get();
		}

		return $lgas;
	}

	public static function getAccountType($id)
	{
		$accountType = app('App\Http\Controllers\UtilityController')->getUserAccountType($id);

		return $accountType;
	}

	public static function uniqidReal($lenght = 13) 
	{
		if (function_exists("random_bytes")) {
			$bytes = random_bytes(ceil($lenght / 2));
		} elseif (function_exists("openssl_random_pseudo_bytes")) {
			$bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
		} else {
			$bytes = $this->uniqidReal();
			throw new Exception("no cryptographically secure random function available");
		}
		return substr(bin2hex($bytes), 0, $lenght);
	}

	public static function getMonthName($id)
	{
		$monthName;
		switch($id)
		{
			case 1:
			$monthName = "Jan";
			break;
			case 2:
			$monthName = "Feb";
			break;
			case 3:
			$monthName = "Mar";
			break;
			case 4: 
			$monthName = "Apr";
			break;
			case 5:
			$monthName = "May";
			break;
			case 6:
			$monthName = "June";
			break;
			case 7:
			$monthName = "Jul";
			break;
			case 8:
			$monthName = "Aug";
			break;
			case 9: 
			$monthName = "Sep";
			break;
			case 10:
			$monthName = "Oct";
			break;
			case 11:
			$monthName = "Nov";
			break;
			case 12:
			$monthName = "Dec";
			break;
		}
		return $monthName;
	}

	public static function getLgaName($lgaId)
	{
		$lga = app('App\Http\Controllers\UtilityController')->getLga($lgaId);

		return $lga;
	}

	public static function getState($sId)
	{
		if($sId == 'all') {
			$state = \App\State::all();
		} else {
			$state = \App\State::find($sId);
		}

		return $state;
	}

	public static function getStreetName($uid)
	{
		$streetName = app('App\Http\Controllers\UtilityController')->getStreet($uid);

		return $streetName;
	}

	public static function getWard($uid)
	{
		$ward = app('App\Http\Controllers\UtilityController')->getWard($uid);

		return $ward;
	}

	public static function getCountries($id) {
		if($id == 'all') {
			$countries = \App\Country::all();
		} else {
			$countries = \App\Country::find($id);
		}

		return $countries;
	}

	public static function getFriendSuggestion($state_id) {
		$friend_suggestion = app('App\Http\Controllers\FriendController')->getSuggestedFriends($state_id);
			
		return $friend_suggestion;
	}

	public static function getPresident() {
		$president = \App\Profile::where('role', 2)->first();

		return $president;
	}

	public static function getLeadersPhoto($state, $role) {
		$leader = \DB::table("users")
		->join("states",function($join){
			$join->on("users.state","=","states.id")
				->where([["users.state","=",'$state'],["users.role","=",'$role']]);
		})
		->select("users.name","users.image", "users.at_name")
		->first();
		return $leader;
	}

	public static function getFriendsFromFriendRequest($uid) {
		$friends = app('App\Http\Controllers\FriendController')->getFriendsFromFriendRequest($uid);

		return $friends;
	}

}