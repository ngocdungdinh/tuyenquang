<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showIndex()
	{
		$curr_time = new Datetime;
		$last_week = $curr_time->modify('-'.Config::get('app.backdays').' day');

		$homefolder =  Config::get('app.homefolder');
//		var_dump('<pre>', $homefolder);
//		echo $homefolder['GIOI_THIEU_TINH'];exit;
		
		// Get all the news posts
		$this->data['featured_posts'] = Post::select('posts.*', 'medias.mpath', 'medias.mtype', 'medias.mname')
			->join('medias', 'medias.id', '=', 'posts.media_id')
        	->join('posts_position', 'posts_position.post_id', '=', 'posts.id')
			->where('posts_position.type', 'home')
			->where('post_type', 'post')
			->where('status', 'published')
			->where('posts.publish_date', '<=', new Datetime())
			->orderBy('posts_position.position', 'ASC')
			->take(Config::get('settings.featured_posts', 12))->get();

		// fast news
		$this->data['lastest_posts'] = Post::select('posts.*', 'medias.mpath', 'medias.mtype', 'medias.mname')
			->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
			->where('post_type', 'post')
			->where('status', 'published')
			->where('showon_homepage', 1)
			->where('posts.publish_date', '<=', new Datetime())
			->orderBy('publish_date', 'DESC')->take(12)->get();

		// fast news
		$this->data['popular_posts'] = Post::select('posts.*', 'medias.mpath', 'medias.mtype', 'medias.mname')
			->join('medias', 'medias.id', '=', 'posts.media_id')
        	->join('posts_position', 'posts_position.post_id', '=', 'posts.id')
			->where('post_type', 'post')
			->where('posts_position.type', 'home_populars')
			->where('status', 'published')
			->where('posts.publish_date', '<=', new Datetime())
			->orderBy('posts_position.position', 'ASC')->take(Config::get('settings.popular_posts', 17))->get();

		// get sidebars
		$this->data['currentCat'] = $currentCat = Category::where('slug', 'trang-chu')->first();
		// $this->data['sidebars'] = $sidebars = $currentCat->sidebars;
		
		$this->data['featured_tags'] = Tag::select('tags.*', 'medias.mpath', 'medias.mname', DB::raw('GROUP_CONCAT(posts.id ORDER BY posts.id desc)'))
			->join('tag_post', 'tag_post.tag_id', '=', 'tags.id')
			->join('posts', 'posts.id', '=', 'tag_post.post_id')
			->join('medias', 'medias.id', '=', 'posts.media_id')
			->where('tags.showon_homepage', 1)
			->where('tags.is_featured', 1)
			->where('tags.type', 'topic')
			->where('posts.status', 'published')
			->where('medias.mtype', 'image')
			->whereNotNull('medias.mname')
			->orderBy('tags.created_at', 'DESC')
			->groupBy('tag_post.tag_id')
			->take(5)->get();

		//gioi thieu
		$this->data['intro'] = Post::select('posts.*', 'medias.mpath', 'medias.mname')
			->join('medias', 'medias.id', '=', 'posts.media_id')
			->where('post_type', 'post')
			->where('status', 'published')
			->where('category_id', $homefolder['GIOI_THIEU_TINH']) //category id
			->orderBy('created_at', 'DESC')->take(3)->get();

		//tin tuc & su kien
		$this->data['newshome'] = Post::select('posts.*', 'medias.mpath', 'medias.mname')
			->join('medias', 'medias.id', '=', 'posts.media_id')
			->where('post_type', 'post')
			->where('status', 'published')
			->where('category_id', $homefolder['GIOI_THIEU_TINH']) //category id
			->orderBy('created_at', 'DESC')->take(5)->get();

		//lanh su - viet kieu
		$this->data['overseas'] = Post::select('posts.*', 'medias.mpath', 'medias.mname')
			->join('medias', 'medias.id', '=', 'posts.media_id')
			->where('post_type', 'post')
			->where('status', 'published')
			->where('category_id', $homefolder['LANH_SU_VIET_KIEU']) //category id
			->orderBy('created_at', 'DESC')->take(5)->get();

		//hop tac quoc te
		$this->data['international'] = Post::select('posts.*', 'medias.mpath', 'medias.mname')
			->join('medias', 'medias.id', '=', 'posts.media_id')
			->where('post_type', 'post')
			->where('status', 'published')
			->where('category_id', $homefolder['HOP_TAC_QUOC_TE']) //category id
			->orderBy('created_at', 'DESC')->take(4)->get();
		//var_dump('<pre>',$this->data['international']->first());exit;

		//du an FNGO
		$this->data['fngo'] = Post::select('posts.*', 'medias.mpath', 'medias.mname')
			->join('medias', 'medias.id', '=', 'posts.media_id')
			->where('post_type', 'post')
			->where('status', 'published')
			->where('category_id', $homefolder['DU_AN_FNGO']) //category id
			->orderBy('created_at', 'DESC')->take(3)->get();

		//du an FDI
		$this->data['fdi'] = Post::select('posts.*', 'medias.mpath', 'medias.mname')
			->join('medias', 'medias.id', '=', 'posts.media_id')
			->where('post_type', 'post')
			->where('status', 'published')
			->where('category_id', $homefolder['DU_AN_FDI']) //category id
			->orderBy('created_at', 'DESC')->take(3)->get();

		return View::make('frontend/home', $this->data);
	}

	public function postSearch() 
	{
		// Declare the rules for the form validation
		$rules = array(
			'keyword'   => 'required',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::to('/')->with('error', Lang::get('admin/search/message.create.error'));
		}
		$keyword = implode("+", explode(" ", e(Jinput::get('keyword'))));
		return Redirect::to('/search/'.$keyword);
	}

	public function getSearch($keyword)
	{
		$this->data['keyword'] = $keyword = implode(" ", explode("+", e($keyword)));
		$this->data['keyword_slug'] = $keyword_slug = Str::slug($keyword);

		$this->data['posts'] = Post::select('posts.*', 'posts.id as id', 'posts.slug as slug', 'users.username', 'users.first_name', 'users.last_name', 'users.avatar', 'medias.mpath', 'medias.mname', 'medias.mtype')
			->join('users', 'users.id', '=', 'posts.user_id')
			->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
			->where('posts.status', 'published')
			// ->where('posts.post_type', 'post')
			->whereRaw("(posts.slug LIKE '%$keyword_slug%' OR posts.excerpt LIKE '%$keyword%' OR posts.content LIKE '%$keyword%')")
			->orderBy('posts.publish_date', 'DESC')
			->where('posts.publish_date', '<=', new Datetime())
			->orderBy('posts.post_type', 'ASC')->paginate(30);

		$this->data['featured_tags'] = Tag::select('*')->where('showon_homepage', 1)->where('is_featured', 1)->take(5)->get();
		
		return View::make('frontend/search', $this->data);
	}

}