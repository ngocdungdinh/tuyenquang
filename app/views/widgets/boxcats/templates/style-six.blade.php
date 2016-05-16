<div class="box-home">
	@if(isset($wdata->showtitle) && $wdata->showtitle)
	<div class="box-title">
		<a href="/{{ $category->slug }}" class="m-title">{{ $category->name }}</a>
	</div>
	@endif
	<div class="box-body row">
		@if($posts->count() > 0)		
			@foreach($posts as $key => $post)
				@if($key == 0)
					<div class="col-sm-12 p7">
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
						<h5 class="link-title"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} @include('frontend/news/frags/status')</a></h5>
						<p class="p-desc hidden-xs">{{ Str::words($post->excerpt, 35) }}</p>
						@if($post->relate_posts)
							@foreach($post->relates() as $pr)
								<p class="relate-post"><a href="{{ $pr->url() }}">{{ $pr->title }}</a></p>
							@endforeach
						@endif
					</div>
				@elseif($key > 0)
					<div class="col-sm-12 p7">
						<div class="news-item">
							<h5 class="link-title"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} @include('frontend/news/frags/status')</a></h5>
						</div>
					</div>
				@endif
			@endforeach
		@endif
	</div>
</div>