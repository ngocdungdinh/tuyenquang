<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class UserPlace extends Eloquent {
	
	protected $table = 'user_place';

	public static function existfollow($placeId) {
		if(!Sentry::check())
			return false;

		$userplace = UserPlace::where('user_id', Sentry::getId())->where('place_id', $placeId)->first();
		if(is_null($userplace))
		{
			return false;
		}

		return true;
	}
}
