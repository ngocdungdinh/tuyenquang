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
	<div class="box-body">
		@if($posts->count() > 0)
			<div class="row">
				@foreach($posts as $key => $post)
					@if($key < 1)
						<div class="col-sm-6">
							<div class="row">
								<div class="col-xs-6 col-sm-12">
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
								</div>
								<div class="col-xs-6 col-sm-12">
									<h5 class="link-title"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} @include('frontend/news/frags/status')</a></h5>
									<p class="p-desc hidden-xs">{{ Str::words($post->excerpt, 34) }}</p>
									@if($post->relate_posts)
										@foreach($post->relates() as $pr)
											<p class="relate-post"><a href="{{ $pr->url() }}">{{ $pr->title }}</a></p>
										@endforeach
									@endif
								</div>
							</div>
						</div>
						<hr style="margin: 8px 0" class="visible-xs" />
					@endif
				@endforeach
				<div class="col-sm-6">
					<div class="row">
						@foreach ($posts as $key => $post)
							@if($key>=1 & $key<3)
								<div class="news-item col-xs-6 col-sm-6 three" style="border-bottom: 0; padding-bottom: 10px;">
									<a href="{{ $post->url() }}" title="{{ $post->title }}">
										@if($post->mtype == 'video')
											<span class="video-thumb">
												<img class="img-responsive full-width" src="{{ asset('http://i.ytimg.com/vi/'. $post->mname.'/0.jpg') }}" />
												<span class="play-icon small"><i class="ion-play"></i></span>
											</span>
										@elseif($post->mtype == 'image')
											<img class="img-responsive full-width" src="{{ asset($post->mpath . '/200x130_crop/'. $post->mname) }}" width="100%" />
										@endif
									</a>
									<h5 class="link-title"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} @include('frontend/news/frags/status')</a></h5>
								</div>
							@elseif($key>=3)
								<div class="news-item col-xs-12">
									<h5 class="link-title"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} @include('frontend/news/frags/status')</a></h5>
								</div>
							@endif
						@endforeach
					</div>
				</div>
			</div>
		@endif
	</div>
</div>