<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Basic Page Needs
		================================================== -->
		<meta charset="utf-8" />
		<title>
			@section('title')
			BBCMS - Admin CP
			@show
		</title>
		<meta name="keywords" content="bbcms" />
		<meta name="author" content="BinhBEER" />
		<meta name="description" content="Content management system." />

		<!-- Mobile Specific Metas
		================================================== -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- CSS
		================================================== -->
		<link href="{{ asset('assets/css/bootstrap.min.css?v='.Config::get('app.css_ver')) }}" rel="stylesheet" media="all">
		<link href="{{ asset('assets/css/font-awesome.min.css?v='.Config::get('app.css_ver')) }}" rel="stylesheet" media="all">
        <link href="{{ asset('assets/css/ionicons.min.css?v='.Config::get('app.css_ver')) }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/morris/morris.css?v='.Config::get('app.css_ver')) }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/iCheck/all.css?v='.Config::get('app.css_ver')) }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/fullcalendar/fullcalendar.css?v='.Config::get('app.css_ver')) }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css?v='.Config::get('app.css_ver')) }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/AdminBB.css?v='.Config::get('app.css_ver')) }}" rel="stylesheet">
		<link href="{{ asset('assets/css/admin.css?v='.Config::get('app.css_ver')) }}" rel="stylesheet">


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

		<!-- Javascripts
		================================================== -->
		<script src="{{ asset('assets/js/jquery.1.10.2.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery-ui-1.10.3.min.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap/bootstrap.min.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap/bootstrap-datetimepicker.min.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap/bootstrap-datetimepicker.pt-vi.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap/typeahead.min.js') }}"></script>
		<script src="{{ asset('assets/js/moment.js') }}"></script>
		<script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
		<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.nestable.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.form.js') }}"></script>
		<script src="{{ asset('assets/js/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
		<script src="{{ asset('assets/js/plugins/jqueryKnob/jquery.knob.js') }}"></script>
		<script src="{{ asset('assets/js/plugins/morris/morris.min.js') }}"></script>
		<script src="{{ asset('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
		<script src="{{ asset('assets/js/plugins/iCheck/icheck.min.js') }}"></script>
		<script src="{{ asset('assets/js/jquery.charcounter.js') }}"></script>
		<!-- FLOT CHARTS -->
		<script src="{{ asset('assets/js/plugins/flot/jquery.flot.min.js') }}"></script>
		<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
		<script src="{{ asset('assets/js/plugins/flot/jquery.flot.resize.min.js') }}"></script>
		<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
		<script src="{{ asset('assets/js/plugins/flot/jquery.flot.pie.min.js') }}"></script>
		<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
		<script src="{{ asset('assets/js/plugins/flot/jquery.flot.categories.min.js') }}"></script>

		<script src="{{ asset('assets/js/AdminBB/app.js') }}"></script>
		<script src="{{ asset('assets/js/AdminBB/dashboard.js') }}"></script>
		<script src="{{ asset('assets/js/admin.js?v='.Config::get('app.js_ver')) }}"></script>
	</head>

	<body class="skin-black fixed">
		<!-- Header -->
		@include('backend/inc/header')

		<div class="wrapper row-offcanvas row-offcanvas-left">
			<!-- Left side column. contains the logo and sidebar -->
			<aside class="left-side sidebar-offcanvas">
				@include('backend/inc/nav')
			</aside>
            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
					<!-- Notifications -->
					@include('frontend/notifications')
					<!-- Content -->
					@yield('content')
					<!-- <div class="box box-danger">
						<div class="box-header">
							<h3 class="box-title">Thông báo</h3>
						</div>
						<div class="box-body">
							Đang chuyển dữ liệu sang máy chủ mới... vui lòng đợi trong ít phút!
						</div>
					</div> -->
				</section>
				<hr />
				<!-- Footer -->
				<footer align="center">
					<div class="copyright">
			        	Copyright © 2013. All rights reserved. Powered by <a target="_blank" href="#">BBCMS</a>
			        </div>
				</footer>
			</aside>
		</div>

		<div class="modal fade" id="modal_display" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="displayModal" >
		</div>
		<div class="modal fade" id="modal_newpost" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="newPostModal" >
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title">Tạo bài viết mới</h4>
		      </div>
		      <div class="modal-body">
		      	<div>
		      		<form method="post" action="/admin/news/create" autocomplete="off" role="form" id="quick-add-post">
						<!-- Post Title -->
						<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
							<label class="control-label" for="title">Tiêu đề bài viết</label>
							<input class="form-control" type="text" name="title" id="post_title" value="{{ Input::old('title') }}" placeholder="bắt buộc..." />
						</div>
						<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-floppy-disk"></span> Tạo mới</button> 
		      		</form>
		      	</div>        
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div>
		<!-- Upload image -->
		<div class="modal fade" id="modal_updateMedia" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title">Thư viện</h4>
		      </div>
		      <div class="modal-body">
		      	<div id="mediaContent"></div>        
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<script type="text/javascript">			
			$(document).ready(function(){
			    jQuery('#datetimepicker').datetimepicker({
			    	format: 'yyyy-MM-dd hh:mm:ss ',
			    	language: 'pt-BR'
			    });

			    jQuery('input#tagName').typeahead({
				  name: 'tagname',
				  local: ['Bình BEER', 'BBCMS'],
				  valueKey: 'name',
				  remote: {
				  	url: '/admin/tags/ajaxlist?keyword=%QUERY',
				  }
				});

			    CKEDITOR.replace('textareabox',{ toolbar:'CusToolbar', height: '500px'} );

			    $("#category-list").mouseleave(function(){
			        $("#category-list a").css("display", "none");
			    });

			    $("#category-list label").hover(function() {        
			        $("#category-list label a").css("display", "none");
			        $(this).children("a").css("display", "inline-block");
			    });
			});
		</script>
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
