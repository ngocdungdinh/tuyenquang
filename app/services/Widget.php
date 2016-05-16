<?php namespace App\Services;

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */
 
use Config, File, Log, Sentry, User, Notification, Activity, View;
 
class Widget {
	public function getView($widget) {
		$wdata = json_decode($widget->content);
		return View::make('widgets/'.$widget->form.'/view', compact('widget', 'wdata'));
	}
}