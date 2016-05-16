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
use Category;
use Post;
use Menu;
use MenuLink;
use DateTime;
use Redirect;
use Sentry;
use Str;
use Validator;
use View;
use Config;

class MenusController extends AdminController {

	public function getIndex()
	{
		$this->data['menus'] = Menu::select('*')->get();
		$this->data['mId'] = $mId = Input::get('m', 0);

        $this->data['categories'] = Category::orderBy('showon_menu', 'ASC')->get();
        $this->data['pages'] = $pages = Post::where('post_type', 'page')->get();

		if($mId) 
		{
			$this->data['links'] = MenuLink::select('menu_links.*', 'categories.name as cat_name', 'categories.slug as cat_slug')
				->leftJoin('categories', 'categories.id', '=', 'menu_links.item_id')
				->where('menu_links.parent_id', 0)
				->where('menu_links.menu_id', $mId)
				->orderBy('menu_links.position', 'ASC')
				->get();
		}

		// Show the page
		return View::make('backend/menus/index', $this->data);
	}

	public function postCreate()
	{
		if ( !Sentry::getUser()->hasAnyAccess(['menus','menus.create']) )
			return View::make('backend/notallow');

		$this->data['menu_id'] = $menu_id = Input::get('menu_id', 0);

		// Declare the rules for the form validation
		$rules = array(
			'title'   => 'required',
			'position' => 'required',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		if(isset($menu_id) && $menu_id)
		{		
			// update a new news menu
			$menu = Menu::find($menu_id);
		} else {
			// Create a new news menu
			$menu = new Menu;
		}

		// Update the news menu data
		$menu->title            = Input::get('title');
		$menu->position        	= e(Input::get('position'));
		$menu->status      		= 'on';

		// Was the news menu created?
		if($menu->save())
		{
			// Redirect to the new news menu page
			return Redirect::to("admin/menus")->with('success', Lang::get('general.success'));
		}

		// Redirect to the news category create page
		return Redirect::to('admin/menus')->with('error', Lang::get('general.error'));
	}



	public function postLinkCreate()
	{
		if ( !Sentry::getUser()->hasAnyAccess(['menus','menus.create']) )
			return View::make('backend/notallow');

		$this->data['link_id'] = $link_id = Input::get('link_id', 0);

		$link_type            	= Input::get('type', 'custom');
		// Declare the rules for the form validation
		if($link_type == 'custom') {
			$rules = array(
				'title'   => 'required',
				'url' => 'required',
				'menu_id' => 'required',
				'type' => 'required',
			);
		} else {
			$rules = array(
				'item_id'   => 'required',
				'menu_id' => 'required',
				'type' => 'required',
			);
		}

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		if(isset($link_id) && $link_id)
		{		
			// update a new news menu
			$link = MenuLink::find($link_id);
		} else {
			// Create a new news menu
			$link = new MenuLink;	
		}

		if($link_type == 'category') {
			// get category
			$link->item_id          = Input::get('item_id');
			$category = Category::find($link->item_id);
			$link->title            = $category->name;
			$link->alt            	= $category->name;
			$link->url        		= '/'.$category->slug;
		} elseif($link->type == 'page') {
			// get category
			$link->item_id          = Input::get('item_id');
			$post = Post::find($link->item_id);
			$link->title            = $post->title;
			$link->alt            	= $post->title;
			$link->url        		= '/page/'.$post->slug;
		} else {
			$link->title            = Input::get('title');
			$link->alt            	= Input::get('alt');
			$link->url        		= Input::get('url');
		}
		
		if(isset($link_id) && $link_id) {
			$link->title            = Input::get('title');
			$link->alt            	= Input::get('alt');
		}

		$link->type          = $link_type;
		// Update the news menu data
		$link->target        	= Input::get('target');
		$link->menu_id        	= Input::get('menu_id');
		$link->parent_id        = Input::get('parent_id');
		// print_r($link);
		// die();
		// Was the news menu created?
		if($link->save())
		{
			// Redirect to the new news menu page
			return Redirect::to("admin/menus?m=".$link->menu_id)->with('success', Lang::get('general.success'));
		}

		// Redirect to the news category create page
		return Redirect::to("admin/menus?m=".$link->menu_id)->with('error', Lang::get('general.error'));
	}

	public function updateLinksPosition() {
		if ( !Sentry::getUser()->hasAnyAccess(['menus','menus.full']) )
			return View::make('backend/notallow');
	    $source       = e(Input::get('source'));
	    $destination  = e(Input::get('destination', 0));

	    $item             = MenuLink::find($source);
	    $item->parent_id  = $destination;  
	    $item->save();

	    $ordering       = json_decode(Input::get('order'));
	    $rootOrdering   = json_decode(Input::get('rootOrder'));

	    if($ordering){
	      foreach($ordering as $order=>$item_id){
	        if($itemToOrder = MenuLink::find($item_id)){
	            $itemToOrder->position = $order;
	            $itemToOrder->save();
	        }
	      }
	    } else {
	      foreach($rootOrdering as $order=>$item_id){
	        if($itemToOrder = MenuLink::find($item_id)){
	            $itemToOrder->position = $order;
	            $itemToOrder->save();
	        }
	      }
	    }

	    return 'ok ';
	}
	
	/**
	 * Delete the given news post.
	 *
	 * @param  int  $catId
	 * @return Redirect
	 */
	public function getDelete($menuId)
	{
		if ( !Sentry::getUser()->hasAnyAccess(['menus','menus.delete']) )
			return View::make('backend/notallow');

		// Check if the news post exists
		if (is_null($menu = Menu::find($menuId)))
		{
			// Redirect to the news management page
			return Redirect::to('admin/menus')->with('error', Lang::get('general.error'));
		}

		// Delete the categories category
		$menu->delete();

		// Redirect to the news category create page
		return Redirect::to("admin/menus")->with('success', Lang::get('general.success'));
	}

	/**
	 * Delete the given news post.
	 *
	 * @param  int  $catId
	 * @return Redirect
	 */
	public function getLinkDelete($linkId)
	{
		if ( !Sentry::getUser()->hasAnyAccess(['menus','menus.delete']) )
			return View::make('backend/notallow');

		// Check if the news post exists
		if (is_null($link = MenuLink::find($linkId)))
		{
			// Redirect to the news management page
			return Redirect::to('admin/menus')->with('error', Lang::get('general.error'));
		}

		$menu_id = $link->menu_id;
		// Delete the categories category
		$link->delete();

		// Redirect to the news category create page
		return Redirect::to("admin/menus?m=".$menu_id)->with('success', Lang::get('general.success'));
	}
}