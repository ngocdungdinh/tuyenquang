<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Basic Page Needs
		================================================== -->
		<meta charset="utf-8" />
		<title>
			@section('title')
			{{ Config::get('settings.sitename') }}
			@show
		</title>
		<meta name="keywords" content="bbcms" />
		<meta http-equiv="REFRESH" content="1800" />
		<meta name="author" content="SO TU PHAP HN" />

		<meta name="keywords" content="@yield('meta_keywords')" />
		<meta name="description" content="@yield('meta_description')" />
		<link rel="image_src" href="@yield('meta_image')" />

        <meta property="og:title" content="@yield('meta_title')" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ Request::url() }}" />
        <meta property="og:image" content="@yield('meta_image')" />
        <meta property="og:site_name" content="{{ Config::get('settings.sitename') }}" />
        <meta property="og:description" content="@yield('meta_description')" />
		<meta name="google-site-verification" content="C5BIFxCF4z_DQlgpyKGA7M-lPTCjrhJUsx3fk22my7I" />

		<!-- Mobile Specific Metas
		================================================== -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- CSS
		================================================== -->
		<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/ionicons.min.css?v='.Config::get('app.css_ver')) }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,500,400italic,500italic,700italic' rel='stylesheet' type='text/css'>
		<link href="{{ asset('assets/css/frontend.'. Config::get('app.compress_name') .'.css?v='.Config::get('app.css_ver')) }}" rel="stylesheet">

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Favicons
		================================================== -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('assets/ico/apple-touch-icon-144-precomposed.png?v='.Config::get('app.css_ver')) }}">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('assets/ico/apple-touch-icon-114-precomposed.png?v='.Config::get('app.css_ver')) }}">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('assets/ico/apple-touch-icon-72-precomposed.png?v='.Config::get('app.css_ver')) }}">
		<link rel="apple-touch-icon-precomposed" href="{{ asset('assets/ico/apple-touch-icon-57-precomposed.png?v='.Config::get('app.css_ver')) }}">
		<link rel="shortcut icon" href="{{ asset('assets/ico/favicon.png?v='.Config::get('app.css_ver')) }}">
		<script type="text/javascript">
			var BB = BB || {};
			(function(context) {
			    var addGlobal = function(myObj) {
			        for (propName in myObj) {
			            context[propName] = myObj[propName];
			        }
			    }
			    context.addGlobal = addGlobal;
			})(BB)
			
			var BB = BB || {};
			(function(context, document){
			    context.support = {};
			    context.support.touch = 'createTouch' in document;
			    var p = 'transform WebkitTransform MozTransform OTransform Transform';
			    var prefixes = p.split(' ');
			    var el = document.createElement('div');
			    var support = 0;
			    for(var i = 0; i < prefixes.length; i++){
			        var pfx = prefixes[i];
			        support = el.style[pfx] !== undefined;
			        if (support) break;
			    }
			    context.support.csstransforms = support;
			})(BB, document);

			BB.delayed = {};
		</script>
		<!-- Javascripts
		================================================== -->
		<script src="{{ asset('assets/js/jquery.1.10.2.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.easing.1.3.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap/bootstrap.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.form.js') }}"></script>
		<script src="{{ asset('assets/js/frontend.'. Config::get('app.compress_name') .'.js?v='.Config::get('app.js_ver')) }}"></script>
	</head>

	<body class="body-red">
		<div id="fb-root"></div>
		<ul class="side-menu">
  			<div class="side-search-form">
  				<form class="" role="search" id="sideSearchForm" action="/search" method="post">
			  	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<div class="input-group">
				  <input type="text" class="form-control" name="keyword" placeholder="Tìm kiếm" style="margin-top: 2px;">
				  <span class="input-group-btn" style="margin-top: 2px;">
				    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
				  </span>
				</div>
				</form>
  			</div>
  			<div id="sideMenu"></div>
  		</ul>
		<!-- Extra Bar -->
		<div class="mini-navbar mini-navbar-black" style="overflow: hidden">
		  <div class="container">
		  	<div class="row">
				<div class="col-sm-12">
				  <span class="pull-right" style="display: inline-block; padding: 5px 12px">
				  	<i class="fa fa-envelope-o hidden-xs"></i> plxhonline@gmail.com</strong></span>
				  </span>
				  <span class="pull-right" style="display: inline-block; padding: 5px 0">
				  	<i class="fa fa-phone-square hidden-xs"></i> <span>Hotline: <strong>0936 23 2929</strong></span>
				  </span>
				  <a href="/page/lien-he-quang-cao" class="pull-left" style="padding-left: 1px;">
					<i class="fa fa-phone-square hidden-xs"></i> Liên hệ quảng cáo
				  </a>
				  <a href="#" class="pull-left hidden-xs" id="nav-search"><i class="fa fa-search"></i></a>
				  <a href="#" class="pull-left hidden" id="nav-search-close"><i class="fa fa-times"></i></a>
				  <!-- Search Form -->
				  <form class="pull-left hidden" role="search" id="nav-search-form" action="/search" method="post">
				  	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<div class="input-group">
					  <input type="text" class="form-control" name="keyword" placeholder="Tìm kiếm" style="margin-top: 2px;">
					  <span class="input-group-btn" style="margin-top: 2px;">
					    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
					  </span>
					</div>
				  </form>
				</div>
		  	</div>
		  </div>
		</div>
		<div class="hidden-xs">
			<div class="container ">
				<div style="padding: 14px 0">
					<div class="row">
						<div class="col-sm-4 col-xs-12" align="left">
							<a href="/" class="xs-logo"><img src="/assets/img/logo.png?v=3" style="height: 90px;" class="img-responsive" /></a>
						</div>
						<div class="col-sm-8 hidden-xs" align="right">
							<a href="http://baca-bank.vn" target="_blank"><img src="/assets/img/bacabank2.png?v=1" style="height: 90px;" border="0"></a>
							<!-- <a href="http://www.konigin.vn" target="_blank"><img src="/assets/img/bnr/konigin.gif?v=2" style="height: 90px;" border="0"></a> -->

							<!-- <a href="http://khoedep365.net/" target="_blank"><img class="hidden-sm" src="/assets/img/bnr/hongsam.png" style="height: 90px;"  border="0"></a> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	    <div class="navbar navbar-white navbar-static-top" role="navigation">
	      <div class="container">
		    <!-- Navbar Header -->
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle hidden-xs" data-toggle="collapse" data-target=".navbar-collapse">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="navbar-brand" href="/" class="hidden-sm hidden-md hidden-lg"></a>
	          <a id="menu-icon" href="javascript:void(0)" class="pull-right visible-xs"><i class="fa fa-bars"></i></a>
	          <a href="/" class="pull-left visible-xs" style="padding: 3px;"><img src="/assets/img/logo-mobile.png" style="height: 32px;" /></a>
	        </div> <!-- / Navbar Header -->
			<!-- Navbar Links -->
	        <div class="navbar-collapse collapse">
			  <ul class="nav navbar-nav" id="mainMenu">
				<li class="main-menu trang-chu {{ !isset($parent_category->slug) ? 'active' : '' }}">
					<a href="/" class="bg-hover-color" title="Trang chủ Pháp Luật & Xã Hội"><i class="fa fa-home"></i></a>
				</li>
				@foreach( Menu::position('nav')->mlinks as $nav )
					<li class="main-menu {{ Str::slug($nav->title) }} {{ isset($parent_category->slug) && '/'.$parent_category->slug == $nav->url ? 'active' : '' }}">
						<a href="{{ $nav->url }}" class="bg-hover-color" target="{{ $nav->target }}">{{ $nav->title }}</a>
					</li>
				@endforeach
			  </ul>
			  <!-- Search Form (xs) -->
	        </div> <!-- / Navbar Links -->
	      </div> <!-- / container -->
	    </div> <!-- / navbar -->
	    <div class="sub-menu {{ isset($parent_category->name) && $parent_category->name ? 'oncat' : '' }}" role="navigation" style="background-color: #e0d4d2">
	      <div class="container">
	        <div class="row">
	        	<div class="col-sm-8 p10 hidden-xs">
	        		@if(isset($parent_category->name) && $parent_category->name)
	        			<ul class="sub-cats">
		        			@foreach($parent_category->subshomecats as $subcate)
		        				<li><a href="/{{ $subcate->slug }}" {{ $category->slug == $subcate->slug ? 'class="active"' : '' }}>{{ $subcate->name }}</a></li>
		        			@endforeach
	        			</ul>
	        		@else
		        		<span class="on-events" style="">Dòng sự kiện:</span>
		        		<span class="feature_tags">
		        			@if(isset($featured_tags))
		        				@foreach($featured_tags as $ht)
		        					<a href="/tags/{{ $ht->slug }}" class="top-tag">{{ $ht->name }}</a>
		        				@endforeach
		        			@endif
		        		</span>
	        		@endif
	        	</div>
	        	<div class="col-sm-4 col-xs-12 p10" align="right">
	        		<span class="current-date" id="currentDate" data-datetime="{{ date('m/d/Y h:i:s a', time()); }}">
	        			{{ date('H:i - d/m/Y') }}
	        		</span>
	        		<span><a href=""><img src="/assets/img/rss.gif" /></a></span>
	        	</div>
	        </div>
	      </div>
	    </div>

		<!-- Wrapper -->
		<div class="wrapper">
			<div class="container">
				<!-- Notifications -->
				@include('frontend/notifications')
				<!-- Content -->
				@yield('content')
				@if(isset($parent_category->name) && $parent_category->name)
				@endif
			</div>
		</div>
		<footer>
			<div class="container">
				<div style="background-color: #efefef;">
			        <div style="padding: 10px; background-color: #e1e1e1; border-top: 5px solid #d5000d;">
			        	<div class="hidden-xs">
			        		<ul>
								<li class="footer-menu {{ Str::slug($nav->title) }}">
									<a href="/">Trang chủ</a>
								</li>
				        		@foreach( Menu::position('nav')->mlinks as $nav )
									<li class="footer-menu {{ Str::slug($nav->title) }}">
										<a href="{{ $nav->url }}" target="{{ $nav->target }}">{{ $nav->title }}</a>
									</li>
								@endforeach
							</ul>
			        	</div>
			        </div>
			        <div class="row" style="padding: 20px;">
			        	<div class="col-sm-3">
			        		<div class="fb-like-box" data-href="{{ Config::get('app.socialapp.facebook.url') }}" data-width="220" data-show-faces="false" data-header="false" data-stream="false" data-show-border="false"></div>
			        		<hr />
			        		<div align="center">
				        		<p><a href="/nhat-ky-141" style="padding: 10px; background-color: #ba251e; color: #ffffff; font-weight: bold; display: inline-block">Chuyên đề nhật ký 141</a></p>
				        		<p><i>Chỉ có tại Phapluatxahoi.vn</i></p>
			        		</div>
			        	</div>
			        	<div class="col-sm-3">
			        		<hr class="visible-xs" />
			        		<p>
			        			<a href="/page/lien-he-quang-cao"><i class="fa fa-phone-square"></i> Liên hệ quảng cáo </a>
			  				</p>
			        		<p><strong>Trụ sở Tòa soạn:</strong><br /> Số 1B Trần Phú, Hà Đông, Hà Nội</p>
							<p>ĐT: 043 354 1631 - 0936 232 929</p>
							<p>Email: plxhonline@gmail.com</p>
			        	</div>
			        	<div class="col-sm-6">
			        		<hr class="visible-xs" />
			        		<p><strong>© 2013 Báo Điện tử Pháp luật & Xã hội - Cơ quan chủ quản: Sở Tư pháp Hà Nội</strong></p>
							<p>Giấy phép: số 464/GP-BTTTT do Bộ Thông tin và Truyền thông cấp ngày 29/11/2013.</p>
							<p>Tổng Biên tập: <strong>Nguyễn Văn Bình</strong></p>
							<p>Phó Tổng Biên tập: <strong>Nguyễn Thái Bình, Nguyễn Xuân Khánh</strong></p>
							<p>Thư ký tòa soạn: <strong>Đinh Bá Tuấn</strong></p>
							<p>® Ghi rõ nguồn "phapluatxahoi.vn" khi bạn phát hành lại thông tin từ website này</p>
			        	</div>
			        </div>
		        </div>
		        <hr />
		        <div class="copyright">
		        	<p class="hidden">Copyright © 2013. All rights reserved. Powered by <a href="http://bbcms.com" target="_blank" title="BBCMS"><img src="/assets/img/bbcms-logo.png" height="22" /></a></p>
		        </div>
	        </div>
		</footer>
		<div class="modal fade" id="modal_displayInfo" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="displayInfo" >
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-body" align="center">
		      	<img src="/assets/img/loader.gif">
		      </div>
		    </div>
		  </div>
		</div>
		<script type="text/javascript">
			function image_send_to_editor(photo_url) {
				var htmlContent = '<p align="center"><img src="/'+ photo_url +'" /></p>';

				CKEDITOR.instances.textareabox.insertHtml(htmlContent);
				$('#modal_updateMedia').modal('hide');
			}
		</script>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-51640168-1', 'auto');
		  ga('send', 'pageview');


		    var _gaq = _gaq || [];

			_gaq.push(['_setCustomVar',
				1,                   // This custom var is set to slot #1.  Required parameter.
				'Nhat ky 141',           // The top-level name for your online content categories.  Required parameter.
				'Chuyen muc Phap Luat',  // Sets the value of "Section" to "Life & Style" for this particular aricle.  Required parameter.
				3                    // Sets the scope to page-level.  Optional parameter.
			]);
		</script>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1&appId=461580803910206";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
	</body>
</html>
