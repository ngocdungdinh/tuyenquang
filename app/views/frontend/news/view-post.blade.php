@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
{{ $post->meta_title ? $post->meta_title : $post->title }} ::
@parent
@stop

{{-- Update the Meta Title --}}
@section('meta_title', $post->meta_title ? $post->meta_title : $post->title)
@section('meta_keywords', $post->meta_keywords.','.Config::get('settings.keywords'))
@section('meta_description', $post->meta_description ? $post->meta_description : $post->excerpt)
@section('meta_image', ($post->mname ? asset($post->mpath . '/550x500/'. $post->mname) : ''))

{{-- Page content --}}
@section('content')

<div>
	<div class="row">
		<div class="col-sm-6" style="border-right: 1px solid #eeeeee">
			@if($post->subtitle)
				<p style="font-weight: bold; color: #888;">{{ $post->subtitle }}</p>
			@endif
			<h3 style="color: #ba251e; margin: 4px 0">{{ $post->title }}</h3>	
			<div style="overflow: hidden; padding: 10px 0;">
				<span class="moment-date pull-left">{{ date("H:i - d/m/Y",strtotime($post->publish_date)) }}</span>
				<span class="pull-right hidden-xs">		
					@include('frontend/news/frags/sharebox')
				</span>
			</div>
			<div class="post-body">			
				<p class="news-content-excerpt"><strong>{{ $post->excerpt }}</strong></p>
				@if($post->relate_posts)
					@foreach($post->relates() as $pr)
						<p class="relate-post" style="line-height: 18px;"><a href="{{ $pr->url() }}">{{ $pr->title }} @include('frontend/news/frags/status')</a></p>
					@endforeach
				@endif
				<p>{{ $post->content }}</p>
			</div>
			<div style="margin: 20px 0; overflow: hidden; padding: 12px 10px 8px 10px; border: 1px solid #dddddd" align="center">
				<span class="pull-left" style="font-size: 18px;"><a href="#news-comments"><i class="fa fa-comments-o"></i> {{ $post->comment_count }} Bình luận</a></span>
				<span class="pull-right">@include('frontend/news/frags/sharebox')</span> 
			</div>
			<div class="box-info mg">
				<h4 class="title-more">
					Bài cùng chuyên mục
				</h4>
				<div class="row">
					@foreach ($category_posts as $key => $cp)
						<div class="col-sm-4 col-xs-6 p7 {{ $key == 2 ? ' hidden-xs' : '' }}">
							<a href="{{ $cp->url() }}" title="{{ $cp->title }}">
								@if($cp->mtype == 'video')
									<span class="video-thumb">
										<img class="img-responsive full-width" src="{{ asset('http://i.ytimg.com/vi/'. $cp->mname.'/0.jpg') }}" />
										<span class="play-icon small"><i class="ion-play"></i></span>
									</span>
								@elseif($cp->mtype == 'image')
									<img src="{{ asset($cp->mpath . '/200x130_crop/'. $cp->mname) }}" width="100%" />
								@endif
							</a>
							<h5 class="link-title"><a href="{{ $cp->url() }}" title="{{ $cp->title }}">{{ $cp->title }} {{ $cp->has_picture ? '<i class="ion-images fa-red"></i>' : '' }} {{ $cp->has_video ? '<i class="ion-videocamera fa-red"></i>' : '' }}</a></h5>
						</div>
					@endforeach
				</div>
			</div>
			@if($post_tags->count())
			<div class="news-tags">
				<strong>Tags:</strong> 
					@foreach( $post_tags as $tag )
						<a class="tags_link" href="{{ URL::to('tags/'.$tag->slug) }}">{{ $tag->name }}</a> 
					@endforeach
			</div>
			<hr />
			@endif
			<div class="box-info mg">
				<ul class="nav nav-tabs nav-justified top-most-item">
					<li class="active"><a href="#news-comments" data-toggle="tab" style="background-color: #f6f6f6"><i class="fa fa-comments-o"></i> Bình luận ({{ $post->comment_count }})</a></li>
					<li><a href="#facebook-comments" data-toggle="tab" style="background-color: #f6f6f6">Facebook</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="news-comments">
						<input type="hidden" id="currPostId" value="{{ $post->id }}">
						<div id="commentList">
							<div align="center"><img src="/assets/img/ajax-loader.gif" /></div>
						</div>
					</div>
					<div class="tab-pane" id="facebook-comments">
						<div class="fb-comments" data-href="{{ $post->url() }}" data-numposts="10" data-width="658"></div>
					</div>
				</div>
			</div>
			<div class="box-info mg">
				<hr />
				<h4 class="title-more">
					Tiêu điểm
				</h4>
				<div class="row">
					@foreach ($popular_posts as $key => $cp)
						<div class="{{ $key%3 == 0 ? ' col-xs-12' : ' col-xs-6' }}">
							<a href="{{ $cp->url() }}" title="{{ $cp->title }}">
								@if($cp->mtype == 'video')
									<span class="video-thumb">
										<img class="img-responsive full-width" src="{{ asset('http://i.ytimg.com/vi/'. $cp->mname.'/0.jpg') }}" />
										<span class="play-icon small"><i class="ion-play"></i></span>
									</span>
								@elseif($cp->mtype == 'image')
									<img src="{{ asset($cp->mpath . '/'.($key%3 == 0 ? '500x300_crop' : '320x210_crop').'/'. $cp->mname) }}" width="100%" />
								@endif</a>
							<h5 class="link-title" style="{{ $key%3 == 0 ? '' : 'height:60px;' }}"><a href="{{ $cp->url() }}" title="{{ $cp->title }}">{{ $cp->title }} {{ $cp->has_picture ? '<i class="ion-images fa-red"></i>' : '' }} {{ $cp->has_video ? '<i class="ion-videocamera fa-red"></i>' : '' }}</a></h5>
							<p style="margin-bottom: 14px; {{ $key%3 == 0 ? '' : ' display:none;' }}">{{ Str::words($cp->excerpt, 50) }}</p>
						</div>
					@endforeach
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-5 hidden-xs p7">
					<div class="box-stitle">ĐỌC NHIỀU</div>
					<div class="list-news">
						@foreach($mostview_post as $key => $post)
							@if($key < 2)
								<div class="news-item">
									<a href="{{ $post->url() }}" title="{{ $post->title }}">
										@if($post->mtype == 'video')
											<span class="video-thumb">
												<img class="img-responsive full-width" src="{{ asset('http://i.ytimg.com/vi/'. $post->mname.'/0.jpg') }}" />
												<span class="play-icon small"><i class="ion-play"></i></span>
											</span>
										@elseif($post->mtype == 'image')
											<img class="img-responsive full-width" src="{{ asset($post->mpath . '/320x210_crop/'. $post->mname) }}" width="100%" />
										@endif
									</a>
									<h5 class="link-title"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} {{ $post->has_picture ? '<i class="ion-images fa-red"></i>' : '' }} {{ $post->has_video ? '<i class="ion-videocamera fa-red"></i>' : '' }}</a></h5>
								</div>
							@elseif($key >= 2)
								<div class="news-item">
									<h6 class="link-title"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} {{ $post->has_picture ? '<i class="ion-images fa-red"></i>' : '' }} {{ $post->has_video ? '<i class="ion-videocamera fa-red"></i>' : '' }}</a></h6>
								</div>
							@endif
						@endforeach
					</div>
					<div class="sidestick-container">
		        		@if(isset($featured_tags))
							<div class="box-stitle" style="margin-top: 20px; margin-bottom: 0">CHỦ ĐỀ NÓNG</div>
							<div style="padding: 10px; background-color: #eeeeee">
		        				@foreach($featured_tags as $ht)
		        					<a href="/tags/{{ $ht->slug }}"><img class="img-responsive full-width" src="{{ asset($ht->mpath . '/200x130_crop/'. $ht->mname) }}" /></a>
		        					<a href="/tags/{{ $ht->slug }}" style="color: #000000; display: block; padding: 7px 0 14px 0">{{ $ht->name }}</a>
		        				@endforeach
							</div>
						@endif
					</div>
				</div>
				<div class="col-sm-7 p7">
					@if($parent_category)
						@foreach($parent_category->widgetsByPosition('right') as $w)
							{{ SWidget::getView($w) }}
						@endforeach
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">

	BB.updateViewCount('{{ $currPostId }}');
	BB.commentList('vote');
</script>
@stop
