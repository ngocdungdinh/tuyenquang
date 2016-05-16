<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class Notification extends Eloquent {

	public static function addNotification($sender, $sender_id, $recipient_id, $noti_id, $item_id, $item_title, $item_type, $url, $people = 0, $read = 0)
	{

		$user = Sentry::getUser();

		if($user->id != $recipient_id) {
			$exist_noti = Notification::select('*')
				->where('notifications.item_id', $item_id)
				->where('notifications.item_type', $item_type)
				->where('notifications.noti_id', $noti_id)
				->first();

			if(!is_null($exist_noti)) {
				$exist_noti->sender = $user->fullName();
				$exist_noti->sender_id = $user->id;
				$exist_noti->people = $exist_noti->people + 1;
				$exist_noti->item_title = $item_title;
				$exist_noti->url = $url;
				$exist_noti->read = 0;
				$exist_noti->save();
			} else {
				$notifications = new Notification;
				$notifications->sender = $user->fullName();
				$notifications->sender_id = $user->id;
				$notifications->item_id = $item_id;
				$notifications->item_title = $item_title;
				$notifications->noti_id = $noti_id;
				$notifications->item_type = $item_type;
				$notifications->recipient_id = $recipient_id;
				$notifications->url = $url;
				$notifications->people = $people;
				$notifications->save();
			}

			// update user count noti
			$profile = User::find($recipient_id);
			$profile->increment('notifications');
		}
	}
}