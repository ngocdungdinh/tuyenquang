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
use Post;
use Category;
use Sidebar;
use Input;
use Str;
use Permission;
use User;
use Comment;
use Activity;
use Cache;
use Config;
use Datetime;
use Sentry;
use View;
use Analytics;
use Redirect;
use CategoryPost;

class DashboardController extends AdminController {

	/**
	 * Show the administration dashboard page.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		$this->data['start_day'] = $start_day = date('Y-m-d H:i:s', strtotime('today'));
        $this->data['curr_time'] = $curr_time = new Datetime();

		// $this->data['posts']['all'] = Post::newsposts()->paginate(10);
		$this->data['posts']['today'] = Post::countposts()->where('publish_date', '>', $start_day)->where('status', '!=', 'draft')->first();
		// print_r($this->data['posts']); die();

        $this->data['last_time'] = $last_time = date('Y-m-d H:i:s', strtotime("-15 minutes"));
		$this->data['users_online'] = User::where('last_activity', '>', $last_time)->orderBy('last_activity', 'DESC')->get();

		$this->data['ownposts'] = Post::withTrashed()->select('posts.*', 'medias.mpath', 'medias.mname', 'medias.mtype')->orderBy('created_at', 'desc')->leftJoin('medias', 'medias.id', '=', 'posts.media_id')->where('posts.post_type', 'post')->where('posts.user_id', '=', $this->u->id)->paginate(5);

		$this->data['comments'] = Comment::select('comments.*', 'users.first_name', 'users.last_name')->join('posts', 'posts.id', '=', 'comments.post_id')->leftJoin('users', 'users.id', '=', 'comments.user_id')
			->orderBy('comments.created_at', 'desc')
            ->where(function ($query) {
                if (!Sentry::getUser()->hasAnyAccess(['news','news.approvecomment']))
                    $query->where('comments.status', 'on');
            })
			->where('comments.created_at', '>', $start_day)
			->take(20)->get();

		// Show the page
		return View::make('backend/dashboard', $this->data);
	}

	public function postAnalytics() {
		$startDate = Input::get('startDate', '7daysAgo');
		$endDate = Input::get('endDate', 'today');
		$metrics = Input::get('metrics', 'ga:visits,ga:pageviews');
		$dimensions = Input::get('dimensions', 'ga:date');
		$sort = Input::get('sort', 'ga:date');
		$sort = Input::get('sort', 'ga:date');

		$typeReport = Input::get('typeReport', 'overview');

		$key = 'cache-analytic-reports-'.$typeReport;

		// Cache::flush();

		if(Cache::has($key)) {
			$reportData['rows'] =  Cache::get($key);
		} else {
			$site_id = Analytics::getSiteIdByUrl('http://phapluatxahoi.net'); // return something like 'ga:11111111'

			$stats = Analytics::query($site_id, $startDate, $endDate, $metrics, array('dimensions'=>$dimensions, 'sort' => $sort, 'max-results' => 15));

			Cache::put($key, $stats->rows, 10);
			$reportData['rows'] = $stats->rows;
		}
		// print_r($reportData);
		return json_encode($reportData);
	}

	public function getDeleteCaches()
	{
		$zone = Input::get('zone', 'home');
		
		// foreach (Cache::all() as $cacheKey => $cacheValue)
		// {

		//     // Cache::forget($cacheKey);
		//     echo $cacheKey.'<hr />';
		// }
		// die();

		if($zone == 'home') {
			$key = 'route-'.Str::slug(Config::get('app.url'));
			// die($key);
			$this->data['currentCat'] = $currentCat = Category::where('slug', 'trang-chu')->first();
			$sidebars = array(
					'mac-dinh',
					'home-left-0',
					'home-left-1',
					'home-right-0',
					'home-right-1',
					'home-left-2',
					'home-right-2'
				);

			foreach ($sidebars as $sidebar) {
		    	$currentCat->widgets($sidebar, true);
			}
			Cache::forget($key);

		} elseif($zone == 'other') {
			// Cache::flush();
		} elseif($zone == 'all') {
			Cache::flush();
		}
		return json_encode(array('status' => 1));
		// return Redirect::back();
	}
}
