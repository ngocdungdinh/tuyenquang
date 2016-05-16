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
use Redirect;

class DashboardController extends AuthorizedController {

	/**
	 * Redirect to the profile page.
	 *
	 * @return Redirect
	 */
	public function getIndex()
	{
		// Redirect to the profile page
		return Redirect::route('profile');
	}

}
