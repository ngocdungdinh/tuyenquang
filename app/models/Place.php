<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class Place extends Eloquent {
	/**
	 * Return the URL to the post.
	 *
	 * @return string
	 */
	public function url()
	{
		return URL::route('view-place', $this->slug);
	}

	public function subplaces()
	{
		return $this->hasMany('Place', "parent_id", "id");
	}

	public function followers()
	{
		return $this->belongsToMany('User','user_place','place_id','user_id');
	}
}