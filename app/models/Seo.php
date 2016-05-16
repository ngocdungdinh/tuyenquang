<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class Seo extends Eloquent {
	
    public function seoble()
    {
        return $this->morphTo();
    }
 
    public function updateFromInput()
    {
    	$this->title 	 	= e(Input::get('seo_title'));
    	$this->description 	= e(Input::get('seo_description'));
    	$this->keywords  	= e(Input::get('seo_keywords'));
    	$this->save();
    	return true;
    }
}