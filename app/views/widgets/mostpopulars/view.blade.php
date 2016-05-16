@if($wdata->status == 'open')
<?
	$curr_time = new Datetime;
	$last_week = $curr_time->modify('-'.$wdata->backdays.' day');

	$mostview_post = Post::select('posts.*', 'medias.mpath', 'medias.mtype', 'medias.mname')
		->leftJoin('medias', 'medias.id', '=', 'posts.media_id')
		->where('status', 'published')
		->where('post_type', 'post')
		->where('publish_date', '>', $last_week)
		->where('posts.publish_date', '<=', new Datetime())
		->orderBy('view_count', 'DESC')->take($wdata->limit)->remember(25)->get();
		

?>
	@if(isset($wdata->showtitle) && $wdata->showtitle == 'yes')
		<h3 class="headline text-color">
			<span class="border-color">{{ $widget->title }}</span>
		</h3>
	@endif
	
	<div class="box-info" style="margin-top: 4px;">
		<ul class="nav nav-tabs nav-justified top-most-item">
			@if($wdata->mostview == 'yes')
				<li class="active"><a href="#most-view" data-toggle="tab">ĐỌC NHIỀU</a></li>
			@endif
			@if($wdata->mostcomment == 'yes')
				<li><a href="#getmostcomments" data-toggle="tab" onclick="BB.getPopularPosts('getmostcomments')">PHẢN HỒI</a></li>
			@endif
			@if($wdata->lastest == 'yes')
				<li><a href="#getlastestposts" data-toggle="tab" onclick="BB.getPopularPosts('getlastestposts')">MỚI NHẤT</a></li>
			@endif
		</ul>
		<div class="tab-content tab-mostitem-content">
			@if($wdata->mostview == 'yes')
				<div class="tab-pane active" id="most-view">
					@foreach ($mostview_post as $key => $post)
						<div class="news-item" style="overflow: hidden; margin-bottom: 8px; min-height: 50px;">
							<div style="width: 40px; height: 40px; float: right; border: 1px solid #dddddd; text-align: center; font-size: 20px; font-weight: bold; color: #ababab; padding-top: 10px;">{{ $key + 1 }}</div>
							<h6 class="link-title" style="margin-right: 50px; margin-top: 2px;"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} @include('frontend/news/frags/status')</a></h6>
						</div>
					@endforeach
				</div>
			@endif
			@if($wdata->mostcomment == 'yes')
				<div class="tab-pane" id="getmostcomments">
					<div align="center">
						<img src="/assets/img/ajax-loader.gif" />
					</div>
				</div>
			@endif
			@if($wdata->lastest == 'yes')
				<div class="tab-pane" id="getlastestposts">
					<div align="center">
						<img src="/assets/img/ajax-loader.gif" />
					</div>
				</div>
			@endif
		</div>
	</div>
@endif