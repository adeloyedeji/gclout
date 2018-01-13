<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

use App\Repositories\Interfaces\NotificationInterface;

class NotificationRepo implements NotificationInterface 
{

	public function all()
	{
		
	}
	
	public function myNotifications($id, $paginate = 10)
	{
		$myNotifications = 0;
		try {
			if($paginate == 'home') {
				$myNotifications = \DB::table('notifications')
				->leftJoin('users', 'notifications.affected_user_id', '=', 'users.id')
				->where('notifications.status', 0)
				->where('notifications.affected_user_id', \Auth::user()->id)
				->orWhere('notifications.user_id', \Auth::user()->id)
				->select('notifications.*', 'users.name', 'users.image', 'users.at_name')
				->latest()
				->paginate(5);
			} else {
				$myNotifications = \DB::table('notifications')
				->leftJoin('users', 'notifications.affected_user_id', '=', 'users.id')
				->where('notifications.status', 0)
				->where('notifications.affected_user_id', \Auth::user()->id)
				->orWhere('notifications.user_id', \Auth::user()->id)
				->select('notifications.*', 'users.name', 'users.image', 'users.at_name')
				->latest()
				->paginate($paginate);
			}
		} catch(\Exception $ex) {
			return $ex;
		}
		return $myNotifications;
	}

	public function myNotificationsCount($id)
	{
		$myNotificationsCount = 0;
		try {
			$myNotificationsCount = \App\Notification::where('affected_user_id', $id)
								  ->where('status', 0)
								  ->count();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $myNotificationsCount;
	}

	public function updateNotification($uid, $fid) {
		$update = 0;
		try {
			$update = \App\Notification::where('user_id', $uid)
					->where('affected_user_id', $fid)
					->where('event_id', 1)
					->update(['status' => 1]);
		} catch(\Exception $ex) {
			return $ex;
		}
		return $update;
	}
}
