<div class="box-home">
	@if(isset($wdata->showtitle) && $wdata->showtitle)
	<div class="box-title">
		<ul class="s-title">
			<li><a href="/{{ $category->slug }}" class="m-title pull-left">{{ $category->name }}</a></li>
			@foreach($category->subshomecats as $subcate)
				<li class="hidden-xs"><a href="/{{ $subcate->slug }}">{{ $subcate->name }}</a></li>
			@endforeach
		</ul>
	</div>
	@endif
	<div class="box-body row">
		@if($posts->count() > 0)		
			@foreach($posts as $key => $post)
				@if($key == 0)
					<div class="col-sm-12 p7">
						<div class="row">
							<div class="col-xs-6 col-sm-12">
								<a href="{{ $post->url() }}" title="{{ $post->title }}">
									@if($post->mtype == 'video')
										<span class="video-thumb">
											<img class="img-responsive full-width" src="{{ asset('http://i.ytimg.com/vi/'. $post->mname.'/0.jpg') }}" />
											<span class="play-icon small"><i class="ion-play"></i></span>
										</span>
									@elseif($post->mtype == 'image')
										<img src="{{ asset($post->mpath . '/500x300_crop/'. $post->mname) }}" width="100%" />
									@endif
								</a>
							</div>
							<div class="col-xs-6 col-sm-12">
								<h5 class="link-title"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} @include('frontend/news/frags/status')</a></h5>
								<p class="p-desc hidden-xs">{{ Str::words($post->excerpt, 24) }}</p>
								@if($post->relate_posts)
									@foreach($post->relates() as $pr)
										<p class="relate-post"><a href="{{ $pr->url() }}">{{ $pr->title }}</a></p>
									@endforeach
								@endif
							</div>
						</div>
					</div>
				@elseif($key > 0)
					<div class="col-sm-6 col-xs-12 p7">
						<div class="news-item small three">
							<a href="{{ $post->url() }}" title="{{ $post->title }}" class="hidden-xs">
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
						</div>
					</div>
				@endif
			@endforeach
		@endif
	</div>
</div>