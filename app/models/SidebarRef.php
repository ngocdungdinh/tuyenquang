<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class SidebarRef extends Eloquent {
	
	protected $table = 'sidebars_refs';
	
    public function seoble()
    {
        return $this->morphTo();
    }
 
}