<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

use App\Repositories\Interfaces\PostInterface;

class PostRepo implements PostInterface 
{
	public function getPost($id, $uid = null)
	{
		$post;
		try {
			if($id == 'paginate')
			{
				$post = DB::table('posts')
				->leftJoin('users', 'users.id', 'posts.uid')
				->leftJoin('follows', 'users.id', 'follows.uid')
				->where('follows.uid', 'posts.uid')
				->select('users.name', 'users.image', 'posts.*')
				->take(5)
				->orderBy('posts.created_at', 'desc')
				->paginate(10);
			}
			else if($id == 'infinite')
			{
				$post = DB::table('posts')
				->leftJoin('users', 'users.id', 'posts.uid')
				->select('users.name', 'users.image', 'posts.*')
				->where('posts.uid', $uid)
				->orderBy('posts.created_at', 'desc')
				->take(10)
				->get();
			}
			else
			{
				$post = \App\Post::where('id', $id)->get();
			}
		} catch(\Exception $ex) {
			return $ex;
		}
		return $post;
	}

	public function setPost(array $data)
	{
		$post;
		$postStatus = 0;
		try {
			$post = \App\Post::create($data);
			$postStatus = 1;
		} catch(\Exception $ex) {
			return $ex;
		}
		return $post;
	}

	public function savePostPhoto(array $data) {
		$save = 0;
		try {
			$photo = \App\PostPhoto::firstOrCreate($data);
			$save = 1;
		} catch(\Exception $ex) {
			return $ex;
		}
		return $save;
	}

	public function getMorePost($id)
	{
		$post;
		try {
			$next = $id + 5;
			$post = DB::table('posts')->whereBetween('id', array($id, $next))->latest()->get();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $post;
	}

	public function getPersonalPost($uid) {
		$post;
		try {
			$post = \App\Post::where('uid', $uid)->latest()->paginate(20);
		} catch(\Exception $ex) {
			return $ex;
		}
		return $post;
	}

	public function getPostPhotos($uid) {
		$photos;
		try {
			$photos = \DB::table('posts')
					->where('uid', $uid)
					->select('photo')
					->latest()
					->paginate(20);
		} catch(\Exception $ex) {
			return $ex;
		}
		return $photos;
	}

	public function getPostPhotosCount($uid) {
		$photos;
		try {
			$photos = \DB::table('posts')
					->where('uid', $uid)
					->where('photo', '<>', NULL)
					->select('photo')
					->count();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $photos;
	}

	public function sharePost($data) {
		$sharePost = 0;
		try {
			$process = \App\SharedPost::firstOrCreate($data);
			if($process['id']) {
				$sharePost = 1;
			}
		} catch(\Exception $ex) {
			return $ex;
		}
		return $sharePost;
	}

	public function deletePost($uid, $pid) {
		$delete = 0;
		try {
			$delete = \App\Post::where('uid', $uid)->where('id', $pid)->delete();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $delete;
	}
}