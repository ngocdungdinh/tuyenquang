@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
{{ $tag->name }} ::
@parent
@stop

{{-- Page content --}}
@section('content')
<h2 align="center">{{ $tag->name }}</h2>
<hr />
@if(isset($page) && $page <= 1)
<div class="row">
	<div class="home-featured-post col-sm-5 p7">
		@foreach ($posts as $key => $post)
			@if($key < 1)
					<a href="{{ $post->url() }}" title="{{ $post->title }}">
						@if($post->mtype == 'video')
							<span class="video-thumb">
								<img class="img-responsive full-width" src="{{ asset('http://i.ytimg.com/vi/'. $post->mname.'/0.jpg') }}" />
								<span class="play-icon small"><i class="ion-play"></i></span>
							</span>
						@elseif($post->mtype == 'image')
							<img src="{{ asset($post->mpath . '/500x300_crop/'. $post->mname) }}" width="100%" />						
						@else
							<img class="img-responsive full-width" src="/assets/img/noimage.jpg" />
						@endif</a>
					<h4 class=""><a href="{{ $post->url() }}" class="link-red" title="{{ $post->title }}" style="font-size: 20px;  line-height: 25px;">{{ $post->title }} 
					@include('frontend/news/frags/status')
					</a></h4>
					<p>{{ Str::words($post->excerpt, 50) }}</p>
					@if($post->relate_posts)
						@foreach($post->relates() as $pr)
							<p class="relate-post hidden-xs"><a href="{{ $pr->url() }}">{{ $pr->title }} @include('frontend/news/frags/status')</a></p>
						@endforeach
					@endif
			@endif
		@endforeach
	</div>
	<div class="col-sm-7 p7">
		<div class="row">
			@foreach ($posts as $key => $post)
				@if($key>=1 && $key < 7)
					<div class="news-item col-xs-6 col-sm-4 three" style="border-bottom: 0; padding-bottom: 10px;">
						<a href="{{ $post->url() }}" title="{{ $post->title }}">
						@if($post->mtype == 'video')
							<span class="video-thumb">
								<img class="img-responsive full-width" src="{{ asset('http://i.ytimg.com/vi/'. $post->mname.'/0.jpg') }}" />
								<span class="play-icon small"><i class="ion-play"></i></span>
							</span>
						@elseif($post->mtype == 'image')
							<img src="{{ asset($post->mpath . '/200x130_crop/'. $post->mname) }}" width="100%" />
						@else
							<img class="img-responsive full-width" src="/assets/img/noimage.jpg" />
						@endif</a>
						<h5 class="link-title"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} @include('frontend/news/frags/status')</a></h5>
					</div>
				@endif
			@endforeach
		</div>
	</div>
</div>
<hr />
@endif
<div class="row">
	<div class="col-md-6">
		<div class="box-info list-news">
			<div class="box-body">
				@foreach ($posts as $key => $post)
					@if($key>=7)
					<div class="list-news-item row">
						<div class="col-xs-5 p7">
							<a href="{{ $post->url() }}" title="{{ $post->title }}">
								@if($post->mtype == 'video')
									<span class="video-thumb">
										<img class="img-responsive full-width" src="{{ asset('http://i.ytimg.com/vi/'. $post->mname.'/0.jpg') }}" />
										<span class="play-icon small"><i class="ion-play"></i></span>
									</span>
								@elseif($post->mtype == 'image')
									<img class="img-responsive full-width" src="{{ asset($post->mpath . '/200x130_crop/'. $post->mname) }}" />
								@else
									<img class="img-responsive full-width" src="/assets/img/noimage.jpg" />
								@endif
							</a>
						</div>
						<div class="col-xs-7 p7">
							<h5 class="link-title cat"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} @include('frontend/news/frags/status')</a></h5>
							<p>{{ Str::words($post->excerpt, 24) }}</p>
							@if($post->relate_posts)
								@foreach($post->relates() as $pr)
									<p class="relate-post"><a href="{{ $pr->url() }}">{{ $pr->title }}</a></p>
								@endforeach
							@endif
						</div>
					</div>
					@endif
				@endforeach
			</div>
		</div>
		<div class="paging">
			{{ $posts->links() }}
		</div>
	</div>
	<div class="col-md-6 hidden-xs">
		<div class="row">
			<div class="col-sm-8 p7">
				<div class="box-info">
					<div style="padding: 5px;">
						<div class="fb-like-box" data-href="{{ Config::get('app.socialapp.facebook.url') }}" data-width="285" data-height="184" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
					</div>
				</div>
				<div class="box-info">
					<div class="sidestick-container">
						<div class="box-info" style="margin-top: 0">
							<ul class="nav nav-tabs nav-justified top-most-item">
								<li class="active"><a href="#most-view" data-toggle="tab">ĐỌC NHIỀU</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="most-view">
									@foreach ($mostview_post as $key => $post)
										<div class="news-item" style="overflow: hidden; margin-bottom: 8px; min-height: 50px;">
											<div style="width: 40px; height: 40px; float: left; border: 1px solid #dddddd; text-align: center; font-size: 20px; font-weight: bold; color: #ababab; padding-top: 10px;">{{ $key + 1 }}</div>
											<h6 class="link-title" style="margin-left: 50px; margin-top: 2px;"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} {{ $post->has_picture ? '<i class="ion-images fa-red"></i>' : '' }} {{ $post->has_video ? '<i class="ion-videocamera fa-red"></i>' : '' }}</a></h6>
										</div>
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-4 p7 ">		
				<div>
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
				<hr />
				<div align="center" class="hidden-xs" style="background-color: #eeeeee">
				</div>
			</div>
		</div>
	</div>
</div>
@stop
