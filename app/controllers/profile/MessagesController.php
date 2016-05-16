<?php namespace Controllers\Profile;

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

use BaseController;
use Redirect;
use User;
use Lang;
use Conversation;
use ConversationReply;
use Validator;
use View;
use Sentry;
use Input;
use Jinput;
use Carbon;
use Str;
use cURL;
use Config;
use DB;

class MessagesController extends BaseController {

	public function getIndex()
	{
		$user_one = $this->data['u'];
		$conversations = DB::select("SELECT u.id, u.username, u.avatar, u.first_name, u.last_name, c.*
			FROM conversations c, users u
			WHERE CASE 
				WHEN c.user_one = '$user_one->id'
				THEN c.user_two = u.id
				WHEN c.user_two = '$user_one->id'
				THEN c.user_one= u.id
				END 
			AND (
				c.user_one ='$user_one->id'
				OR c.user_two ='$user_one->id'
			)
			Order by c.updated_at DESC Limit 30
		");

		$this->data['conversations'] = $conversations;
		return View::make('frontend/profile/messages', $this->data);
	}

	public function getAjaxMessages()
	{
		$user_one = $this->data['u'];
		$conversations = DB::select("SELECT u.id, u.username, u.avatar, u.first_name, u.last_name, c.*
			FROM conversations c, users u
			WHERE CASE 
				WHEN c.user_one = '$user_one->id'
				THEN c.user_two = u.id
				WHEN c.user_two = '$user_one->id'
				THEN c.user_one= u.id
				END 
			AND (
				c.user_one ='$user_one->id'
				OR c.user_two ='$user_one->id'
			)
			Order by c.updated_at DESC Limit 10
		");

		$this->data['conversations'] = $conversations;
		return View::make('frontend/profile/ajax_messages', $this->data);
	}

	public function getMessages($cId)
	{
		$user_one = $this->data['u'];

		// get messages in conversation
		$messages = ConversationReply::select('users.username', 'users.first_name', 'users.last_name', 'users.avatar', 'users.gender', 'users.location', 'conversation_reply.*', 'conversation_reply.*')
			->join('users', 'users.id', '=', 'conversation_reply.user_id_fk')
			->join('conversations', 'conversations.c_id', '=', 'conversation_reply.c_id_fk')
			->whereRaw("(conversations.user_one='$user_one->id' or conversations.user_two='$user_one->id')")
			->where('conversation_reply.c_id_fk', $cId)
			->take(50)
			->get();

		if(is_null($messages))
			return Redirect::to('profile/messages')->with('error', Lang::get('admin/messages/message.create.error'));

		$conversations = DB::select("SELECT u.id, u.username, u.avatar, u.first_name, u.last_name, c.*
			FROM conversations c, users u
			WHERE CASE 
				WHEN c.user_one = '$user_one->id'
				THEN c.user_two = u.id
				WHEN c.user_two = '$user_one->id'
				THEN c.user_one= u.id
				END 
			AND (
				c.user_one ='$user_one->id'
				OR c.user_two ='$user_one->id'
			)
			Order by c.updated_at DESC Limit 30
		");

		$this->data['conversations'] = $conversations;


		$currentCon = Conversation::where('c_id', $cId)->first();

		if($currentCon->user_one == $user_one->id) {
			$currentCon->one_read = 1;
		} else {
			$currentCon->two_read = 1;
		}

		$currentCon->save();

		$user_one->has_msg = $user_one->has_msg > 0 ?  $user_one->has_msg - 1 : 0;
		$user_one->save();

		$this->data['toUser'] = $user_one->id == $currentCon->user_one ? $currentCon->user_two : $currentCon->user_one;
		$this->data['messages'] = $messages;
		$this->data['cId'] = $cId;
		return View::make('frontend/profile/messages', $this->data);
	}


	// public function getCompose()
	// {
	// 	// check login and exist conversations
	// 	if(!Sentry::check())
	// 		return Redirect::to('profile/messages')->with('error', Lang::get('admin/messages/message.create.error'));

	// 	return View::make('frontend/profile/compose', $this->data);
	// }

	public function getCompose($pId = null)
	{
		// check login and exist conversations
		if(!Sentry::check())
			return Redirect::to('profile/messages')->with('error', Lang::get('admin/messages/message.create.error'));

		$this->data['user_two'] = $user_two = User::find($pId);

		if(is_null($user_two))
			return Redirect::to('profile/messages')->with('error', Lang::get('admin/messages/message.create.error'));

		return View::make('frontend/profile/compose', $this->data);
	}

	public function postCompose()
	{
		// check login and exist conversations
		if(!Sentry::check())
			return Redirect::to('profile/messages')->with('error', Lang::get('admin/messages/message.create.error'));

		$user_one = $this->data['u'];
		$receipt_id = e(Jinput::get('receipt_id', 0));
		$user_two = User::find($receipt_id);

		if(is_null($user_two))
			return Redirect::to('profile/messages')->with('error', Lang::get('admin/messages/message.create.error'));

		// Declare the rules for the form validation
		$rules = array(
			'content'   	=> 'required'
		);
		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
	  		return json_encode(array('status' => 0, 'msg' => 'Dữ liệu không hợp lệ!'));
		}

		$conversation = Conversation::select('conversations.*')
			->whereRaw("(user_one='$user_one->id' and user_two='$user_two->id') or (user_one='$user_two->id' and user_two='$user_one->id')")
			->first();

		if(is_null($conversation))
		{
			$conversation = new Conversation;
			$conversation->user_one = $user_one->id;
			$conversation->one_read = 1;
			$conversation->two_read = 0;
			$conversation->user_two = $user_two->id;
			$conversation->last_msg = Str::words(strip_tags(Jinput::get('content')), 10);
			$conversation->save();
			$conversation->c_id;
		} else {
			$conversation->last_msg = Str::words(strip_tags(Jinput::get('content')), 10);
			if($conversation->user_one == $user_one->id) {
				$conversation->one_read = 1;
				$conversation->two_read = 0;
			} else {
				$conversation->one_read = 0;
				$conversation->two_read = 1;
			}
			$conversation->save();
		}
		// insert body message
		$cr = new ConversationReply;
		$cr->user_id_fk = $user_one->id;
		$cr->reply 	= Jinput::get('content');
		$cr->c_id_fk 	= $conversation->c_id;
		$cr->save();

		$user_two->has_msg = $user_two->has_msg + 1;
		$user_two->save();

		// push notis
		// $pustData = array(
		// 	'user' => $user_two->username,
		// 	'userid' => $user_two->id,
		// 	'from_user' => $user_one->username,
		// 	'type' => 'message',
		// 	'msg' => $cr->reply,
		// 	// 'content' => $cr->toArray()
		// );
  //   	cURL::post(Config::get('app.nodejs_url') . "/notify", $pustData);

		return Redirect::to('profile/messages/'.$conversation->c_id);
	}

	public function postAjaxCompose()
	{

	}
}