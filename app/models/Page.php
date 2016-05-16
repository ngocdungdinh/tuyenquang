<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class Page extends Eloquent {	

	/**
	 * Return the URL to the post.
	 *
	 * @return string
	 */
	public function url()
	{
		return URL::route('page', $this->slug);
	}

	/**
	 * Returns a formatted post content entry, this ensures that
	 * line breaks are returned.
	 *
	 * @return string
	 */
	public function content()
	{
		return $this->content;
	}

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