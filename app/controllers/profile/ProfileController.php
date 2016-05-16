<?php namespace Controllers\Profile;

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

use BaseController;
use Redirect;
use User;
use Lang;
use Post;
use Category;
use Answer;
use HbCategory;
use Place;
use Media;
use EventPlace;
use Newsletter;
use UserFollow;
use Validator;
use View;
use Sentry;
use Mailer;
use Input;
use DateTime;

class ProfileController extends BaseController {

	/**
	 * Redirect to the profile page.
	 *
	 * @return Redirect
	 */
	public function getIndex($username)
	{
		$this->data['profile'] = $profile = User::select('users.*')
				->where('username', $username)->first();
		if(is_null($this->data['profile']))
			return Redirect::route('home')->with('error', Lang::get('message.error.notallow'));

		$this->data['existfollow'] = UserFollow::existfollow($profile->id);

		if( !is_null($this->u) && $this->u->id = $profile->id )
		{
		}

		$this->data['pages'] = $pages = e(Input::get('p', 'dash'));
		$this->data['type'] = $type = Input::get('type', '');

		// Doctor
		if ( $profile->is_doctor )
		{
		} else {

			if($pages == '' || $pages == 'dash')
			{
				// Get all the news posts
				$this->data['posts'] = Post::select('posts.*', 'posts.id as id', 'posts.slug as slug', 'u.username', 'u.first_name', 'u.last_name', 'u.avatar', 'answers.user_id AS au_id')
					->leftJoin('answers', 'answers.post_id', '=', 'posts.id')
					->join('users AS u', 'u.id', '=', 'posts.user_id')
					->where(function($query){
						if($this->data['type'] == 'answered') {
							$query->where('answers.user_id', '>', 0);
						} elseif($this->data['type'] == 'notanswer') {
							$query->whereNull('answers.user_id');
						}
					})
					->where('posts.status', 'published')
					->where('posts.user_id', $profile->id)
					->where('posts.post_type', 'answer')
					->orderBy('posts.publish_date', 'DESC')->paginate(10);
			} elseif($type=='follows') {
				$this->data['follow_docstors'] = $profile->followers()->select('doctors.id', 'doctors.works', 'users.first_name', 'users.last_name', 'users.username', 'users.avatar', 'users.follows', 'departments.name')
					->join('doctors', 'doctors.user_id', '=', 'users.id')
					->leftJoin('departments', 'departments.id', '=', 'doctors.dept_id')
					->get();
			} elseif($type=='newsletters') {
				
			}
		}

		// Redirect to the profile page
		return View::make('frontend/profile/'.$pages, $this->data);
	}

	public function getDoctor($username)
	{
		$this->data['profile'] = $profile = User::select('users.*', 'places.lat', 'places.lng', 'places.name', 'places.id as pid', 'places.slug', 'places.address', 'departments.name As dame', 'departments.slug AS dlug', 'doctors.certificates AS certificates', 'doctors.exps AS exps', 'doctors.works AS works', 'doctors.content AS content', 'doctors.location')
				->join('doctors', 'doctors.user_id', '=', 'users.id')
				->leftJoin('departments', 'departments.id', '=', 'doctors.dept_id')
				->leftJoin('places', 'places.id', '=', 'doctors.place_id')
				->where('username', $username)->first();
				
		if(is_null($this->data['profile']))
			return Redirect::route('home')->with('error', Lang::get('message.error.notallow'));

		$this->data['existfollow'] = UserFollow::existfollow($profile->id);

		$this->data['medias'] = Media::join('doctor_media', 'doctor_media.media_id', '=', 'medias.id')
			->where('doctor_media.user_id', $profile->id)->get();

		// Get all the news posts
		$this->data['answers'] = Post::select('posts.*', 'posts.id as id', 'posts.slug as slug', 'u.username', 'u.first_name', 'u.last_name', 'u.avatar', 'medias.mpath', 'medias.mname', 'answers.user_id AS au_id')
			->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
			->leftJoin('answers', 'answers.post_id', '=', 'posts.id')
			->join('users AS u', 'u.id', '=', 'posts.user_id')
			->where('posts.status', 'published')
			->where('posts.post_type', 'answer')
			->where('answers.user_id', $profile->id)
			->orderBy('answers.created_at', 'DESC')->paginate(5);

		// Redirect to the profile page
		return View::make('frontend/profile/doctor', $this->data);
	}

	public function postFollow()
	{
		// Declare the rules for the form validation
		$rules = array(
			'follow_id' => 'required|exists:users,id'
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
		$follow = User::find(e(Input::get('follow_id')));
		if($follow) {
			// check exist follow
			$userfollow = UserFollow::where('user_id', $user->id)->where('follow_id', $follow->id)->first();
			if(is_null($userfollow))
			{
				$userfollow = new UserFollow;
				$userfollow->user_id = $user->id;
				$userfollow->follow_id = $follow->id;
				$userfollow->save();

				// update follow count
				$follow->follows = $follow->follows + 1;
				$follow->save();
				// send mail
				$obj['title'] = "acb";
				Mailer::sendmail('userfollow', $obj, $user, $follow, true);
				return 1;
			}
		}

		return 0;
	}


	public function postUnFollow()
	{
		// Declare the rules for the form validation
		$rules = array(
			'follow_id' => 'required|exists:users,id'
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
		$follow = User::find(e(Input::get('follow_id')));
		if($follow) {
			// check exist follow
			$userfollow = UserFollow::where('user_id', $user->id)->where('follow_id', $follow->id)->first();
			if(!is_null($userfollow))
			{
				$userfollow->delete();

				// update follow count
				$follow->follows = $follow->follows - 1;
				$follow->save();

				return 1;
			}
		}

		return 0;
	}

}
