<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class Royalty extends Eloquent {

	/**
	 * Return the post's author.
	 *
	 * @return User
	 */
	
	public function author()
	{
		return $this->belongsTo('User', 'user_id');
	}
}