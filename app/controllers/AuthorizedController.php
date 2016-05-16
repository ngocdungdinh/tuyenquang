<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class AuthorizedController extends BaseController {

	/**
	 * Whitelisted auth routes.
	 *
	 * @var array
	 */
	protected $whitelist = array();

	/**
	 * Initializer.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// Apply the auth filter
		$this->beforeFilter('auth', array('except' => $this->whitelist));

		// Call parent
		parent::__construct();
	}
	
	public function pu()
	{
		$profile_id = $this->u->id;
		$uid = Jinput::get('uid');
		// need check exist user
		if($uid && Permission::has_access('user', 'edit', $uid))
			$profile_id = $uid;

		return Sentry::findUserByID($profile_id);
	}

}
