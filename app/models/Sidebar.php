<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class Sidebar extends Eloquent {

	public function widgets() {
		return $this->belongsToMany('Widget','widgets_refs','item_id','widget_id')
			->select('widgets_refs.*', 'widgets.name', 'widgets.form', 'widgets_refs.id as wrid', 'widgets_refs.status as wrstatus')
			->where('widgets.status', 'on')
			->where('widgets_refs.type', 'sidebar')
			->orderBy('widgets_refs.position', 'asc');
	}
}