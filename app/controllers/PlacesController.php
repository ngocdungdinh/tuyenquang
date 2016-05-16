<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class PlacesController extends BaseController {

	/**
	 * Returns all the news posts.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		$this->data['common_places'] = $common_places = Place::where('status', 'open')->orderBy('search_count', 'DESC')->take(6)->get();

		$this->data['lastest_event'] = $lastest_event = EventPlace::select('events.*', 'places.*', 'users.first_name', 'users.last_name', 'users.avatar', 'events.type AS etype', 'events.id AS id', 'events.slug AS slug', 'events.created_at AS created_at', 'medias.mpath', 'medias.mname', 'places.slug AS pslug')
			->join('users', 'users.id', '=', 'events.user_id')
			->leftJoin('medias', 'medias.id', '=', 'events.cover_id')
			->leftJoin('places', 'places.id', '=', 'events.place_id')
			->where('events.status', 'open')
			->orderBy('events.created_at', 'DESC')->take(6)->get();

		// Get all the news posts
		$this->data['featured_posts'] = Post::select('posts.*', 'places.*', 'posts.slug as slug', 'places.slug as pslug', 'users.first_name', 'users.last_name', 'users.avatar', 'medias.mpath', 'medias.mname')
			->join('users', 'users.id', '=', 'posts.user_id')
			->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
			->leftJoin('places', 'places.id', '=', 'posts.place_id')
			->where('posts.post_type', 'post')
			->where('posts.status', 'published')
			->where('posts.is_featured', 1)
			->where('posts.showon_homepage', 1)
			->orderBy('posts.publish_date', 'DESC')->take(13)->get();

		// Show the page
		return View::make('frontend/places/index', $this->data);
	}

	/**
	 * Returns all the news posts.
	 *
	 * @return View
	 */
	public function getView($placeSlug)
	{

		$curr_time = new Datetime;
		$this->data['place'] = $place = Place::where('status', 'open')->where('slug', $placeSlug)->first();		

		// Check if the news place exists
		if (is_null($place))
		{
			return App::abort(404);
		}

		$this->data['existfollow'] = UserPlace::existfollow($place->id);

		$this->data['filter'] = $filter = e(Input::get('m'));
		$this->data['category'] = $category = Category::find(e(Input::get('c')));

        $cids = array(0);
        if(!is_null($category) && $category->parent_id == 0) {
	        foreach ($category->subscategories as $c) {
	        	$cids[] = $c->id;
	        }
        	$cids[] = $category->id;
        } else if(!is_null($category)) {
        	$cids[] = $category->id;
        } else {
        	foreach ($this->data['categories'] as $c) {
        		$cids[] = $c->id;
		        foreach ($c->subscategories as $sc) {
		        	$cids[] = $sc->id;
		        }
        	}
        }

        $pids = array($place->id);
        foreach ($place->subplaces as $sp) {
        	$pids[] = $sp->id;
        }

		// Show the page
		if($filter == 'popular') {
			$this->data['place_posts'] = Post::select('posts.*', 'places.name AS pname', 'places.slug as pslug', 'posts.slug as slug', 'users.username', 'users.first_name', 'users.last_name', 'users.avatar', 'medias.mpath', 'medias.mname')
				->join('users', 'users.id', '=', 'posts.user_id')
				->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
				->leftJoin('places', 'places.id', '=', 'posts.place_id')
				->where('posts.post_type', 'post')
				->where('posts.is_popular', 1)
				->where('posts.status', 'published')
				->whereIn('posts.place_id', $pids)
				->whereIn('posts.category_id', $cids)
				->orderBy('posts.publish_date', 'DESC')->paginate(10);
		} elseif($filter == 'featured') {
			$this->data['place_posts'] = Post::select('posts.*', 'places.name AS pname', 'places.slug as pslug', 'posts.slug as slug', 'users.username', 'users.first_name', 'users.last_name', 'users.avatar', 'medias.mpath', 'medias.mname')
				->join('users', 'users.id', '=', 'posts.user_id')
				->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
				->leftJoin('places', 'places.id', '=', 'posts.place_id')
				->where('posts.post_type', 'post')
				->where('posts.is_featured', 1)
				->where('posts.status', 'published')
				->whereIn('posts.place_id', $pids)
				->whereIn('posts.category_id', $cids)
				->orderBy('posts.publish_date', 'DESC')->paginate(10);
		} else {
			$this->data['place_posts'] = Post::select('posts.*', 'places.name AS pname', 'places.slug as pslug', 'posts.slug as slug', 'users.username', 'users.first_name', 'users.last_name', 'users.avatar', 'medias.mpath', 'medias.mname')
				->join('users', 'users.id', '=', 'posts.user_id')
				->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
				->leftJoin('places', 'places.id', '=', 'posts.place_id')
				->where('posts.post_type', 'post')
				->where('posts.status', 'published')
				->whereIn('posts.place_id', $pids)
				->whereIn('posts.category_id', $cids)
				->orderBy('posts.publish_date', 'DESC')->paginate(10);
		}

		// for radar
		$this->data['featured_posts'] = Post::select('posts.*', 'places.name AS pname', 'places.slug as pslug', 'posts.slug as slug', 'users.username', 'users.first_name', 'users.last_name', 'users.avatar', 'medias.mpath', 'medias.mname')
			->join('users', 'users.id', '=', 'posts.user_id')
			->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
			->leftJoin('places', 'places.id', '=', 'posts.place_id')
			->where('posts.post_type', 'post')
			->where('posts.is_featured', 1)
			->where('posts.status', 'published')
			->whereIn('posts.place_id', $pids)
			->orderBy('posts.publish_date', 'DESC')->take(5)->get();

		$this->data['place_events'] = EventPlace::select('events.*', 'users.username', 'users.first_name', 'users.last_name', 'users.avatar', 'events.type AS etype', 'events.id AS id', 'events.place_id', 'places.address', 'events.slug AS slug', 'events.created_at AS created_at')
			->join('users', 'users.id', '=', 'events.user_id')
			->join('places', 'places.id', '=', 'events.place_id')
			->where('events.status', 'open')
			->where('events.start_date', '>', $curr_time)
			->where('events.place_id', $place->id)
			->orWhere('events.place_from_id', $place->id)
			->take(10)->get();
		return View::make('frontend/places/view-place', $this->data);
	}

	/**
	 * Place create form processing.
	 *
	 * @return Redirect
	 */
	public function postCreate()
	{
		// Declare the rules for the form validation
		$rules = array(
			'name'   => 'required|min:3',
			'address' => 'required|min:3'
		);


		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			// return Redirect::back()->withInput()->withErrors($validator);
			return;
		}

		$slug  = e(Str::slug(Input::get('name')));
		$place = Place::where('slug', $slug)->first();

		// if(!is_null($place))
		// {
		// 	return $place->toJson();
		// } else {
		// 	if(!Sentry::check())
		// 		return 'Place dont exist!';
		// }

		if(is_null($place)) {
			$place = new Place;
			$place->name 		= e(Jinput::get('name'));
			$place->slug 		= $slug;
			$place->gid 		= e(Input::get('gid'));
			$place->parent_id 	= e(Input::get('parent_id'));
			$place->address 	= e(Input::get('address'));
			$place->country 	= e(Input::get('country'));
			$place->lat 		= e(Input::get('lb'));
			$place->lng 		= e(Input::get('mb'));
			$place->type 		= e(Input::get('type'));
			$place->url 		= e(Input::get('url'));
			$place->follows 	= 0;
			$place->status 		= "open";
			$place->user_id 	= Sentry::getId();
			$place->save();
		} else {
			$place->lat 		 = e(Input::get('lb'));
			$place->lng 		 = e(Input::get('mb'));
			$place->search_count = $place->search_count + 1;
			$place->parent_id 	 = e(Input::get('parent_id'));
			$place->save();
		}
		return $place->toJson();
	}

	public function getUpdate($pId)
	{

		$this->data['place'] = $place = Place::select('places.*', 'places.id as id', 'users.username', 'users.first_name', 'users.last_name')
		->join('users', 'users.id', '=', 'places.user_id')
		->where('places.id', $pId)->first();

		// Check if the news place exists
		if (is_null($place))
		{
			return App::abort(404);
		}

		return View::make('frontend/places/edit', $this->data);
	}
	/**
	 * Place create form processing.
	 *
	 * @return Redirect
	 */
	public function postUpdate($pId)
	{
		$place = Place::find($pId);
		// Check if the news place exists
		if (is_null($place))
		{
			return App::abort(404);
		}

		// Declare the rules for the form validation
		$rules = array(
			'name'   => 'required|min:3',
			'address' => 'required|min:3'
		);


		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			// return Redirect::back()->withInput()->withErrors($validator);
			return;
		}

		$place->name 			= e(Jinput::get('name'));
		$place->parent_id 		= e(Input::get('parent_id'));
		$place->address 		= e(Input::get('address'));
		$place->follows 		= e(Input::get('follows'));
		$place->search_count 	= e(Input::get('search_count'));
		$place->status 			= e(Input::get('status'));
		$place->is_popular 		= e(Input::get('is_popular', 0));
		$place->is_featured		= e(Input::get('is_featured', 0));
		$place->save();

		return $place->toJson();
	}

	/**
	 * Place create form processing.
	 *
	 * @return Redirect
	 */
	public function postFollow()
	{
		// Declare the rules for the form validation
		$rules = array(
			'place_id' => 'required|exists:places,id'
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return 0;
		}

		// Grab the user
		$user = Sentry::getUser();
		$place = Place::find(e(Input::get('place_id')));
		if($place) {
			// check exist follow
			$userplace = UserPlace::where('user_id', $user->id)->where('place_id', $place->id)->first();
			if(is_null($userplace))
			{
				$userplace = new UserPlace;
				$userplace->user_id = $user->id;
				$userplace->place_id = $place->id;
				$userplace->save();

				// update follow count
				$place->follows = $place->follows + 1;
				$place->save();

				return 1;
			}
		}

		return 0;
	}
	/**
	 * Place create form processing.
	 *
	 * @return Redirect
	 */
	public function postUnFollow()
	{
		// Declare the rules for the form validation
		$rules = array(
			'place_id' => 'required|exists:places,id'
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return 0;
		}

		// Grab the user
		$user = Sentry::getUser();
		$place = Place::find(e(Input::get('place_id')));
		if($place) {
			// check exist follow
			$userplace = UserPlace::where('user_id', $user->id)->where('place_id', $place->id)->first();
			if(!is_null($userplace))
			{
				$userplace->delete();

				// update follow count
				$place->follows = $place->follows - 1;
				$place->save();

				return 1;
			}
		}

		return 0;
	}
}