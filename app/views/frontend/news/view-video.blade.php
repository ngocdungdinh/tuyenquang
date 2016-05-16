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
<script src="{{ asset('assets/bwplayer/jwplayer.js') }}"></script>
<script type="text/javascript">jwplayer.key="LCJI8vkwPQgeNSFPqCy/vgjJ6XqDCIX5IoV/javQukUgVWloh/vCmmuwsSk=";</script>
<div>
	<div class="row">
		<div class="col-sm-7" style="border-right: 1px solid #eeeeee">
			<div class="flex-video">
				<div id="player-{{ $post->id }}"></div>				
				<script type="text/javascript">
					jwplayer("player-{{ $post->id }}").setup({
						file:'https://www.youtube.com/watch?v={{ $post->mname }}?rel=0&showinfo=0&ps=docs&autoplay=0&autohide=1&iv_load_policy=3&vq=large&modestbranding=1&nologo=1&enablejsapi=1',
						width: "100%",
						aspectratio: "16:9",
						stretching: 'none',
						// stretching: 'exactfit',
						volume: "100",
						// menu: "true",
						// allowscriptaccess: "always",
						// wmode: "opaque",
						skin: "/assets/bwplayer/skin/six.xml",
						logo: {
							file: '/assets/img/logo-mobile.png',
							// link: 'http://phapluatxahoi.vn'
						},
					});
				</script>
				<!-- <iframe src="http://www.youtube.com/embed/{{ $post->mname }}?rel=0&showinfo=0&ps=docs&autoplay=0&autohide=1&iv_load_policy=3&vq=large&modestbranding=1&nologo=1&enablejsapi=1" frameborder="0" allowfullscreen="1"></iframe> -->
			</div>
			<div>
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
			</div>
			<div class="post-body">			
				<p class="news-content-excerpt"><strong>{{ $post->excerpt }}</strong></p>
				@if($post->relate_posts)
					@foreach($post->relates() as $pr)
						<p class="relate-post" style="line-height: 18px;"><a href="{{ $pr->url() }}">{{ $pr->title }} @include('frontend/news/frags/status')</a></p>
					@endforeach
				@endif
				<div>{{ $post->content }}</div>
			</div>
			@if($post_tags->count())
			<hr />
			<div class="news-tags">
				<strong><i class="fa fa-tags"></i></strong> 
					@foreach( $post_tags as $tag )
						<a class="tags_link" href="{{ URL::to('tags/'.$tag->slug) }}">{{ $tag->name }}</a> 
					@endforeach
			</div>
			@endif
			<hr />
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
		</div>
		<div class="col-sm-5" style="border-right: 1px solid #eeeeee">
			<!-- post tag -->
			<div class="box-info mg">
				<h4 class="title-more">
					Video mới
				</h4>
				<div>
					<div class="row">
						@foreach ($featured_videos as $key => $mp)
							@if($key>=1 && $key < 7)
								<div class="news-item col-xs-6 col-sm-6 col-md-4 three" style="border-bottom: 0; padding-bottom: 10px;">
									<a href="{{ $mp->url() }}" title="{{ $mp->title }}">
									@if($mp->mtype == 'video')
										<span class="video-thumb">
											<img class="img-responsive full-width" src="{{ asset('http://i.ytimg.com/vi/'. $mp->mname.'/0.jpg') }}" />
											<span class="play-icon small"><i class="ion-play"></i></span>
										</span>
									@elseif($mp->mtype == 'image')
										<img src="{{ asset($mp->mpath . '/200x130_crop/'. $mp->mname) }}" width="100%" />
									@else
										<img class="img-responsive full-width" src="/assets/img/noimage.jpg" />
									@endif</a>
									<h5 class="link-title" style="line-height: 17px; overflow: hidden"><a href="{{ $mp->url() }}" title="{{ $mp->title }}" style="font-weight: normal; font-size: 13px; line-height: 17px !important;">{{ $mp->title }} @include('frontend/news/frags/status')</a></h5>
								</div>
							@endif
						@endforeach
					</div>
				</div>				
			</div>
			<hr />
			<div class="box box-default">
				<div class="box-body">
					<div style="background-color: #f5f5f5; padding: 5px 10px; overflow: hidden">
						<p><strong>Nhận bản tin Pháp luật qua MXH</strong></p>
						<div class="fb-like" data-href="{{ Config::get('app.socialapp.facebook.url') }}" data-layout="standard" data-action="like" data-show-faces="false" data-share="false"></div>
					</div>
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
