@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
{{ $category->name }} ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div>
	@if($popular_posts->count())
	<div class="row hidden-xs">
		<div class="col-xs-12">
			<div class="box-info">
				<div class="box-title">
					<a href="/{{ $category->slug }}" class="m-title">Đang nóng</a>
				</div>
				<div class="box-body">
					<div class="popularcat-slideshow-p">
					  <!-- Image Carousel -->
					  <div id="popularcat-slideshow-p" class="carousel slide" data-ride="carousel">
					    <!-- Wrapper for slides -->
					    <div class="carousel-inner">
					    	<div class="item active row">
								@foreach ($popular_posts as $key => $post)
									@if($key < 6)
									<div class="col-sm-2 col-xs-6 p7">
										<a href="{{ $post->url() }}" title="{{ $post->title }}">
											@if($post->mtype == 'video')
												<span class="video-thumb">
													<img class="img-responsive full-width" src="{{ asset('http://i.ytimg.com/vi/'. $post->mname.'/0.jpg') }}" />
													<span class="play-icon small"><i class="ion-play"></i></span>
												</span>
											@elseif($post->mtype == 'image')
												<img src="{{ asset($post->mpath . '/200x130_crop/'. $post->mname) }}" width="100%" />
											@endif
										</a>
										<h5 class="link-title"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} @include('frontend/news/frags/status')</a></h5>
									</div>
									@endif
								@endforeach
					    	</div>
					    	@if($popular_posts->count()>=6)
					    	<div class="item row">
								@foreach ($popular_posts as $key => $post)
									@if($key >= 6 && $key < 12)
									<div class="col-sm-2 col-xs-6 p7">
										<a href="{{ $post->url() }}" title="{{ $post->title }}">
											@if($post->mtype == 'video')
												<span class="video-thumb">
													<img class="img-responsive full-width" src="{{ asset('http://i.ytimg.com/vi/'. $post->mname.'/0.jpg') }}" />
													<span class="play-icon small"><i class="ion-play"></i></span>
												</span>
											@elseif($post->mtype == 'image')
												<img src="{{ asset($post->mpath . '/200x130_crop/'. $post->mname) }}" width="100%" />
											@endif
										</a>
										<h5 class="link-title"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} @include('frontend/news/frags/status')</a></h5>
									</div>
									@endif
								@endforeach
					    	</div>
					    	@endif
					    	@if($popular_posts->count()>=12)
					    	<div class="item row">
								@foreach ($popular_posts as $key => $post)
									@if($key >= 12 && $key < 18)
									<div class="col-sm-2 col-xs-6 p7">
										<a href="{{ $post->url() }}" title="{{ $post->title }}">
											@if($post->mtype == 'video')
												<span class="video-thumb">
													<img class="img-responsive full-width" src="{{ asset('http://i.ytimg.com/vi/'. $post->mname.'/0.jpg') }}" />
													<span class="play-icon small"><i class="ion-play"></i></span>
												</span>
											@elseif($post->mtype == 'image')
												<img src="{{ asset($post->mpath . '/200x130_crop/'. $post->mname) }}" width="100%" />
											@endif
										</a>
										<h5 class="link-title"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} @include('frontend/news/frags/status')</a></h5>
									</div>
									@endif
								@endforeach
					    	</div>
					    	@endif
					    </div>
					    <!-- Controls -->
					    <a class="port-arrow-p port-arrow-prev bg-hover-color" href="#popularcat-slideshow-p" data-slide="prev">
						  <i class="fa fa-angle-left"></i>
					    </a>
					    <a class="port-arrow-p port-arrow-next bg-hover-color" href="#popularcat-slideshow-p" data-slide="next">
						  <i class="fa fa-angle-right"></i>
					    </a>
					  </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif

	@if(isset($page) && $page <= 1)
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<div>
				<h3 style="margin-top: 5px; padding-bottom: 3px; border-bottom: 1px solid #dddddd">
					<a href="/{{ $parent_category->slug }}">{{ $parent_category->name }}</a>
					@foreach($parent_category->subshomecats as $subcate)
        				<a href="/{{ $subcate->slug }}" style="font-size: 16px;{{ $category->id==$subcate->id ? 'font-weight:bold; color: #333333' : 'color: #666666' }}"> <i style="margin: 0 10px;" class="fa fa-angle-right"></i> {{ $subcate->name }}</a>
        			@endforeach
				</h3>
			</div>
			<div class="row">
				<div class="home-featured-post col-sm-6 p7">
					@foreach ($featured_posts as $key => $post)
						@if($key < 1)
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
				<div class="col-sm-6 p7">
					<div class="row">
						@foreach ($featured_posts as $key => $post)
							@if($key>=1 && $key < 3)
								<div class="news-item col-xs-6 col-sm-6" style="border-bottom: 0; padding-bottom: 10px;">
									<a href="{{ $post->url() }}" title="{{ $post->title }}">
										@if($post->mtype == 'video')
											<span class="video-thumb">
												<img class="img-responsive full-width" src="{{ asset('http://i.ytimg.com/vi/'. $post->mname.'/0.jpg') }}" />
												<span class="play-icon small"><i class="ion-play"></i></span>
											</span>
										@elseif($post->mtype == 'image')
											<img src="{{ asset($post->mpath . '/200x130_crop/'. $post->mname) }}" width="100%" />
										@endif
									</a>
									<h5 class="link-title"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} @include('frontend/news/frags/status')</a></h5>
								</div>
							@elseif($key > 1)
								<div class="news-item col-xs-12">
									<h5 class="link-title"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} @include('frontend/news/frags/status')</a></h5>
								</div>
							@endif
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
	<hr class=" hidden-xs" style="margin-bottom: 10px; margin-top: 10px;" />
	@else
	<div>
		<h3 style="margin-top: 5px; padding-bottom: 3px; border-bottom: 1px solid #dddddd">
			{{ $parent_category->name }}
			@if($category->parent_id != 0)
				<a href="/{{ $category->slug }}" style="font-size: 18px;"> <i style="margin: 0 10px;" class="fa fa-angle-right"></i> {{ $category->name }}</a>
			@endif
		</h3>
	</div>
	@endif
	
	<div class="row">
		<div class="col-md-6">
			<div class="box-info list-news">
				<div class="box-body">
					@foreach ($posts as $key => $post)
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
					@endforeach
				</div>
			</div>
			<div class="paging">
				{{ $posts->links() }}
			</div>
		</div>
		<div class="col-md-6 hidden-xs hidden-sm">
			<div class="row">
				<div class="col-sm-8 p7">
					@foreach($parent_category->widgetsByPosition('center') as $w)
						{{ SWidget::getView($w) }}
					@endforeach
				</div>
				<div class="col-sm-4 p7">	
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
				</div>
			</div>
		</div>
	</div>
</div>
@stop
