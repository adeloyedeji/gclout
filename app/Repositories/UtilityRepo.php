<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

use App\Repositories\Interfaces\UtilityInterface;

class UtilityRepo implements UtilityInterface 
{
	
	public function getUserAccountType()
	{
		$accountType;
		try {
			$accountType = \App\AccountRole::where('id', $id)->first();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $accountType;
	}

	public function getStatesWithGovernor($id) {
		$states;
		try {
			if($id == 'all')
			{
				$states = \DB::table('states')
						->leftJoin('users', 'users.state', '=', 'states.id')
						->where('users.role', '=', 3)
						->select('users.name', 'users.image', 'users.id', 'states.*')
						->all();
			}
			else if($id == 'paginate')
			{
				$states = \DB::table('states')
						->leftJoin('users','users.state', '=', 'states.id')
						->where('users.role', '=', 3)
						->select('users.name', 'users.image', 'users.id', 'states.*')
						->paginate(10);
			}
			else if($id == 'advert') 
			{
				$states = \DB::table('states')
						->leftJoin('users', 'users.state', '=', 'states.id')
						->where('users.role', '=', 3)
						->select('users.name', 'users.image', 'users.id', 'states.*')
						->paginate(3);
			}
			else 
			{
				$states = \DB::table('states')
						->leftJoin('users', 'users.state', '=', 'states.id')
						->where('users.role', '=', 3)
						->where('users.id', $id)
						->select('users.name', 'users.image', 'users.id', 'states.*')
						->first();
			}
		} catch(\Exception $ex) {
			return $ex;
		}
		return $states;
	}

	public function getStates($id)
	{
		$states;
		try {
			if($id == 'all')
			{
				$states = \App\State::all();
			}
			else if($id == 'paginate')
			{
				$states = \App\State::paginate(10);
			}
			else if($id == 'advert') 
			{
				$states = \App\State::inRandomOrder()->skip(0)->take(3)->get();
			}
			else 
			{
				$states = \App\State::where('id', $id)->first();
			}
		} catch(\Exception $ex) {
			return $ex;
		}
		return $states;
	}

	public function getStatesLGA($id)
	{
		$statesLga;
		try {
			if($id == 'all')
			{
				$statesLga = \App\LGA::all();
			}
			else if($id == 'paginate')
			{
				$statesLga = \App\LGA::paginate(10);
			}
			else 
			{
				$statesLga = \App\LGA::where('state_id', $id)->get();
			}
		} catch(\Exception $ex) {
			return $ex;
		}
		return $statesLga;
	}	

	public function getLga($id)
	{
		$lga;
		try {
			$lga = \App\LGA::where('id', $id)->first();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $lga;
	}

	public function getStreet($uid)
	{
		$street;
		try {
			$street = \App\User::where('id', $uid)->select('street')->first();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $street;
	}

	public function getWard($uid)
	{
		$ward;
		try {
			$ward = \App\User::where('id', $uid)->select('ward')->first();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $ward;
	}

	public function getCountries($id) {
		$country;
		try {
			if($id == 'all') {
				$country = \App\Country::all();
			} else {
				$country = \App\Country::where('id', $id)->first();
			}
		} catch(\Exception $ex) {
			return $ex;
		}
		return $country;
	}
}
