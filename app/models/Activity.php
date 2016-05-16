<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class Activity extends Eloquent {

	static $user_id;
	static $item_id;

	public function post()
	{
		return $this->belongsTo('Post', 'post_id');
	}

	public static function addActivity($user_id, $item_id, $item_type, $item_parent_id, $act_type_id, $title, $url, $content)
	{
		$activity = new Activity;
		$activity->user_id = $user_id;
		$activity->item_id = $item_id;
		$activity->item_type = $item_type;
		$activity->item_parent_id = $item_parent_id;
		$activity->act_type_id = $act_type_id;
		$activity->title = $title;
		$activity->url = $url;
		$activity->content = $content;
		$activity->save();

		// notifications for owner user
		if($item_type == 'post')
		{
			$item = Post::find($item_id);
			$url = '/admin/news/'.$item_id.'/edit';
		} elseif($item_type == 'handbook') {
			$item = HbContent::find($item_id);
			$url = '/admin/handbooks/contents/'.$item_id.'/edit';
		}
		if(!is_null($item) && ($item->user_id != $user_id)) {
			Notification::addNotification(Sentry::getUser(), Sentry::getId(), $item->user_id, $act_type_id, $item->id, $item->title, $item_type, $url);
		}

		return $activity;
	}

	public static function getActivities($user_id = null, $item_id = null)
	{
		self::$user_id = $user_id;
		self::$item_id = $item_id;
		$activities = Activity::select('activities.id', 'activities.item_parent_id', 'activities.item_id', 'activities.item_type', 'activities.user_id', 'activities.act_type_id', 'activities.title', 'activities.url', 'activities.content', 'posts_versions.publish_date', 'users.avatar', 'users.first_name', 'users.last_name', 'users.username', 'activities.created_at', 'notification_type.icon', 'notification_type.name')
			->join('users', 'users.id', '=', 'activities.user_id')
			->join('posts', 'posts.id', '=', 'activities.item_id')
			->join('posts_versions', 'posts_versions.post_id', '=', 'activities.item_id')
			->join('notification_type', 'activities.act_type_id', '=', 'notification_type.id')
			->where(function($query){
				if (Sentry::getUser()->hasAnyAccess(['activities','activities.ownpost'])) {
					$query->where('posts.user_id', '=', Sentry::getId());
				}
				if(self::$item_id)
					$query->where('activities.item_id', '=', self::$item_id);
			})
			->groupBy('activities.id')
			->orderByRaw('IF(activities.item_parent_id = 0, activities.id, activities.item_parent_id) DESC');
		return $activities;
	}
}