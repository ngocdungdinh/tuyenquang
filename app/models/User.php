<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;

class User extends SentryUserModel {

	/**
	 * Indicates if the model should soft delete.
	 *
	 * @var bool
	 */
	protected $softDelete = true;

	/**
	 * Returns the user full name, it simply concatenates
	 * the user first and last name.
	 *
	 * @return string
	 */
	public function fullName()
	{
		return "{$this->first_name} {$this->last_name}";
	}

	/**
	 * Returns the user avatar image url.
	 *
	 * @return string
	 */
	public static function avatar($avatar, $size, $width, $doctor = false)
	{
		if($avatar)
		{
			$img = '<img src="'.asset('uploads/avatars/'.$size.'/'.$avatar).'" width="'.$width.'">';
		}
		else
		{
			if ($doctor) {
				$img = '<img src="'.asset('assets/img/unknown_doctor.png').'" width="'.$width.'">';
			} else {
				$img = '<img src="'.asset('assets/img/default-avatar.png').'" width="'.$width.'">';
			}
		}
		return $img;
	}
	
	public function medias() {
		return $this->belongsToMany('Media','doctor_media','user_id','media_id');
	}
	
	/**
	 * Returns the user Gravatar image url.
	 *
	 * @return string
	 */
	public function gravatar()
	{
		// Generate the Gravatar hash
		$gravatar = md5(strtolower(trim($this->gravatar)));

		// Return the Gravatar url
		return "//gravatar.org/avatar/{$gravatar}";
	}

	public function followers()
	{
		return $this->belongsToMany('User','user_follow','user_id','follow_id');
	}

	public function followings()
	{
		return $this->belongsToMany('User','user_follow','follow_id','user_id');
	}

}
