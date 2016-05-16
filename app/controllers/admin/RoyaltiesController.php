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
use Redirect;
use Permission;
use Sentry;
use Str;
use Royalty;
use Category;
use Post;
use User;
use Validator;
use View;
use Input;
use Lang;
use DB;

class RoyaltiesController extends AdminController {

	public function getRoyalties()
	{
		$this->data['start_date'] = Input::get('start_date', date("Y-m-d H:i:s", strtotime('first day of this month')));
		$this->data['end_date'] = Input::get('end_date', date("Y-m-d H:i:s", strtotime("now")));

		$this->data['categories'] = Category::orderBy('showon_menu', 'ASC')->get();
		$this->data['writers'] = Sentry::findAllUsersWithAccess('admin');

		$this->data['type'] = $type = Input::get('type', 0);
		$this->data['user_id'] = $user_id = Input::get('user_id', 0);
		$this->data['category_id'] = $category_id = Input::get('category_id', 0);
		// Grab the news posts
		
		$this->data['appends'] = array(
			'type' => $type,
			'user_id' => $user_id,
			'category_id' => $category_id,
		);

		$this->data['posts'] = $posts = Post::select('*', 'posts.id as id', 'royalties.id as rid')
		->join('royalties', 'royalties.item_id', '=', 'posts.id')
		->where('royalties.item_type', 'post')
		->where('posts.post_type', 'post')
		->where('posts.status', 'published')
		->where(function($query){
			if($this->data['category_id'])
				$query->where('posts.category_id', '=', $this->data['category_id']);
		})
		->where(function($query){
			if($this->data['user_id'])
				$query->where('posts.user_id', '=', $this->data['user_id']);
		})
		->where(function($query){
			if($this->data['type'])
			{
				switch ($this->data['type']) {
					case 'mostview':
						$query->orderBy('view_count', 'desc');
						break;
				}
			} else {
				$query->orderBy('posts.created_at', 'DESC');
			}
		})
		->where('posts.publish_date', '>=', $this->data['start_date'])
		->where('posts.publish_date', '<=', $this->data['end_date'])
		->orderBy('posts.created_at', ($this->data['type'] && $this->data['type']=='oldest' ? 'asc' : 'desc'))
		->get();

		$counts = array();
		foreach ($posts as $key => $post) {
			if(!isset($counts['cat'][$post->category_id]['count']))
				$counts['cat'][$post->category_id]['count'] = 0;
			$counts['cat'][$post->category_id]['count'] = $counts['cat'][$post->category_id]['count'] + 1;
			
			if(!isset($counts['user'][$post->user_id]['count']))
				$counts['user'][$post->user_id]['count'] = 0;
			$counts['user'][$post->user_id]['count'] = $counts['user'][$post->user_id]['count'] + 1;

			if(!isset($counts['royal']['royalty']))
				$counts['royal']['royalty'] = 0;
			$counts['royal']['royalty'] = $counts['royal']['royalty'] + $post->royalty;

			if(!isset($counts['royal']['tax']))
				$counts['royal']['tax'] = 0;
			$counts['royal']['tax'] = $counts['royal']['tax'] + $post->tax;

			if(!isset($counts['royal']['total']))
				$counts['royal']['total'] = 0;
			$counts['royal']['total'] = $counts['royal']['total'] + $post->total;

			# code...
		}
		$this->data['counts'] = $counts;

		return View::make('backend/royalties/index', $this->data);
	}

	public function getRoyaltyForm()
	{
		// get exist royal_id
		$this->data['royal_id'] = $royal_id = Input::get('royal_id', 0);
		$this->data['item_id'] = $item_id	= Input::get('item_id', 0);
		$this->data['writer'] = User::find(Input::get('writer_id', 0));

		$this->data['writers'] = Sentry::getUserProvider()->createModel()->select('id', DB::raw('CONCAT(first_name, " ",last_name) as name'))->get();
		$this->data['writers'] = $this->data['writers']->toJson();

		$this->data['royalty'] = Royalty::find($royal_id);

		return View::make('backend/royalties/form', $this->data);
	}

	public function postRoyaltyForm()
	{
		$royal_id 		= Input::get('royal_id', 0);
		$item_id 		= Input::get('item_id', 0);
		$user_id 		= Input::get('user_id', 0);
		$royalty 			= Input::get('royalty', 0);
		$tax 			= Input::get('tax', 0);
		$description 	= Input::get('description', '');
		$received 		= Input::get('received', 0);

		$royal = Royalty::find($royal_id);
		if(is_null($royal)) {
			$royal = new Royalty;
		}
		// insert new royal
		$royal->user_id = $user_id;
		$royal->item_id = $item_id;
		$royal->item_type = 'post';
		$royal->royalty = $royalty;
		$royal->tax = $tax;
		$royal->total = $royalty - $tax;
		$royal->description = $description;
		$royal->received = $received;
		$royal->save();

		// find all royal at this item
		$this->data['royalties'] = Royalty::select("*")
			->where('item_type', 'post')
			->where('item_id', $item_id)
			->get();
		$this->data['royalyTotal'] = Royalty::select('*')
			->where('item_type', 'post')
			->where('item_id', $item_id)
			->sum('total');

		return View::make('backend/royalties/ajax_list', $this->data);
	}

	public function getRoyaltyDelete()
	{		
		$royal_id 		= Input::get('royal_id', 0);
		$royal = Royalty::find($royal_id);
		if(is_null($royal)) {
			return false;
		}		
		$item_id = $royal->item_id;
		$royal->delete();

		// find all royal at this item
		$this->data['royalties'] = Royalty::select("*")
			->where('item_type', 'post')
			->where('item_id', $item_id)
			->get();
		$this->data['royalyTotal'] = Royalty::select('*')
			->where('item_type', 'post')
			->where('item_id', $item_id)
			->sum('total');

		return View::make('backend/royalties/ajax_list', $this->data);
	}
}