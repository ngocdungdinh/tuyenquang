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
		<div class="col-sm-12 p7">
				<div class="port-slideshow-p">
				  <!-- Image Carousel -->
				  <div id="port-slideshow-p" class="carousel slide" data-ride="carousel">
				    <!-- Wrapper for slides -->
				    <div class="carousel-inner">
						@foreach($posts as $key => $post)
						  <div class="item {{ $key == 0 ? 'active' : '' }}" >
							<a href="{{ $post->url() }}" title="{{ $post->title }}">
								<div style="max-height: 300px; overflow: hidden">
									<img class="img-responsive full-width" src="{{ asset($post->mpath . '/500x300_crop/'. $post->mname) }}" width="100%" />
								</div>
								<div>
									<h4 style="line-height: 24px;">
										{{ $post->title }}
									</h4>
									<p class="p-desc" style="height: 35px; overflow: hidden">
										{{ Str::words($post->excerpt, 50) }}
									</p>
								</div>
							</a>
						  </div>
						@endforeach
				    </div>
					<!-- Indicators -->
					<ol class="carousel-indicators">
						@foreach($posts as $key => $post)
							<li data-target="#port-slideshow-p" data-slide-to="{{$key}}" class="{{ $key == 0 ? 'active' : '' }}">
								<img class="img-responsive full-width" src="{{ asset($post->mpath . '/100x100_crop/'. $post->mname) }}" width="100" />
							</li>
						@endforeach
					</ol>
				    <!-- Controls -->
				    <a class="port-arrow-p port-arrow-prev bg-hover-color" href="#port-slideshow-p" data-slide="prev">
					  <i class="fa fa-angle-left"></i>
				    </a>
				    <a class="port-arrow-p port-arrow-next bg-hover-color" href="#port-slideshow-p" data-slide="next">
					  <i class="fa fa-angle-right"></i>
				    </a>
				  </div>
			    </div>
		</div>
		@endif
	</div>
</div>