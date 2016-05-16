<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Basic Page Needs
		================================================== -->
		<meta charset="utf-8" />
		<title>
			@section('title')
			Administration - Medias
			@show
		</title>
		<meta name="keywords" content="your, awesome, keywords, here" />
		<meta name="author" content="Jon Doe" />
		<meta name="description" content="Lorem ipsum dolor sit amet, nihil fabulas et sea, nam posse menandri scripserit no, mei." />

		<!-- Mobile Specific Metas
		================================================== -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- CSS
		================================================== -->		
		<link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/css/admin.css?v='.Config::get('app.css_ver')) }}" rel="stylesheet">

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Javascripts
		================================================== -->
		<script src="{{ asset('assets/js/jquery.1.10.2.min.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap/bootstrap.min.js') }}"></script>
		<script src="{{ asset('assets/js/admin.js?v='.Config::get('app.css_ver')) }}"></script>

	</head>

	<body style="overflow-y: hidden !important;">
		<!-- Container -->
		<div>

			<!-- Notifications -->
			@include('frontend/notifications')

			<!-- Content -->
			<ul class="nav nav-tabs" id="mediaTab" style="padding-top:10px; width: 100%">
			  <li {{ (Request::is('medias/upload-youtube') ? ' class="active"' : '') }}><a href="{{ URL::to('medias/add-video?env='.$env) }}"><span class="glyphicon glyphicon-facetime-video"></span> Tải video</a></li>
			  <li {{ (Request::is('medias/upload') ? ' class="active"' : '') }}><a href="{{ URL::to('medias/upload?env='.$env) }}"><span class="glyphicon glyphicon-picture"></span> Tải ảnh</a></li>
			  <li {{ (Request::is('medias/my') ? ' class="active"' : '') }}><a href="{{ URL::to('medias/my?env='.$env) }}"><span class="glyphicon glyphicon-user"></span> Thư viện của bạn</a></li>
			  @if ( Permission::has_access('medias', 'full') || Permission::has_access('medias', 'viewall'))
			  	<li {{ (Request::is('medias/index') ? ' class="active"' : '') }}><a href="{{ URL::to('medias/index?env='.$env) }}"><span class="glyphicon glyphicon-th"></span> Tất cả</a></li>
			  @endif
			</ul>
			<div style="padding: 10px; overflow-y: auto; height: 420px;">
			    <!--Body content-->
				@yield('content')
			</div>
		</div>
	</body>
</html>
