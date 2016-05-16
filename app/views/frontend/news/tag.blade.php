@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
{{ $tag->name }} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row">
	<div class="col-md-8">
		<div class="box-info list-news">
			<div class="box-title">
				<a href="javascript:void(0)" class="m-title">Chủ đề: <strong>{{ $tag->name }}</strong></a>
			</div>
			<div class="box-body">
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
		</div>
		<div class="paging">
			{{ $posts->links() }}
		</div>
	</div>
	<div class="col-md-4">
		<div class="sidestick-container">
			<div class="box-info">
				<div style="padding: 5px;">
					<div class="fb-like-box" data-href="{{ Config::get('app.socialapp.facebook.url') }}" data-width="285" data-height="184" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
