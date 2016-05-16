<?php namespace Controllers\Account;

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

use AuthorizedController;
use Input;
use Jinput;
use Image;
use Place;
use UserPlace;
use Redirect;
use Request;
use Permission;
use Sentry;
use Validator;
use View;

class ProfileController extends AuthorizedController {

	/**
	 * User profile page.
	 *
	 * @return View
	 */

	public function getIndex()
	{
		$this->data['user'] = $this->pu();

		$this->data['place'] = Place::find($this->pu()->place_id);
		
		// Show the page
		return View::make('frontend/account/profile', $this->data);
	}

	/**
	 * User profile form processing page.
	 *
	 * @return Redirect
	 */
	public function postIndex()
	{
		// Declare the rules for the form validation
		$rules = array(
			'first_name' => 'required',
			'last_name'  => 'required',
			'website'    => 'url',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		// Grab the user
		$user = $this->pu();

		// Update the user information
		$user->first_name 	= Jinput::get('first_name');
		$user->last_name  	= Jinput::get('last_name');
		$user->website    	= Input::get('website');
		$user->gender    	= Jinput::get('gender');
		$user->hometown    	= Jinput::get('hometown');
		$user->phone    	= Jinput::get('phone');
		$user->phone_cog    = Jinput::get('phone_cog');
		$user->birth_day  	= Jinput::get('birth_day');
		$user->birth_month 	= Jinput::get('birth_month');
		$user->birth_year  	= Jinput::get('birth_year');
		$user->bio    		= Jinput::get('bio');
		$user->save();

		// Redirect to the settings page
		return Redirect::to(Request::fullUrl())->with('success', 'Cập nhật tài khoản thành công!');
	}

	/**
	 * User Avatar page.
	 *
	 * @return View
	 */
	public function getAvatar()
	{
		// Get the user information
		$this->data['user'] = $this->pu();

		// Show the page
		return View::make('frontend/account/avatar', $this->data);
	}

	/**
	 * User Avatar form processing page.
	 *
	 * @return Redirect
	 */
	public function postAvatar()
	{
		// Declare the rules for the form validation
		$rules = array(
			'picture' => 'required|mimes:jpg,jpeg,png|max:2000|min:10'
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

    	$upload = Image::upload(Input::file('picture'), 'avatars', true, true);

    	if($upload) {
    		// Remove old avatar

			// Grab the user
			$user = $this->pu();

			// Update the user information
			$user->avatar = $upload['name'];

			$user->save();

    	}
		// Redirect to the settings page
		return Redirect::to(Request::fullUrl())->with('success', 'Cập nhật tài khoản thành công!');
	}

	function postUpdatePlace() {
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
			return Redirect::back()->withInput()->withErrors($validator);
		}

		// Grab the user
		$user = $this->pu();
		$place = Place::find(e(Input::get('place_id')));
		if($place) {
			$doctor = Doctor::where('user_id', $user->id)->first();
			// Update the user information
			$doctor->place_id = $place->id;
			$doctor->location = $place->address;
			$doctor->save();

			// Update the user information
			$user->place_id = $place->id;
			$user->location = $place->address;
			$user->save();
			
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
			}
		}
	}
}
