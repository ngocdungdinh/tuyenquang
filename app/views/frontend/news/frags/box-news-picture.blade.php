<div class="box-home">
	<div class="box-title">
		<a href="/{{ $category['data']->slug }}" class="m-title">{{ $category['data']->name }}</a>
		<ul class="s-title">
			@foreach($category['data']->subshomecats as $subcate)
				<li><a href="/{{ $subcate->slug }}">{{ $subcate->name }}</a></li>
			@endforeach
		</ul>
	</div>
	<div class="box-body row">
		@if(isset($category) && $category['posts']->count() > 0)
		<div class="col-sm-12 p7">
				<div class="port-slideshow-p">
				  <!-- Image Carousel -->
				  <div id="port-slideshow-p" class="carousel slide" data-ride="carousel">
				    <!-- Wrapper for slides -->
				    <div class="carousel-inner">
						@foreach($category['posts'] as $key => $post)
						  <div class="item {{ $key == 0 ? 'active' : '' }}" >
							<a href="{{ $post->url() }}" title="{{ $post->title }}">
								<img class="img-responsive full-width" src="{{ asset($post->mpath . '/500x280_crop/'. $post->mname) }}" width="100%" />
								<div>
									<h4>
										{{ $post->title }}
									</h4>
									<p class="p-desc">
										{{ Str::words($post->excerpt, 50) }}
									</p>
								</div>
							</a>
						  </div>
						@endforeach
				    </div>
					<!-- Indicators -->
					<ol class="carousel-indicators">
						@foreach($category['posts'] as $key => $post)
							<li data-target="#carousel-example-generic" data-slide-to="0" class="{{ $key == 0 ? 'active' : '' }}">
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