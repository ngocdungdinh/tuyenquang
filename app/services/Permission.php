<?php namespace App\Services;

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */
 
use Config, File, Log, Sentry;
 
class Permission {
	public function is_admin()
	{
		// Check if the user is logged in
		if ( ! Sentry::check())
		{
			return false;
		}

		// Check if the user has access to the admin page
		if ( ! Sentry::getUser()->hasAccess('admin'))
		{
			return false;
		}
		return true;
	}

	public function has_access($module, $action, $userId = 0)
	{
		
		// Check if the user is logged in
		if ( ! Sentry::check())
		{
			return false;
		}

		// Check if the user has access to the admin page
		if ( Sentry::getUser()->hasAnyAccess([$module, $module.'.full']))
		{
			return true;
		}
		if($userId && Sentry::getId() != $userId) {
			return false;
		}

		if ( !Sentry::getUser()->hasAnyAccess([$module, $module.'.'.$action]) )
		{
			return false;
		}
		
		return true;
	}
}