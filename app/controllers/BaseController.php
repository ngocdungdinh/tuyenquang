<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class BaseController extends Controller {

	/**
	 * Message bag.
	 *
	 * @var Illuminate\Support\MessageBag
	 */
	protected $messageBag = null;
	public $data = array();

	/**
	 * Initializer.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$curr_time = new Datetime;
		// CSRF Protection
		$this->beforeFilter('csrf', array('on' => 'post'));

		// $this->data['categories'] = Category::where('showon_menu', '>', 0)->orderBy('showon_menu', 'ASC')->get();
		$this->data['categories'] = Category::where('status', 'on')->where('showon_position', 1)->orderBy('showon_menu', 'ASC')->get();

		$this->data['sidebarcate'] = Category::where('status', 'on')->where('showon_position', 2)->orderBy('showon_menu', 'ASC')->get();

        //right block featured posts
        $this->data['featured_posts'] = Post::select('posts.*', 'medias.mpath', 'medias.mname')
            ->join('medias', 'medias.id', '=', 'posts.media_id')
            ->where('post_type', 'post')
            ->where('status', 'published')
            ->where('is_featured', 1)
            ->orderBy('created_at', 'DESC')->take(5)->get();
			
		$this->data['u'] = $this->u = Sentry::check() ? Sentry::getUser() : null;
		//
		$this->messageBag = new Illuminate\Support\MessageBag;
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout, $this->data);
		}
	}

}
