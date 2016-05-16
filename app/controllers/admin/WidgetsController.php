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
use Widget;
use WidgetRef;
use Permission;
use User;
use Cache;
use Input;
use View;
use Redirect;
use Config;

class WidgetsController extends AdminController {

	/**
	 * Show the administration dashboard page.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		$this->data['widgets'] = $widgets = Widget::orderBy('created_at')->get();
		return View::make('widgets/index', $this->data);
	}
	
	public function getAjaxList()
	{
		$this->data['item_id'] 	= Input::get('item_id');
		$this->data['type'] 	= Input::get('type');
		$this->data['widgets'] 	= $widgets = Widget::orderBy('created_at')->where('status', 'on')->get();
		return View::make('widgets/ajaxlist', $this->data);
	}

	public function postStatus($id)
	{
		$widget = Widget::find($id);
		$widget->status = $widget->status == 'on' ? 'off' : 'on';
		$widget->save();

		return $widget->toJson();
	}

	public function postAddWidgetRef()
	{
		$item_id = Input::get('item_id');
		$widget_id = Input::get('widget_id');
		$type = Input::get('type');

		if(!is_null($widget = Widget::find($widget_id))) {
			$wr = new WidgetRef;
			$wr->item_id = $item_id;
			$wr->widget_id = $widget_id;
			$wr->type = $type;
			$wr->position = is_null(WidgetRef::first()) ? 1 : WidgetRef::orderBy('position', 'desc')->first()->position + 1;
			$wr->status = 'open';
			$wr->save();

			$wr->name = $widget->name;
			$wr->form = $widget->form;
			$wr->wrid = $wr->id;
			$wr->wrstatus = $wr->status;
			$this->data['widget'] = $wr;
			return View::make('widgets/itemref', $this->data);
		} else {
			return 0;
		}
	}
	public function getUpdateWidgetRef()
	{
		// get form blade
		$wrId = Input::get('id');		
		$this->data['widget'] = $widgetRef = WidgetRef::find($wrId);
		// print_r($widgetRef);
		
		$this->data['wdata'] = json_decode($widgetRef->content);

		// print_r($this->data['wdata']);
		if(is_null($widgetRef))
			return 0;

		$widget = Widget::find($widgetRef->widget_id);

		return View::make('widgets/'.$widget->form.'/edit', $this->data);
	}

	public function postUpdateWidgetRef()
	{
		$wrId = Input::get('id');
		$title = Input::get('title');	
		$this->data['widget'] = $wr = WidgetRef::find($wrId);
		$wr->title = $title;

		$inputs = Input::all();
		$wr->content = json_encode($inputs);

		$wr->save();
		return $wr->toJson();
	}

	public function postRemoveWidgetRef()
	{
		$wr = WidgetRef::find(Input::get('id'));
		if(!is_null($wr)) {
			$wr->delete();
			return 1;
		}
		return 0;
	}

	public function postUpdatePosition()
	{		
		$this->data['data_sort'] = $data_sort = Input::get('datasort');
		if($data_sort)
		{
			$sortArr = explode(',', $data_sort);
			if(count($sortArr > 1))
			{
				foreach ($sortArr as $sort) {
					if(isset($sort[0]) && $sort[0])
					{
						list($wr_id, $position) = explode(':', $sort);
						if($wr_id)
						{
							$wr = WidgetRef::find($wr_id);
							$wr->position = $position;
							$wr->save();
						}
					}
				}
				return 1;
			}
		}
		return 0;
	}
}