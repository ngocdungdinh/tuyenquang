<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class MenuLink extends Eloquent {
	
	protected $table = 'menu_links';

    public function sublinks()
    {
        return $this->hasMany('MenuLink', "parent_id", "id")->select('menu_links.*');
    }
}
