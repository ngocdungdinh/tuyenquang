@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
{{ $category->name }} ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="row">
	<ol class="breadcrumb">
	  <li><a href="/">Trang chủ</a></li>
	  <li class="active">{{ $category->name }}</li>
	</ol>
</div>
@foreach ($posts as $post)
<div class="row">
	<div class="span8">

		<!-- Post Content -->
		<div class="row">
			<div class="col-md-4">
				@if($post->thumbnail)
					<a href="{{ $post->url() }}" class="thumbnail">					
						<img src="{{ asset($post->thumbnail->mpath . '/220x280_crop/' . $post->thumbnail->mname) }}" width="220" />
					</a>
				@endif
			</div>
			<div class="col-md-8">
				<h4><strong><a href="{{ $post->url() }}">{{ $post->title }}</a></strong></h4>
				<blockquote>
					<small>
						<i class="icon-user"></i> Đăng bởi <span class="muted">{{ $post->author->first_name }} {{ $post->author->last_name }}</span>
						| <i class="icon-calendar"></i> {{ $post->created_at->diffForHumans() }}
						| <i class="icon-comment"></i> <a href="{{ $post->url() }}#comments">{{ $post->comments()->count() }} phản hồi</a>
					</small>
				</blockquote>
				<p>
					{{ $post->excerpt }}
				</p>
				<p><a class="btn btn-xs btn-info" href="{{ $post->url() }}">Đọc thêm...</a></p>
			</div>
		</div>

	</div>
</div>

<hr />
@endforeach

{{ $posts->links() }}
@stop
