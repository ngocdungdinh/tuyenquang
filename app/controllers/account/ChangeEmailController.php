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
use Redirect;
use Request;
use Sentry;
use Validator;
use View;

class ChangeEmailController extends AuthorizedController {

	/**
	 * User change email page.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Get the user information
		$this->data['user'] = $this->pu();

		// Show the page
		return View::make('frontend/account/change-email', $this->data);
	}

	/**
	 * Users change email form processing page.
	 *
	 * @return Redirect
	 */
	public function postIndex()
	{
		// Declare the rules for the form validation
		$rules = array(
			'current_password' => 'required|between:3,32',
			'email'            => 'required|email|unique:users,email,'.Sentry::getUser()->email.',email',
			'email_confirm'    => 'required|same:email',
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

		// Check the user current password
		if ( ! $user->checkPassword(Input::get('current_password')))
		{
			// Set the error message
			$this->messageBag->add('current_password', 'Mật khẩu không đúng');

			// Redirect to the change email page
			return Redirect::route('change-email')->withErrors($this->messageBag);
		}

		// Update the user email
		$user->email = Input::get('email');
		$user->save();

		// Redirect to the settings page
		return Redirect::to(Request::fullUrl())->with('success', 'Thay đổi email thành công!');
	}

}
