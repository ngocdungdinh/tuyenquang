<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class NotificationsController extends AuthController {

	public function getAjax()
	{
		$this->data['notifications'] = $notifications = Notification::select('notifications.read', 'notifications.item_type', 'notifications.noti_id', 'notifications.people', 'notifications.url', 'notifications.created_at', 'notifications.updated_at', 'notifications.item_title', 'notification_type.name', 'users.avatar', 'users.username', 'users.first_name', 'users.last_name')
			->join('notification_type', 'notification_type.id', '=', 'notifications.noti_id')
			->join('users', 'users.id', '=', 'notifications.sender_id')
			->where('notifications.recipient_id', $this->u->id)
			->orderBy('notifications.updated_at', 'desc')
			->take(10)->get();
			
		Notification::where('recipient_id', $this->u->id)->update(array('read' => 1));

		$this->u->notifications = 0;
		$this->u->save();
		return View::make('frontend/profile/notifications', $this->data);
		// current id
	}
}