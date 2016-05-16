<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="robots" content="noindex, nofollow" />
		<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
	</head>
	<body>
		<div class="container">
			<div align="center" style="border-bottom: 2px solid #ddd; margin-bottom: 20px;">
				<img src="/assets/img/logo.png?v=3" style="height: 80px;" class="img-responsive" />
				<span class="pull-right"><a href="javascript:void(0)" onclick="return window.print();">In (Ctrl +P)</a></span>
			</div>
			<div>
				@if($post->subtitle)
					<p style="font-weight: bold; color: #888;">{{ $post->subtitle }}</p>
				@endif
				<h3 style="color: #ba251e; margin: 4px 0">{{ $post->title }}</h3>	
				<div style="overflow: hidden; padding: 10px 0;">
					<span class="moment-date pull-left">{{ date("H:i - d/m/Y",strtotime($post->publish_date)) }}</span>
				</div>
				<div class="post-body">			
					<p class="news-content-excerpt"><strong>{{ $post->excerpt }}</strong></p>
					@if($post->relate_posts)
						@foreach($post->relates() as $pr)
							<p class="relate-post" style="line-height: 18px;"><a href="{{ $pr->url() }}">{{ $pr->title }} @include('frontend/news/frags/status')</a></p>
						@endforeach
					@endif
					<p>{{ $post->content }}</p>
				</div>
			</div>
		</div>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-51640168-1', 'auto');
		  ga('send', 'pageview');

		</script>
	</body>
</html>