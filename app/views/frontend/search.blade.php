@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
{{ $keyword }} - Tìm kiếm
@endsection

{{-- Account page content --}}
@section('content')

	<div class="hidden-xs" style="padding: 10px; background-color: #eeeeee; margin-bottom: 15px; text-align: center; overflow: hidden">
		<div>
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- p-970x90 -->
			<ins class="adsbygoogle"
			     style="display:inline-block;width:970px;height:90px"
			     data-ad-client="ca-pub-5128894772635532"
			     data-ad-slot="5194700805"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
		</div>
	</div>
	<div style="margin-left: 10px;">
		<div class="row">
			<div class="col-md-8">
				<h3>{{ $posts->count() }} kết quả có từ khóa "{{ $keyword }}"</h3>
				<hr />
				@if($posts->count())
					<div style="overflow: hidden">
						@foreach ($posts as $key => $post)
							<div class="list-news-item row">
								<div class="col-sm-5 p7">
									<a href="{{ $post->url() }}" title="{{ $post->title }}">
										@if($post->mtype == 'video')
											<span class="video-thumb">
												<img class="img-responsive full-width" src="{{ asset('http://i.ytimg.com/vi/'. $post->mname.'/0.jpg') }}" />
												<span class="play-icon small"><i class="ion-play"></i></span>
											</span>
										@else
											<img class="img-responsive full-width" src="{{ asset($post->mpath . '/320x210_crop/'. $post->mname) }}" />
										@endif
									</a>
								</div>
								<div class="col-sm-7 p7">
									<h5 class="link-title"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} {{ $post->has_picture ? '<i class="ion-images fa-red"></i>' : '' }} {{ $post->has_video ? '<i class="ion-videocamera fa-red"></i>' : '' }}</a></h5>
									<p>{{ Str::words($post->excerpt, 24) }}</p>
								</div>
							</div>
						@endforeach
					</div>
					<hr />
					<div align="center">{{ $posts->links() }}</div>
				@else
					<div class="well">
						Không tìm thấy kết quả nào
					</div>
				@endif
			</div>
			<div class="col-md-4">
				<div>
					<div class="box-info">
						<div style="padding: 5px;">
							<div class="fb-like-box" data-href="{{ Config::get('app.socialapp.facebook.url') }}" data-width="285" data-height="184" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
						</div>
					</div>
				</div>
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- p-300x600 -->
				<ins class="adsbygoogle"
				     style="display:inline-block;width:300px;height:600px"
				     data-ad-client="ca-pub-5128894772635532"
				     data-ad-slot="6671434005"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
		</div>
	</div>
@stop