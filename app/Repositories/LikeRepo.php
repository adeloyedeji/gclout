<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

use App\Repositories\Interfaces\LikeInterface;

class LikeRepo implements LikeInterface
{
	public function likePost(array $data)
	{
		$likePost;
		$totalLikes = ['message' => 'not recorded', 'total' => 0];
		try {
			$likePost = \App\Like::where('pid', $data['pid'])->where('uid', $data['uid'])->first();
			if($likePost === null)
			{
				$likePost = \App\Like::create($data);
				if($likePost['id'])
				{
					$totalLikes['total'] = \App\Like::where('pid', $data['pid'])->count();
					$totalLikes['message'] = 'recorded';
				}
			}
			else
			{
				//dislike post
				$likePost = \App\Like::where('pid',$data['pid'])->where('uid', $data['uid'])->delete();

				$totalLikes['total'] = \App\Like::where('pid', $data['pid'])->count();

				$totalLikes['message'] = 'recorded';
			}
		} catch(\Exception $ex) {
			return $ex;
		}
		return $totalLikes;
	}

	public function getLikesCount($pid)
	{
		$likes = 0;
		try {
			$likes = \App\Like::where('pid', $pid)->count();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $likes;
	}

	public function getMeLike($pid, $uid)
	{
		$likes = 0;
		try {
			$likes = \App\Like::where('pid', $pid)->where('uid', $uid)->count();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $likes;
	}
}