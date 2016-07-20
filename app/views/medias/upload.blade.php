@extends('backend/layouts/medias')

{{-- Page title --}}
@section('title')
Tải tệp tin ::
@parent
@stop

{{-- Page content --}}
@section('content')
@if ( Permission::has_access('medias', 'full') || Permission::has_access('medias', 'upload'))
	<link href="{{ asset('assets/css/dropzone.css?v='.Config::get('app.css_ver')) }}" rel="stylesheet">
	<script src="{{ asset('assets/js/dropzone.min.js') }}"></script>
	<div>
		<div id="media-upload-notice"></div>
		<div id="media-upload-error"></div>
		<div id="media-container" style="border: 4px dashed #DDD; min-height: 335px;">
			<form action="/medias/upload" class="dropzone" id="media-upload"></form>
	  	</div>
	</div>
	<script type="text/javascript">
		$(function() {
			Dropzone.options.mediaUpload = {
			  paramName: "picture", // The name that will be used to transfer the file
			  maxFilesize: 15, // MB
			  maxFiles: 5,
			  parallelUploads: 1,
			  acceptedFiles: 'image/*',
			  dictDefaultMessage: 'Kéo thả tệp tin cần tải lên tại đây! ( hoặc Click )'
			  // accept: function(file, done) {
			  //   if (file.name == "justinbieber.jpg") {
			  //     done("Naha, you don't.");
			  //   }
			  //   else { done(); }
			  // }
			};
		});
	</script>
@else
	<hr />
	<div class="alert alert-danger alert-dismissable">
        <i class="glyphicon glyphicon-remove-circle"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <b>Alert!</b> Bạn không được phép tải tệp tin
    </div>
@endif
@stop
