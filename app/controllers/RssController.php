<?php
/**
* Create Rss feed
*/
class RssController extends BaseController
{
	public function getRss($catSlug = '')
	{
		if($catSlug == 'index') {
			// default index rss
			$this->data['posts'] = Post::select('posts.*', 'medias.mpath', 'medias.mtype', 'medias.mname')
			->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
			->where('status', 'published')
			->where('post_type', 'post')
			->where('posts.publish_date', '<=', new Datetime())
			->orderBy('publish_date', 'DESC')->remember(10)->take(10)->get();
		} elseif ($catSlug == 'featured') {
			$this->data['posts'] = Post::select('posts.*', 'medias.mpath', 'medias.mtype', 'medias.mname')
			->join('medias', 'medias.id', '=', 'posts.media_id')
        	->join('posts_position', 'posts_position.post_id', '=', 'posts.id')
			->where('posts_position.type', 'home')
			->where('post_type', 'post')
			->where('status', 'published')
			->where('posts.publish_date', '<=', new Datetime())
			->orderBy('posts_position.position', 'ASC')
			->take(Config::get('settings.featured_posts', 12))->remember(30)->get();
		} elseif ($catSlug == 'video') {
			$category = Category::where('slug', $catSlug)->first();
			if (is_null($category))
			{
				return App::abort(404);
			}
			$this->data['posts'] = $category->rposts()->select('posts.*', 'medias.mpath', 'medias.mname', 'medias.mtype')
			->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
			->where('status', 'published')
			->where('post_type', 'post')
		    ->where('posts.publish_date', '<=', new Datetime())
			->orderBy('publish_date', 'DESC')
			->remember(10)
			->take(10)->get();
		}else {
			$postion = strpos($catSlug,'video');
			if($postion !== false && $postion == 0) {
				$str = str_replace('video-', '', $catSlug);
				$category = Category::where('slug', $str)->where('parent_id',1008)->first();
			} else {
				$category = Category::where('slug', $catSlug)->first();
			}
			
			// Check if the news category exists
			if (is_null($category))
			{
				return App::abort(404);
			}
			// Get all the news posts
			$this->data['posts'] = $category->rposts()->select('posts.*', 'medias.mpath', 'medias.mname', 'medias.mtype')
			->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
			->where('status', 'published')
			->where('post_type', 'post')
		    ->where('posts.publish_date', '<=', new Datetime())
			->orderBy('publish_date', 'DESC')
			->remember(10)
			->take(10)->get();
		}
		//bắt đầu RSS.
		$xml = "<rss xmlns:slash=\"http://purl.org/rss/1.0/modules/slash/\" version=\"2.0\">";
		$xml .= "<channel>";
		$xml .= "<title>";
		$xml .= "<![CDATA[ ".(isset($category->name) ? $category->name.' - ' : 'Trang chủ - ')." ".Config::get('settings.sitename')." ]]>";
		$xml .= "</title>";
		$xml .= "<link>";
		$xml .= "<![CDATA[". Config::get('app.url') . (isset($category->slug) ? '/'.$category->slug: '')."]]>";
		$xml .= "</link>";
		$xml .= "<description>";
		$xml .= "<![CDATA[ ".(isset($category->name) ?  "Chuyên mục " .$category->name.' - ' : '')." ".Config::get('settings.sitename')."  ]]>";
		$xml .= "</description>";
		$xml .= "<ttl>10</ttl>";
		$xml .= "<copyright>". Config::get('app.url') ."</copyright>";
		$xml .= "<pubDate>".date('m/d/Y H:i:s A',time())."</pubDate>";
		$xml .= "<generator><![CDATA[".Config::get('settings.sitename')."]]></generator>";
		$xml .= "<docs>". Config::get('app.url') ."</docs>";
		if(count($this->data['posts']) > 0) {
			foreach ($this->data['posts'] as $key => $post)
			{
				$xml .= "<item>";
				$xml .= "<title><![CDATA[ ".$post->title." ]]></title>";
				$xml .= "<link><![CDATA[".$post->url()."]]></link>";
				$xml .= "<guid isPermaLink=\"false\"><![CDATA[".$post->url()."]]></guid>";
				$xml .= "<description><![CDATA[<a href='".$post->url()."' >";
				if($post->mtype == 'video') {
					$xml .= "<img border='0' alt='".$post->title."' src=\"".asset('http://i.ytimg.com/vi/'. $post->mname.'/0.jpg')."\"/>";
				} else {
					$xml .= "<img border='0' alt='".$post->title."' src=\"".url($post->mpath . '/150x100_crop/'. $post->mname)."\" />";
				}
				$xml .= "</a>".$post->excerpt."]]></description>";
				$xml .= "<pubDate>".$post->publish_date."</pubDate>";
				$xml .= "</item>";
			}
		}
		$xml .= "</channel></rss>";
		//kết thúc tạo RSS
		return Response::make($xml, 200, array('Content-Type' => 'text/xml'));
	}
}
?>