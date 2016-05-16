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

class ChangePasswordController extends AuthorizedController {

	/**
	 * User change password page.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Get the user information
		$this->data['user'] = $this->pu();

		// Show the page
		return View::make('frontend/account/change-password', $this->data);
	}

	/**
	 * User change password form processing page.
	 *
	 * @return Redirect
	 */
	protected function postIndex()
	{
		// Declare the rules for the form validation
		$rules = array(
			'old_password'     => 'required|between:3,32',
			'password'         => 'required|between:3,32',
			'password_confirm' => 'required|same:password',
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
		if ( ! $user->checkPassword(Input::get('old_password')))
		{
			// Set the error message
			$this->messageBag->add('old_password', 'Your current password is incorrect.');

			// Redirect to the change password page
			return Redirect::route('change-password')->withErrors($this->messageBag);
		}

		// Update the user password
		$user->password = Input::get('password');
		$user->save();

		// Redirect to the change-password page
		return Redirect::to(Request::fullUrl())->with('success', 'Thay đổi mật khẩu thành công!');
	}

}
