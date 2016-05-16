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
use Input;
use Jinput;
use Activity;
use Place;
use EventPlace;
use Post;
use Lang;
use Validator;
use View;
use Sentry;
use Clib;


class ActivityController extends BaseController {

	public function getActivity()
	{

	}

	public function postActivity()
	{

		if ( is_null($this->u) )
	  		return json_encode(array('status' => 0, 'msg' => 'Bạn không đủ quyền hạn!'));


		// Declare the rules for the form validation
		$rules = array(
			'type'   	=> 'required|min:3'
		);
		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
	  		return json_encode(array('status' => 0, 'msg' => 'Dữ liệu không hợp lệ!'));
		}
		$place_id 	= e(Jinput::get('place_id', 0));
		$event_id 	= e(Jinput::get('event_id', 0));
		$post_id 	= e(Jinput::get('post_id', 0));
		$act_id 	= e(Jinput::get('act_id', 0));
		$type = e(Jinput::get('type'));

		if($event_id)
		{
			$event = EventPlace::find($event_id);
			if(is_null($event))
	  			return json_encode(array('status' => 0, 'msg' => 'Dữ liệu không hợp lệ!'));

			if($type == 'like')
			{
				$exist = Activity::where('event_id', $event_id)->where('act_type', '=', 'like')->where('user_id', $this->u->id)->first();
				if(!is_null($exist))
				{
	  				$exist->delete();
					$event->activities = $event->activities - 1;
					$event->save();
	  				return json_encode(array('status' => 0, 'msg' => 'Bỏ like thành công!'));
				} else {
	  				$event->activities = $event->activities + 1;
				}

			} else if($type == 'comment') {
				$event->activities = $event->activities + 1;
			} else {
				$exist = Activity::where('event_id', $event_id)->where('act_type', '=', $type)->where('user_id', $this->u->id)->first();
				if(is_null($exist))
					$event->activities = $event->activities + 1;
				else
					$exist->delete();
			}
			$event->save();
		}

		if($post_id)
		{
			$post = Post::find($post_id);
			if(is_null($post))
	  			return json_encode(array('status' => 0, 'msg' => 'Dữ liệu không hợp lệ!'));

			if($type == 'like')
			{
				$exist = Activity::where('post_id', $post_id)->where('act_type', '=', $type)->where('user_id', $this->u->id)->first();
				if(!is_null($exist))
				{
	  				$exist->delete();
					$post->activities = $post->activities - 1;
					$post->save();

					$this->u->statistic->us_like_posts = $this->u->statistic->us_like_posts - 1;
					$this->u->statistic->save();

	  				return json_encode(array('status' => 1, 'msg' => 'Bỏ like thành công!'));
				} else {
					$this->u->statistic->us_like_posts = $this->u->statistic->us_like_posts + 1;
					$this->u->statistic->save();

					$post->activities = $post->activities + 1;
				}
			} else {
	  			$post->activities = $post->activities + 1;
			}

			$post->save();
		}

		if($place_id && is_null(Place::find($place_id)))
		{
	  		return json_encode(array('status' => 0, 'msg' => 'Dữ liệu không hợp lệ!'));
		}

		$activity = new Activity;
		$activity->place_id = $place_id;
		$activity->event_id = $event_id;
		$activity->post_id = $post_id;
		$activity->parent_id = $act_id;
		$activity->act_type = $type;
		$activity->content = Jinput::get('content', '');
		$activity->user_id = $this->u->id;
		$activity->save();

		// add notifications
		if(!isset($exist) || is_null($exist)) {
			$recipient_id 	= isset($event) ? $event->user_id : $post->user_id;
			$item_id 		= isset($event) ? $event->id : $post->id;
			$item_title 	= isset($event) ? $event->title : $post->title;
			$item_type 		= isset($event) ? 'event' : 'post';
			$url 			= isset($event) ? '/event/'.$event->slug : '/post/'.$post->id;
			$noti_id 		= $type == 'like' ? 1 : 2;
			$sender 		= $this->u->fullName();
			Clib::addNotification($sender, $this->u->id, $recipient_id, $noti_id, $item_id, $item_title, $item_type, $url);
		}
		$activity->user_avatar = $this->u->avatar;
		$activity->user_full_name = $this->u->first_name.' '.$this->u->last_name;
		return $activity->toJson();
	}
}