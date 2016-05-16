<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class Widget extends Eloquent {
	public function wf() {
		if($this->content) {
			return json_decode($this->content);
		}
	}
}