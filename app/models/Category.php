<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class Category extends Eloquent {

    public function subscategories()
    {
        return $this->hasMany('Category', "parent_id", "id");
    }

    public function subshomecats()
    {
        return $this->hasMany('Category', "parent_id", "id")->where('showon_homepage', '>', 0)->remember(60)->orderBy('showon_menu', 'ASC');
    }

    public function parent()
    {
        return $this->hasOne('Category', "id", "parent_id");
    }

    public function posts()
    {
        return $this->hasMany('Post',"category_id");
    }

	public function rposts() {
		return $this->belongsToMany('Post','category_post','category_id','post_id');
	}
    
    public function seo() {
      return $this->morphMany('Seo', 'seoble');
    }

    public function sidebars() {
      return $this->morphMany('SidebarRef', 'seoble')->join('sidebars', 'sidebars.id', '=', 'sidebars_refs.sidebar_id')->select('*', 'sidebars_refs.id as srid');
    }

    public function widgets($sidebar_code, $refresh = false) {
        if ($sidebar_code) {
            $sidebar = Sidebar::where('code', $sidebar_code)->first();
            if(!is_null($sidebar)) {
                $key = 'sidebar-'.$sidebar->id.'-'.$sidebar_code;
                if(!Cache::has($key) || $refresh) {
                // } elseif(!Cache::has($key) && App::environment() != 'local' && Config::get('app.debug') != 'true') {

                    $dataCache = "";
                    // if($sidebar->widgets()->count()) {
                        foreach($sidebar->widgets as $w) {
                            $dataCache .= SWidget::getView($w);
                        }
                    // }
                    Cache::put($key, $dataCache, 15);
                }
                return Cache::get($key);
            } else {
                return '';
            }
        }
    }
    public function widgetsByPosition($position) {
        if ($position) {
            $sidebar = Sidebar::select('sidebars.*', 'sidebars_refs.id as srid')->join('sidebars_refs', 'sidebars.id', '=', 'sidebars_refs.sidebar_id')->where('sidebars_refs.seoble_id', $this->id)->where('sidebars.position', $position)->first();
            if (is_null($sidebar)) {
                // $sidebar default
                $sidebar = Sidebar::select('sidebars.*', 'sidebars_refs.id as srid')->join('sidebars_refs', 'sidebars.id', '=', 'sidebars_refs.sidebar_id')->where('sidebars_refs.seoble_id', $this->id)->where('sidebars.position', 'default')->first();
            }
            if(!is_null($sidebar))
                return $sidebar->widgets;
        }
    }
}