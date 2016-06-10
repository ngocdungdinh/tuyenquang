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
use Lang;
use Category;
use Sidebar;
use SidebarRef;
use Seo;
use Redirect;
use Sentry;
use Str;
use Validator;
use View;

class CategoriesController extends AdminController {
	/**
	 * Show a list of all the categories.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Grab all the categories
		$categories = Category::where('parent_id', '=', 0)->orderBy('showon_menu', 'ASC')->get();

		// Show the page
		return View::make('backend/categories/index', compact('categories'));
	}

	/**
	 * News post create.
	 *
	 * @return View
	 */
	public function getCreate()
	{
		if ( !Sentry::getUser()->hasAnyAccess(['news','news.createcategory']) )			
			return View::make('backend/notallow');

		// Grab all the categories
		$categories = Category::where('parent_id', '=', 0)->orderBy('showon_menu', 'ASC')->get();
		// Show the page
		return View::make('backend/categories/create', compact('categories'));
	}
	/**
	 * News post create form processing.
	 *
	 * @return Redirect
	 */
	public function postCreate()
	{
		if ( !Sentry::getUser()->hasAnyAccess(['news','news.createcategory']) )
			return View::make('backend/notallow');

		// Declare the rules for the form validation
		$rules = array(
			'name'   => 'required|min:3',
			'showon_menu' => 'required|integer',
			'showon_homepage' => 'required|integer',
			'status' => 'required'
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		// Create a new news category
		$category = new Category;

		// Update the news category data
		$category->name            	= Input::get('name');
		$category->slug             = e(Str::slug(Input::get('name')));
		$category->parent_id        = e(Input::get('parent_id'));
		$category->showon_menu      = e(Input::get('showon_menu'));
		$category->showon_homepage  = e(Input::get('showon_homepage'));
		$category->status           = e(Input::get('status'));
		$category->user_id          = Sentry::getId();

		// Was the news category created?
		if($category->save())
		{
			// Redirect to the new news category page
			return Redirect::to("admin/categories/$category->id/edit")->with('success', Lang::get('admin/categories/message.create.success'));
		}

		// Redirect to the news category create page
		return Redirect::to('admin/categories/create')->with('error', Lang::get('admin/categories/message.create.error'));
	}

	/**
	 * News category update.
	 *
	 * @param  int  $catId
	 * @return View
	 */
	public function getEdit($catId = null)
	{
		if ( !Sentry::getUser()->hasAnyAccess(['news','news.editcategory']) )
			return View::make('backend/notallow');

		// Check if the news category exists
		if (is_null($category = Category::with('seo')->find($catId)))
		{
			// Redirect to the news management page
			return Redirect::to('admin/categories')->with('error', Lang::get('admin/categories/message.does_not_exist'));
		}
		if($category->seo->count() <= 0) {
			$seo = new Seo;
			$seo->updateFromInput();
			$category->seo()->save($seo);
		}

		if($category->sidebars->count() <= 0) {
			$sidebar = new SidebarRef;
			$sidebar->sidebar_id = 1;
			$category->sidebars()->save($sidebar);
		}
		// Grab all the categories
		$categories = Category::where('parent_id', '=', 0)->orderBy('showon_menu', 'ASC')->get();

		$this->data['seo'] = isset($category->seo[0]) ? $category->seo[0] : new Seo;
		$this->data['categories'] = $categories;
		$this->data['category'] = $category;
		$this->data['sidebars'] = $sidebars = Sidebar::orderBy('created_at')->get();
		// Show the page
		return View::make('backend/categories/edit', $this->data);
	}

	/**
	 * News Category update form processing page.
	 *
	 * @param  int  $catId
	 * @return Redirect
	 */
	public function postEdit($catId = null)
	{
		if ( !Sentry::getUser()->hasAnyAccess(['news','news.editcategory']) )
			return View::make('backend/notallow');

		// Check if the news category exists
		if (is_null($category = Category::find($catId)))
		{
			// Redirect to the news management page
			return Redirect::to('admin/categories')->with('error', Lang::get('admin/categories/message.does_not_exist'));
		}

		// Declare the rules for the form validation
		$rules = array(
			'name'   => 'required|min:3',
			'showon_menu' => 'required|integer',
			'showon_homepage' => 'required|integer',
			'status' => 'required'
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		// Update the news post data
		$category->name            	= Input::get('name');
		$category->slug             = e(Str::slug(Input::get('name')));
		$category->parent_id        = e(Input::get('parent_id'));
		$category->showon_menu      = e(Input::get('showon_menu'));
		$category->showon_homepage  = e(Input::get('showon_homepage'));
		$category->showon_position  = e(Input::get('showon_position'));
		$category->status           = e(Input::get('status'));

		// Was the news post updated?
		if($category->save())
		{

			// // update Seos
			$seo = Seo::find($category->seo[0]->id);
			$seo->updateFromInput();

			// Redirect to the new news category page
			//return Redirect::to("admin/categories/$catId/edit")->with('success', Lang::get('admin/categories/message.update.success'));
			return Redirect::to("admin/categories/")->with('success', Lang::get('admin/categories/message.update.success'));
		}

		// Redirect to the categories category management page
		return Redirect::to("admin/categories/$catId/edit")->with('error', Lang::get('admin/categories/message.update.error'));
	}

	/**
	 * Delete the given news post.
	 *
	 * @param  int  $catId
	 * @return Redirect
	 */
	public function getDelete($catId)
	{
		if ( !Sentry::getUser()->hasAnyAccess(['news','news.deletecategory']) )
			return View::make('backend/notallow');

		// Check if the news post exists
		if (is_null($category = Category::find($catId)))
		{
			// Redirect to the news management page
			return Redirect::to('admin/categories')->with('error', Lang::get('admin/categories/message.not_found'));
		}

		if($category->parent_id==0) {
			foreach ($category->subscategories as $subcate) {
				$subcate->parent_id = 0;
				$subcate->save();
			}
		}

		// Delete the categories category
		$category->delete();

		// Redirect to the categories posts management page
		return Redirect::to('admin/categories')->with('success', Lang::get('admin/categories/message.delete.success'));
	}
}