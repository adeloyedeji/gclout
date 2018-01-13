<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

use App\Repositories\Interfaces\MovementInterface;

class MovementRepo implements MovementInterface 
{
	public function store(array $data)
	{
		$movementStatus = 0;
		try {
			$movement = \App\Movement::create($data);
			$movementStatus = 1;
		} catch(\Exception $ex) {
			return $ex;
		}
		return $movementStatus;
	}

	public function getMovement($id)
	{
		$movements;
		try {
			if($id == 'all')
			{
				$movements = \App\Movement::all();
			}
			else if($id == 'paginate')
			{
				$movements = \App\Movement::paginate(10);
			}
			else
			{
				$movements = \App\Movement::where('id', $id)->first();
			}
		} catch(\Exception $ex) {
			return $ex;
		}
		return $movements;
	}

	public function randomMovements()
	{
		$movements;
		try {
			$movements = \App\Movement::inRandomOrder()->take(5)->get();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $movements;
	}
}