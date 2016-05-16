<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class UserFollow extends Eloquent {
	
	protected $table = 'user_follow';

	public static function existfollow($followId) {
		if(!Sentry::check())
			return false;

		$userfollow = UserFollow::where('user_id', Sentry::getId())->where('follow_id', $followId)->first();
		if(is_null($userfollow))
		{
			return false;
		}

		return true;
	}
}
