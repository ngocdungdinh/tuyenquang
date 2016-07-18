<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class PagesController extends BaseController {

	/**
	 * View a news post.
	 *
	 * @param  string  $slug
	 * @return View
	 * @throws NotFoundHttpException
	 */
	public function getView($slug)
	{
		// Get this news post data
		$this->data['page'] = $page = Post::where('slug', $slug)->first();
		$this->data['pages'] = $pages = Post::where('post_type', 'page')->get();
		// Check if the news post exists
		if (is_null($page))
		{
			// If we ended up in here, it means that a page or a news post
			// don't exist. So, this means that it is time for 404 error page.
			return App::abort(404);
		}

		$this->data['featured_tags'] = Tag::select('*')->where('showon_homepage', 1)->where('is_featured', 1)->take(5)->get();
		
		// Show the page
		return View::make('frontend/pages/view-page', $this->data);
	}

	public function getWebLink()
	{
		// Get this news post data
		$this->data['wLink'] = $page = Post::where('id', Config::get('app.page.LIEN_KET_WEB'))->first();

		// Check if the news post exists
		if (is_null($page))
		{
			// If we ended up in here, it means that a page or a news post
			// don't exist. So, this means that it is time for 404 error page.
			return App::abort(404);
			// Show the page
		}
		return View::make('frontend/pages/web-link', $this->data);
	}

}