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
			@foreach($category['posts'] as $key => $post)
				@if($key == 0)
					<div class="col-sm-12 p7">
						<a href="{{ $post->url() }}" title="{{ $post->title }}">
							<div class="video-thumb">
								@if($post->mtype == 'video')
									<img class="img-responsive full-width" src="{{ asset('http://i.ytimg.com/vi/'. $post->mname.'/0.jpg') }}" />
									<span class="play-icon"><i class="ion-play"></i></span>
								@elseif($post->mtype == 'image')
									<img class="img-responsive full-width" src="{{ asset($post->mpath . '/500x280_crop/'. $post->mname) }}" />
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
				@elseif( $key>=1 && $key < 4)
					<div class="col-xs-4 p7">
						<a href="{{ $post->url() }}" title="{{ $post->title }}">
							<div class="video-thumb">
								@if($post->mtype == 'video')
									<img class="img-responsive full-width" src="{{ asset('http://i.ytimg.com/vi/'. $post->mname.'/0.jpg') }}" />
									<span class="play-icon small"><i class="ion-play"></i></span>
								@elseif($post->mtype == 'image')
									<img class="img-responsive full-width" src="{{ asset($post->mpath . '/320x210_crop/'. $post->mname) }}" />
								@endif
							</div>
						</a>
						<h5 class="link-title" style="font-weight: normal"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }}</a></h5>
					</div>
				@endif
			@endforeach
		@endif
	</div>
</div>