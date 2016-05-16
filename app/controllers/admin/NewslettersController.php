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
use Newsletter;
use Redirect;
use Sentry;
use Str;
use Validator;
use View;

class NewslettersController extends AdminController {

	public function getIndex() {
		$this->data['type'] = $type = Input::get('type');
		$this->data['newsletters'] = $newsletters = Newsletter::withTrashed()->select('newsletters.*', 'users.id as uid', 'users.username', 'users.first_name', 'users.last_name')
			->leftJoin('users', 'users.id', '=', 'newsletters.user_id')

		->where(function($query){
			if($this->data['type'] == 'trash') {
				$query->whereNotNull('newsletters.deleted_at');
			} else if($this->data['type'] && $this->data['type'] !== 'user') {
				$query->where('newsletters.ntype', $this->data['type']);
			} else if($this->data['type'] == 'user') {
				$query->where('newsletters.user_id', '>', 0);
			}
		})
		->orderBy('newsletters.created_at', 'desc')
		->paginate(20);

		return View::make('backend/newsletters/index', $this->data);
	}

	public function getInvalid($nId, $status)
	{

		// Check if the news post exists
		if (is_null($newsletter = Newsletter::find($nId)))
		{
			// Redirect to the news management page
			return Redirect::to('admin/newsletters')->with('error', Lang::get('admin/news/message.not_found'));
		}
		if($status) {
			$newsletter->ntype = 'invalid';
		} else {
			$newsletter->ntype = $newsletter->user_id ? 'user' : 'guest';
		}
		
		$newsletter->save();

		return Redirect::to('admin/newsletters')->with('success', Lang::get('general.success'));
	}

	public function getDelete($nId)
	{

		// Check if the news post exists
		if (is_null($newsletter = Newsletter::find($nId)))
		{
			// Redirect to the news management page
			return Redirect::to('admin/newsletters')->with('error', Lang::get('admin/news/message.not_found'));
		}
		
		$newsletter->delete();

		return Redirect::to('admin/newsletters')->with('success', Lang::get('general.success'));
	}

	public function getRestore($nId)
	{

		// Check if the news post exists
		if (is_null($newsletter = Newsletter::withTrashed()->find($nId)))
		{
			// Redirect to the news management page
			return Redirect::to('admin/newsletters')->with('error', Lang::get('admin/news/message.not_found'));
		}
		
		$newsletter->restore();

		return Redirect::to('admin/newsletters')->with('success', Lang::get('general.success'));
	}
}