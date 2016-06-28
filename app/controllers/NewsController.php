<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class NewsController extends BaseController {

	/**
	 * Returns all the news posts.
	 *
	 * @return View
	 */
	public function getCategory($catSlug)
	{
		$curr_time = new Datetime;
		$last_week = $curr_time->modify('-'.Config::get('app.backdays').' day');

		$this->data['category'] = $this->data['parent_category'] = $category = Category::where('slug', $catSlug)->first();
		$this->data['subcate'] = $category->subscategories;

		if($category->parent_id != 0)
			$this->data['parent_category'] = Category::find($category->parent_id);
		
		// Check if the news category exists
		if (is_null($category))
		{
			// If we ended up in here, it means that a page or a news post
			// don't exist. So, this means that it is time for 404 error page.
			return App::abort(404);
		}

        // Get all the news posts
        $this->data['featured_posts'] = Post::select('posts.*', 'medias.mpath', 'medias.mname')
            ->join('medias', 'medias.id', '=', 'posts.media_id')
            ->where('post_type', 'post')
            ->where('status', 'published')
            ->where('is_featured', 1)
            ->orderBy('created_at', 'DESC')->take(5)->get();

		$ids = array(0);
		foreach ($this->data['featured_posts'] as $key => $value) {
			if($key < 2)
				$ids[] = $value->id;
		}
		$this->data['ids'] = $ids;
		// Get all the news posts
		$this->data['popular_posts'] = Post::select('posts.*', 'medias.mpath', 'medias.mtype', 'medias.mname')
			->join('medias', 'medias.id', '=', 'posts.media_id')
			->where('post_type', 'post')
			->where('status', 'published')
			->where('is_popular', 1)
			->where('category_id', $category->id)
		    ->where(function ($query) {
		    	if(count($this->data['ids']))
		    		$query->whereNotIn('posts.id', $this->data['ids']);
		    })
		    ->where('posts.publish_date', '<=', new Datetime())
			->orderBy('publish_date', 'DESC')->take(18)->get();

		foreach ($this->data['popular_posts'] as $key => $value) {
			$ids[] = $value->id;
		}
		$this->data['ids'] = $ids;

		// Get all the news posts
		$this->data['posts'] = $category->rposts()->select('posts.*', 'medias.mpath', 'medias.mname', 'medias.mtype')
			->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
			->where('status', 'published')
			->where('post_type', 'post')
		    ->where(function ($query) {
		    	if(count($this->data['ids']))
		    		$query->whereNotIn('posts.id', $this->data['ids']);
		    })
		    ->where('posts.publish_date', '<=', new Datetime())
			->orderBy('publish_date', 'DESC')->paginate(Config::get('settings.paging_posts', 20));

		$this->data['mostview_post'] = $category->rposts()->select('posts.*', 'medias.mpath', 'medias.mname', 'medias.mtype')
			->join('medias', 'medias.id', '=', 'posts.media_id')
			->where('status', 'published')
			->where('post_type', 'post')
			->where('publish_date', '>', $last_week)
			->where('posts.publish_date', '<=', new Datetime())
			->orderBy('view_count', 'DESC')->take(10)->get();


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

		$this->data['page'] = $page = Input::get('page', 1);
		// Show the page
		return View::make('frontend/news/category', $this->data);
	}

	/**
	 * Returns all the news posts.
	 *
	 * @return View
	 */
	public function getTag($tagSlug)
	{
		$curr_time = new Datetime;
		$last_week = $curr_time->modify('-'.Config::get('app.backdays').' day');

		$this->data['tag'] = $tag = Tag::where('slug', $tagSlug)->first();
		// Check if the news category exists
		if (is_null($tag))
		{
			// If we ended up in here, it means that a page or a news post
			// don't exist. So, this means that it is time for 404 error page.
			return App::abort(404);
		}
		// Get all the news posts
		

		$this->data['posts'] = $tag->topicposts()->select('posts.*', 'medias.mpath', 'medias.mname', 'medias.mname', 'medias.mtype')
			->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
			->where('status', 'published')
			->where('post_type', 'post')
			->where('posts.publish_date', '<=', new Datetime())
			->orderBy('publish_date', 'DESC')->paginate(Config::get('settings.paging_posts', 30));

		if($this->data['posts']->count() < 1) {
			$this->data['posts'] = $tag->posts()->select('posts.*', 'medias.mpath', 'medias.mname', 'medias.mtype')
				->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
				->where('status', 'published')
				->where('post_type', 'post')
				->where('posts.publish_date', '<=', new Datetime())
				->orderBy('publish_date', 'DESC')->paginate(Config::get('settings.paging_posts', 30));
		}


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
		
		$this->data['mostview_post'] = Post::select('posts.*', 'medias.mpath', 'medias.mname', 'medias.mtype')
			->join('medias', 'medias.id', '=', 'posts.media_id')
			->where('status', 'published')
			->where('post_type', 'post')
			->where('publish_date', '>', $last_week)
			->where('posts.publish_date', '<=', new Datetime())
			->orderBy('view_count', 'DESC')->take(10)->get();

		$this->data['page'] = $page = Input::get('page', 1);
		$view = $tag->type;
		// Show the page
		return View::make('frontend/news/'.$view, $this->data);
	}

	public function getPrint($slug) {

		// echo $slug;
		$extStr = explode('-',$slug);

		$pId = array_pop($extStr);
		if($pId && $pId > 0) {
			// Get this news post data
			$this->data['post'] = $post = Post::select('posts.*', 'posts.id AS id', 'medias.mpath', 'medias.mname', 'medias.mtype')->where('posts.id', $pId)
				->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
				->where('status', 'published')
				->where('posts.publish_date', '<=', new Datetime())
				->where('post_type', 'post')->first();
		} else {
			// Get this news post data
			$this->data['post'] = $post = Post::select('posts.*', 'posts.id AS id', 'medias.mpath', 'medias.mname', 'medias.mtype')->where('slug', $slug)
				->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
				->where('status', 'published')
				->where('posts.publish_date', '<=', new Datetime())
				->where('post_type', 'post')->first();
		}


		// $this->data['currPostId'] = $post->id;
		// Check if the news post exists
		if (is_null($post))
		{
			// If we ended up in here, it means that a page or a news post
			// don't exist. So, this means that it is time for 404 error page.
			return App::abort(404);
		}

		return View::make('frontend/news/print', $this->data);
	}

	/**
	 * View a news post.
	 *
	 * @param  string  $slug
	 * @return View
	 * @throws NotFoundHttpException
	 */
	public function getView($pCatSlug, $catSlug, $slug= null)
	{

		$curr_time = new Datetime;
		$last_week = $curr_time->modify('-'.Config::get('app.backdays').' day');

		if(is_null($slug)) {

			$slug = $catSlug;
		}
		// echo $slug;
		$extStr = explode('-',$slug);

		$pId = array_pop($extStr);
		if($pId && $pId > 0) {
			// Get this news post data
			$this->data['post'] = $post = Post::select('posts.*', 'posts.id AS id', 'medias.mpath', 'medias.mname', 'medias.mtype')->where('posts.id', $pId)
				->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
				->where('status', 'published')
				->where('posts.publish_date', '<=', new Datetime())
				->where('post_type', 'post')->first();
		} else {
			// Get this news post data
			$this->data['post'] = $post = Post::select('posts.*', 'posts.id AS id', 'medias.mpath', 'medias.mname', 'medias.mtype')->where('slug', $slug)
				->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
				->where('status', 'published')
				->where('posts.publish_date', '<=', new Datetime())
				->where('post_type', 'post')->first();
		}


		// $this->data['currPostId'] = $post->id;
		// Check if the news post exists
		if (is_null($post))
		{
			// If we ended up in here, it means that a page or a news post
			// don't exist. So, this means that it is time for 404 error page.
			return App::abort(404);
		}

        $viewType = $post->mtype == 'video' ? 'video' : 'post';

        // check print
		$doAction = Jinput::get('d');		
		if($doAction && $doAction == 'print') {
			return View::make('frontend/news/print', $this->data);
		}

		$this->data['parent_category'] = $this->data['category'] = $category = Category::where('slug', $pCatSlug)->first();
		
		$cate_url = $category->slug;

		if($category->parent_id != 0) {
			$this->data['parent_category'] = Category::find($category->parent_id);
			$cate_url = $this->data['parent_category']->slug.'/'.$cate_url;
		}

		if(is_null($post->category_url) || strcmp($post->category_url, $cate_url) !== 0) {
			$post->category_url = $cate_url;
			$post->save();
		}

		if(strcmp($post->category_url, $cate_url) !== 0 || strcmp($post->slug.'-'.$post->id, $slug) !== 0 ) {
			return Redirect::to($post->category_url.'/'.$post->slug.'-'.$post->id);
		}
		

		$this->data['post_tags'] = $post_tags = $post->tags;
		$postTagArr = [0];
		foreach ($post_tags as $key => $tag) {
			$postTagArr[] = $tag->id;
		}

		// Get all the news posts
		$this->data['category_posts'] = $category->rposts()->select('posts.*', 'medias.mpath', 'medias.mname', 'medias.mtype')
			->join('medias', 'medias.id', '=', 'posts.media_id')
			->where('status', 'published')
			->where('post_type', 'post')
			->where('slug', '!=', $slug)
			->where('posts.publish_date', '<=', new Datetime())
			->orderBy('publish_date', 'DESC')->take(3)->get();
			
		if($post->mtype && $post->mtype == 'video') {
			$this->data['featured_videos'] = Post::select('posts.*', 'medias.mpath', 'medias.mname', 'medias.title as mtitle', 'medias.mtype', 'users.first_name', 'users.last_name', 'users.username', 'users.avatar')
				->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
				->join('users', 'users.id', '=', 'posts.user_id')
				->where('status', 'published')
				->where('post_type', 'post')
				->where('mtype', 'video')
				->where('slug', '!=', $slug)
				->remember(60)
				->orderBy('publish_date', 'DESC')->take(12)->get();
		} else {
			$this->data['mostview_post'] = $category->rposts()->select('posts.*', 'medias.mpath', 'medias.mname')
				->join('medias', 'medias.id', '=', 'posts.media_id')
				->where('status', 'published')
				->where('post_type', 'post')
				->where('slug', '!=', $slug)
				->where('publish_date', '>', $last_week)
				->where('posts.publish_date', '<=', new Datetime())
				->orderBy('view_count', 'DESC')->take(4)->get();

			if($this->data['mostview_post']->count() < 2) {
				$this->data['mostview_post'] = Post::select('posts.*', 'medias.mpath', 'medias.mname')
					->join('medias', 'medias.id', '=', 'posts.media_id')
					->where('status', 'published')
					->where('post_type', 'post')
					->where('slug', '!=', $slug)
					->where('publish_date', '>', $last_week)
					->where('posts.publish_date', '<=', new Datetime())
					->orderBy('view_count', 'DESC')->take(4)->get();
			}

			// fast news
			$this->data['popular_posts'] = Post::select('posts.*', 'medias.mpath', 'medias.mtype', 'medias.mname')
				->join('medias', 'medias.id', '=', 'posts.media_id')
				->where('post_type', 'post')
				->where('status', 'published')
				->where('is_popular', 1)
				->where('slug', '!=', $slug)
				->where('posts.publish_date', '<=', new Datetime())
				->orderBy('publish_date', 'DESC')->take(18)->get();


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
		}
		// // UPDATE count_view
		$this->data['postViewId'] = $postViewId = null;
        if(!Cookie::get('ses_last_views_news') || Cookie::get('ses_last_views_news') != 'post_'.$post->id) {
	        $post->view_count = $post->view_count + 1;
	        $post->save();
            $this->data['postViewId'] = $postViewId = Cookie::get('ses_last_views_news');
        }

        $this->data['currPostId'] = $post->id;
		// Show the page
		return View::make('frontend/news/view-'.$viewType, $this->data)->withCookie($postViewId);
	}

	/**
	 * View a news post.
	 *
	 * @param  string  $slug
	 * @return Redirect
	 */
	public function postView($catSlug, $slug)
	{
		// The user needs to be logged in, make that check please
		if ( ! Sentry::check())
		{
			return Redirect::to($catSlug."/$slug#comments")->with('error', 'You need to be logged in to post comments!');
		}

		$this->data['category'] = $category = Category::where('slug', $catSlug)->first();
		
		// Get all the news posts
		$this->data['category_posts'] = $category->rposts()->select('posts.*', 'medias.mpath', 'medias.mname')
			->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
			->where('status', 'published')
			->where('post_type', 'post')
			->where('slug', '!=', $slug)
			->orderBy('publish_date', 'DESC')->take(4)->get();

		// Get this news post data
		$post = Post::where('slug', $slug)->first();

		// Declare the rules for the form validation
		$rules = array(
			'comment' => 'required|min:3',
		);

		// Create a new validator instance from our dynamic rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now
		if ($validator->fails())
		{
			// Redirect to this news post page
			return Redirect::to($catSlug."/$slug#comments")->withInput()->withErrors($validator);
		}

		// Save the comment
		$comment = new Comment;
		$comment->user_id = Sentry::getUser()->id;
		$comment->content = e(Input::get('comment'));
		$comment->comment_type = 'post';

		// Was the comment saved with success?
		if($post->comments()->save($comment))
		{
			// Redirect to this news post page
			return Redirect::to($catSlug."/$slug#comments")->with('success', 'Your comment was successfully added.');
		}

		// Redirect to this news post page
		return Redirect::to($catSlug."/$slug#comments")->with('error', 'There was a problem adding your comment, please try again.');
	}

	public function updatePostView($postId) {
		// UPDATE count_view
		$post = Post::find($postId);
		if(!is_null($post)) {
	        $post->view_count = $post->view_count + 1;
	        $post->save();
	        echo $post->view_count;
		}
	}

	public function getAjaxMostPostComments() {

		$backdays = e(Jinput::get('backdays', 10));
		$limit = e(Jinput::get('limit', 6));

		$curr_time = new Datetime;
		$last_week = $curr_time->modify('-'.$backdays.' day');

		$this->data['posts'] = $posts = Post::select('posts.*', 'medias.mpath', 'medias.mtype', 'medias.mname')
			->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
			->where('status', 'published')
			->where('post_type', 'post')
			->where('publish_date', '>', $last_week)
			->where('posts.publish_date', '<=', new Datetime())
			->orderBy('comment_count', 'DESC')->take($limit)->get();

		return View::make('widgets/mostpopulars/ajaxlist', $this->data);
	}


	public function getAjaxLastestPosts() {

		$limit = e(Jinput::get('limit', 6));

		$this->data['posts'] = $posts = Post::select('posts.*', 'medias.mpath', 'medias.mtype', 'medias.mname')
			->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
			->where('status', 'published')
			->where('post_type', 'post')
			->where('posts.publish_date', '<=', new Datetime())
			->orderBy('publish_date', 'DESC')->take($limit)->get();

		return View::make('widgets/mostpopulars/ajaxlist', $this->data);
	}

	public function getComments($postId)
	{
		$post = Post::find($postId);
		$perPage = 20;

		if(is_null($post)) {
			return "Bài viết không tồn tại!";
		}

		// Get this post comments
		$this->data['post'] = $post;
		$this->data['page'] = $page = e(Input::get('page', 1));
		$this->data['order'] = $order = e(Input::get('order', 'vote'));

		switch ($this->data['order']) {
			case 'vote':
				$this->data['comments'] = $post->comments()->where('status', 'on')->where('comment_type', 'post')->orderBy('vote', 'desc')->paginate($perPage);
				break;
			case 'up':
				$this->data['comments'] = $post->comments()->where('status', 'on')->where('comment_type', 'post')->orderBy('created_at', 'desc')->paginate($perPage);
				break;
			case 'down':
				$this->data['comments'] = $post->comments()->where('status', 'on')->where('comment_type', 'post')->orderBy('created_at', 'asc')->paginate($perPage);
				break;
		}

		if($page > 1) {
			return View::make('frontend/comments/more', $this->data);
		} else {
			return View::make('frontend/comments/list', $this->data);
		}
	}

	public function postAddComment($postId)
	{
		$post = Post::find($postId);

		if(is_null($post)) {
			$this->data['status'] = $status = false;
			$this->data['message'] = $message = "Bài viết không tồn tại!";
			return View::make('frontend/comments/form/msg', $this->data);
		}
		$this->data['postId'] = $post['id'];
		$this->data['comment_content'] = $comment_content = e(Jinput::get('comment_content'));

		// Declare the rules for the form validation
		$rules = array(
			'comment_content' => 'required|min:3',
			'step' => 'integer',
		);

		// Create a new validator instance from our dynamic rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now
		if ($validator->fails())
		{
			$this->data['status'] = $status = false;
			$this->data['message'] = $message = "Chưa nhập nội dung hoặc nội dung quá ngắn!";
			return View::make('frontend/comments/form/msg', $this->data);
		}

		$this->data['step'] = $step = Input::get('step', 0);

		if(is_null($this->u))
		{
			if($step == 1) {
				// Declare the rules for the form validation
				$rules = array(
					'comment_content' => 'required|min:3',
					'email' => 'required|email',
					'fullname' => 'required',
				);

				// Create a new validator instance from our dynamic rules
				$validator = Validator::make(Input::all(), $rules);

				$this->data['fullname'] = e(Input::get('fullname'));
				$this->data['email'] = e(Input::get('email'));

				// If validation fails, we'll exit the operation now
				if ($validator->fails())
				{
					$this->data['status'] = $status = false;
					$this->data['message'] = $message = "Thông tin chưa hợp lệ!";
					return View::make('frontend/comments/form/auth', $this->data);
				}
			} elseif($step == 0) {
				$this->data['step'] = 1;
				$this->data['status'] = $status = true;
				$this->data['message'] = $message = "Thêm thông tin...";
				// enter name & email
				return View::make('frontend/comments/form/auth', $this->data);
			}
		} else {			
			$this->data['fullname'] = $this->u->first_name.' '.$this->u->last_name;
			$this->data['email'] = $this->u->email;
		}

		// Save the comment
		$comment = new Comment;
		$comment->user_id  = is_null($this->u) ? 0 : $this->u->id;
		$comment->fullname = $this->data['fullname'];
		$comment->email    = $this->data['email'];
		$comment->post_id  = $post->id;
		$comment->content  = $comment_content;
		$comment->status  = 'off';
		$comment->comment_type = 'post';

		// Was the comment saved with success?
		if($comment->save())
		{
			$post->comment_count = $post->comment_count + 1;
			$post->save();

			$this->data['status'] = $status = true;
			$this->data['message'] = "Gửi bình luận thành công! Bình luận của bạn sẽ được xét duyệt để hiển thị. Xin cảm ơn!";
			return View::make('frontend/comments/form/msg', $this->data);
		}
	}

	public function postAddVote($postId)
	{
		$post = Post::find($postId);

		if(is_null($post)) {
			return json_encode(array('status' => false, 'msg' => 'Bài viết không tồn tại.'));
		}
		$cmtId = e(Input::get('cmtId', 0));
		if($cmtId && !is_null($comment = Comment::find($cmtId))) {
			$comment->vote = $comment->vote + 1;
			$comment->save();

			return json_encode(array('status' => true, 'msg' => 'Vote thành công.', 'vote' => $comment->vote));
		}
		
	}

	/**
	 * Return unique slug.
	 *
	 * @return slug
	 */
	public function slug($slug)
	{
		$existPost = Post::where('slug', $slug)->first();

		if (!is_null($existPost)) {
			return $slug.'-'.time();
		}

		return $slug;
	}
}
