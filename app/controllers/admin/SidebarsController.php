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
use Sidebar;
use SidebarRef;
use Widget;
use WidgetRef;
use Category;
use Permission;
use User;
use Cache;
use Input;
use Validator;
use Str;
use View;
use Lang;
use Redirect;
use Config;
use Sentry;

class SidebarsController extends AdminController {

	public function getIndex()
	{
		$this->data['sidebars'] = $sidebars = Sidebar::orderBy('created_at')->get();
		return View::make('backend/sidebars/index', $this->data);
	}

	public function getForm()
	{
		$sidebar_id = Input::get('sid', 0);
		if($sidebar_id)
			$this->data['sidebar'] = Sidebar::find($sidebar_id);

		return View::make('backend/sidebars/form', $this->data);
	}

	public function postForm()
	{

		if ( !Sentry::getUser()->hasAnyAccess(['settings','settings.appearance']) )
			return View::make('backend/notallow');

		// Declare the rules for the form validation
		$rules = array(
			'name'   => 'required|min:3'
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}
		$sidebar_id = Input::get('sidebar_id', 0);
		if($sidebar_id)
			$this->data['sidebar'] = $sidebar = Sidebar::find($sidebar_id);
		else
			$sidebar = new Sidebar;

		$sidebar->name 		= Input::get('name');
		$sidebar->code 		= Str::slug($sidebar->name);
		$sidebar->position 	= Input::get('position');
		$sidebar->status 	= Input::get('status');

		$sidebar->save();

		// Redirect to the categories category management page
		return Redirect::to("admin/sidebars")->with('success', Lang::get('general.success'));
	}

	public function removeSidebarRef($srid)
	{
		if(!is_null($sidebarRef = SidebarRef::find($srid)))
		{
			$sidebarRef->delete();
			return 1;
		}
		return 0;
	}

	public function addSidebarRef()
	{
		$sidebar_id = Input::get('sidebar_id');
		$item_id = Input::get('item_id');
		$type = Input::get('type');

		// Declare the rules for the form validation
		$rules = array(
			'sidebar_id'   => 'required',
			'item_id'   => 'required',
			'type'   => 'required',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return 0;
		}

		if($type == "Category") {
			$item = Category::find($item_id);
			$sidebarref = new SidebarRef;
			$sidebarref->sidebar_id = $sidebar_id;
			$item->sidebars()->save($sidebarref);
		}

		$this->data['sidebar'] = SidebarRef::select('sidebars.*', 'sidebars_refs.id as srid')
			->where('sidebars_refs.id', $sidebarref->id)->join('sidebars', 'sidebars.id', '=', 'sidebars_refs.sidebar_id')->first();
		
		return View::make('backend/sidebars/itemref', $this->data);
	}

	public function getAjaxList()
	{
		$this->data['item_id'] = Input::get('item_id');
		$this->data['type'] = Input::get('type');
		$this->data['sidebars'] = $sidebars = Sidebar::orderBy('created_at')->get();
		return View::make('backend/sidebars/ajaxlist', $this->data);
	}
}