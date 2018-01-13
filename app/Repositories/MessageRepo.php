<?php

namespace App\Repositories;

use App\Repositories\Interfaces\MessageInterface;

class MessageRepo implements MessageInterface
{
	public function getMessagesCount($uid)
	{
		$count;
		try {
			$count = \App\Message::where('cid', $uid)->count();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $count;
	}

	public function getMessages($uid)
	{
		$messages;
		try {
			$messages = \App\Message::where('cid', $uid)->paginate(10);
		} catch(\Exception $ex) {
			return $ex;
		}
		return $messages;
	}

	public function getChatMessages($sid, $cid) {
		$messages;
		try {
			$messages = \App\Message::where('sid', $sid)
						->where('cid', $cid)
						->orWhere('sid', $cid)
						->orWhere('cid', $sid)
						->latest()
						->take(20)
						->get();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $messages;
	}

	public function saveChat(array $data) {
		$save;
		try {
			$save = \App\Message::firstOrCreate($data);
		} catch(\Exception $ex) {
			return $ex;
		}
		return $save;
	}

	public function getChatSession($sid, $cid) {
		$chat_session;
		try {
			$chat_session = \App\ChatSession::where('sid', $sid)
							->where('cid', $cid)
							->orWhere('sid', $cid)
							->orWhere('cid', $sid)
							->first();
		} catch(\Exception $ex) {
			return $ex;
		}
		return $chat_session;
	}

	public function setChatSession(array $data) {
		$chat_session;
		try {
			$chat_session = \App\ChatSession::firstOrCreate($data);
		} catch(\Exception $ex) {
			return $ex;
		}
		return $chat_session;
	}
}