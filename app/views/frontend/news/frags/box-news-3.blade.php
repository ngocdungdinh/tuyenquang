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
						<img class="img-responsive full-width" src="{{ asset($post->mpath . '/320x210_crop/'. $post->mname) }}" width="100%" />
						</a>
						<h5 class="link-title"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} {{ $post->has_picture ? '<i class="ion-images fa-red"></i>' : '' }} {{ $post->has_video ? '<i class="ion-videocamera fa-red"></i>' : '' }}</a></h5>
						<p class="p-desc">{{ Str::words($post->excerpt, 35) }}</p>
					</div>
				@elseif($key > 0 && $key < $limit)
					<div class="col-sm-6 p7">
						<div class="news-item">
							<a href="{{ $post->url() }}" title="{{ $post->title }}">
								<img class="img-responsive full-width" src="{{ asset($post->mpath . '/320x210_crop/'. $post->mname) }}" width="100%" />
							</a>
							<h5 class="link-title"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} {{ $post->has_picture ? '<i class="ion-images fa-red"></i>' : '' }} {{ $post->has_video ? '<i class="ion-videocamera fa-red"></i>' : '' }}</a></h5>
						</div>
					</div>
				@endif
			@endforeach
		@endif
	</div>
</div>