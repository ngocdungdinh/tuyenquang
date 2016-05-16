<?php namespace Controllers\Admin;

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

use AdminController;
use Input;
use Jinput;
use Lang;
use PostTag;
use Media;
use DateTime;
use Redirect;
use Sentry;
use Str;
use Validator;
use View;
use Config;
use Setting;

class SettingsController extends AdminController {

	public function getIndex()
	{
		Config::set('app.locale', 'en');
		// Show the page
		return View::make('backend/settings/index', $this->data);
	}

	public function postIndex()
	{
		// print_r(Input::all()); die();
		$configs = Input::get('configs', array());

		foreach ($configs as $key => $value) {
			if(Setting::where('key', $key)->first()) {
				Setting::where('key', $key)->update(array('value' => $value));
			} else {
				Setting::insert(array(
					'key' => $key,
					'value' => $value
				));
			}
		}
		// print_r($configs); 
		// print_r(Config::get('settings')->toArray()); die();
		// Show the page
		// return View::make('backend/settings/index', $this->data);
		return Redirect::to("admin/settings")->with('success', Lang::get('general.success'));
	}
}