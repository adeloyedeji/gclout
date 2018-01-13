<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

use App\Repositories\Interfaces\EventInterface;

class EventRepo implements EventInterface 
{
	
	public function createEvent(array $data)	
	{
		$event;
		try {
			$event = \App\Events::create($data);
		} catch(\Exception $ex) {
			return $ex;
		}
		return $event;
	}
}
