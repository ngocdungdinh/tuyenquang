@foreach ($posts as $key => $post)
	<div class="news-item" style="overflow: hidden; margin-bottom: 8px; min-height: 50px;">
		<div style="width: 40px; height: 40px; float: right; border: 1px solid #dddddd; text-align: center; font-size: 20px; font-weight: bold; color: #ababab; padding-top: 10px;">{{ $key + 1 }}</div>
		<h6 class="link-title" style="margin-right: 50px; margin-top: 2px;"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} @include('frontend/news/frags/status')</a></h6>
	</div>
@endforeach