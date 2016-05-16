<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class Authentication extends Eloquent {

	/**
	 *
	 *
	 * @return
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}

}
