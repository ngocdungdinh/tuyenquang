<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class Menu extends Eloquent {

	public static function position($position)
	{
		return Menu::where('position', $position)->first();
	}
	
    public function mlinks()
    {
        return $this->hasMany('MenuLink',"menu_id")->where('parent_id', 0)->orderBy('position', 'ASC');
    }
    
}