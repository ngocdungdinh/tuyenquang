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
			@foreach($posts as $key => $post)
				@if($key == 0)
					<div class="p7">
						<a href="{{ $post->url() }}" title="{{ $post->title }}">
							<div class="video-thumb">
								@if($post->mtype == 'video')
									<img class="img-responsive full-width" src="{{ asset('http://i.ytimg.com/vi/'. $post->mname.'/0.jpg') }}" />
									<span class="play-icon"><i class="ion-play"></i></span>
								@elseif($post->mtype == 'image')
									<img class="img-responsive full-width" src="{{ asset($post->mpath . '/500x300_crop/'. $post->mname) }}" />
									<span class="play-icon"><i class="ion-play"></i></span>
								@endif
							</div>
							<div style="margin-bottom: 15px;">
								<h4>
									{{ $post->title }}
								</h4>
								<p class="p-desc">
									{{ Str::words($post->excerpt, 50) }}
								</p>
							</div>
						</a>
					</div>				
				@endif
			@endforeach
			<div class="video-slideshow-p">
			  <!-- Image Carousel -->
			  <div id="video-slideshow-p" class="carousel slide" data-ride="carousel">
			    <!-- Wrapper for slides -->
			    <div class="carousel-inner">
			    	<div class="item active row" >
						@foreach($posts as $key => $post)
							@if( $key >= 1 && $key < 4)
								<div class="col-sm-4 p7 hidden-xs">
									<a href="{{ $post->url() }}" title="{{ $post->title }}">
										<div class="video-thumb">
											@if($post->mtype == 'video')
												<img class="img-responsive full-width" src="{{ asset('http://i.ytimg.com/vi/'. $post->mname.'/0.jpg') }}" />
												<span class="play-icon small"><i class="ion-play"></i></span>
											@elseif($post->mtype == 'image')
												<img class="img-responsive full-width" src="{{ asset($post->mpath . '/320x210_crop/'. $post->mname) }}" />
												<span class="play-icon small"><i class="ion-play"></i></span>
											@endif
										</div>
									</a>
									<h5 class="link-title" style="font-weight: normal"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }}</a></h5>
								</div>
							@endif
						@endforeach
					</div>
			    	@if($posts->count()>=4)
			    	<div class="item row" >
						@foreach($posts as $key => $post)
							@if( $key >= 4 && $key < 7)
								<div class="col-sm-4 p7 hidden-xs">
									<a href="{{ $post->url() }}" title="{{ $post->title }}">
										<div class="video-thumb">
											@if($post->mtype == 'video')
												<img class="img-responsive full-width" src="{{ asset('http://i.ytimg.com/vi/'. $post->mname.'/0.jpg') }}" />
												<span class="play-icon small"><i class="ion-play"></i></span>
											@elseif($post->mtype == 'image')
												<img class="img-responsive full-width" src="{{ asset($post->mpath . '/320x210_crop/'. $post->mname) }}" />
												<span class="play-icon small"><i class="ion-play"></i></span>
											@endif
										</div>
									</a>
									<h5 class="link-title" style="font-weight: normal"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }}</a></h5>
								</div>
							@endif
						@endforeach
					</div>
					@endif
			    </div>
			    <!-- Controls -->
			    <a class="port-arrow-p port-arrow-prev bg-hover-color" href="#video-slideshow-p" data-slide="prev">
				  <i class="fa fa-angle-left"></i>
			    </a>
			    <a class="port-arrow-p port-arrow-next bg-hover-color" href="#video-slideshow-p" data-slide="next">
				  <i class="fa fa-angle-right"></i>
			    </a>
			  </div>
			</div>
		@endif
	</div>
</div>