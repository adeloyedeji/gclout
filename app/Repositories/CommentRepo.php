<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

use App\Repositories\Interfaces\CommentInterface;

class CommentRepo implements CommentInterface 
{
	
	public function comment(array $data)	
	{
		$comments;
		try {
			$comments = \App\Comment::create($data);
		} catch(\Exception $ex) {
			return $ex;
		}
		return $comments;
	}

	public function getComment($pid)
	{
		$comments;
		try {
			if($pid == 'all') {
				$comments = \App\Comment::paginate(10);
			} else {
				$comments = \App\Comment::where('pid', $pid)->with('user')->get();
			}
		} catch(\Exception $ex) {
			return $ex;
		}
		return $comments;
	}

	public function getCommentsCount($pid)
	{
		$count = 0;
		try {
			$count = \App\Comment::where('pid', $pid)->count();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $count;
	}
}
