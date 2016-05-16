@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Tải tệp tin ::
@parent
@stop

{{-- Page content --}}
@section('content')
<h3>
  <span class="glyphicon glyphicon-cloud-upload"></span> Thư viện

  @if ( Sentry::getUser()->hasAnyAccess(['group','group.create']) )
    <a href="{{ route('upload/media') }}" class="btn btn-xs btn-default"><i class="icon-plus-sign icon-white"></i> Tải tệp tin</a>
  @endif
</h3>
<!-- Third party script for BrowserPlus runtime (Google Gears included in Gears runtime now) -->
<!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->
<script src="{{ asset('assets/js/pupload/browserplus-min.js') }}"></script>
<script src="{{ asset('assets/js/pupload/plupload.js') }}"></script>
<script src="{{ asset('assets/js/pupload/plupload.html5.js') }}"></script>
<script src="{{ asset('assets/js/pupload/plupload.silverlight.js') }}"></script>
<script src="{{ asset('assets/js/pupload/plupload.html4.js') }}"></script>
<script src="{{ asset('assets/js/pupload/handlers.dev.js?v=4') }}"></script>

<div>
	<div id="media-upload-notice"></div>
	<div id="media-upload-error"></div>
	<div id="media-container" style="border: 4px dashed #DDD; min-height: 335px;">
	  	<form method="post" action="" autocomplete="off" role="form" id="act_upload" enctype="multipart/form-data">	  	
	  		<!-- <div style="margin: 70px auto 0; width: 250px;">
	        	<input class="input-file" type="file" id="photo_file" name="picture" style="" />
	        </div> -->
	        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
	        {{ $errors->has('picture') ? 'Tải ảnh không thành công' : '' }}
			<div id="container-upload" class="hide-if-no-js drag-drop" style="margin: 70px auto 0; width: 300px;" align="center">
				<div id="drag-drop-area">
					<div class="drag-drop-inside">
						<p class="drag-drop-info" style="color: #939393; font-size: 20px; line-height: 24px;">Kéo thả tệp tin cần tải lên tại đây</p>
						<p>hoặc</p>
						<p class="drag-drop-buttons">
							<input id="pickfiles" type="button" value="Chọn tập tin" class="button" style="position: relative; z-index: 0;">
						</p>
					</div>
				</div>
				<!-- <p class="upload-flash-bypass">You are using the multi-file uploader. Problems? Try the <a href="#">browser uploader</a> instead.</p> -->
				<div id="p17gcmnumqu6au8p4kf1v6f12ji0_html5_container" style="position: absolute; background-color: transparent; width: 84px; height: 21px; overflow: hidden; z-index: -1; opacity: 0; top: 117px; left: 273px; background-position: initial initial; background-repeat: initial initial;" class="plupload html5">
					<input id="p17gcmnumqu6au8p4kf1v6f12ji0_html5" style="font-size: 999px; position: absolute; width: 100%; height: 100%;" type="file" accept="" multiple="multiple">
				</div>
			</div>
			<div id="media-items" style="margin: 70px auto 0; width: 90%;"></div>
	  	</form>
  	</div>
</div>
<script type="text/javascript">
	// Custom example logic
	$(function() {
		var resize_height = 1024, resize_width = 1024,

		uploader_init=function(){
			uploader = new plupload.Uploader ({
				runtimes : 'gears,flash,browserplus,html5',
				browse_button : 'pickfiles',
				file_data_name: "picture",
				container : 'container-upload',
				max_file_size : '3mb',
				url : 'upload',
				flash_swf_url : '{{ asset('assets/js/plupload/plupload.flash.swf') }}',
				silverlight_xap_url : '{{ asset('assets/js/plupload/plupload.silverlight.xap') }}',
				filters : [
					{title : "Image files", extensions : "jpg,jpeg,png"},
					{title : "Zip files", extensions : "zip"}
				],
				//resize : {width : 600, height : 240, quality : 100},
				// resize : {width : 1024, quality : 100},
				multipart : true,
				urlstream_upload:true
			});

			$("#image_resize").bind("change",function(){
				var b = $(this).prop("checked");
				setResize(b);
				if(b) { 
					setUserSetting("upload_resize","1") 
				} else {
					deleteUserSetting("upload_resize") 
				}
			});

			uploader.bind("Init",function(b) {
				var c=$("#container-upload");
				//setResize(getUserSetting("upload_resize",false));
				if(b.features.dragdrop && !$(document.body).hasClass("mobile")) {
					c.addClass("drag-drop");
					$("#drag-drop-area").bind("dragover.wp-uploader",function() {
						c.addClass("drag-over")
					}).bind("dragleave.wp-uploader, drop.wp-uploader",function(){
							c.removeClass("drag-over")
					})
				} else {
					c.removeClass("drag-drop");
					$("#drag-drop-area").unbind(".wp-uploader")
				}
			});

			uploader.init();
			uploader.bind("FilesAdded",function(d,e){
				var c = 100*1024*1024, b = parseInt(d.settings.max_file_size,10);
				$("#media-upload-error").html("");
				uploadStart();
				plupload.each(e,function(f){
					if(b>c&&f.size>c&&d.runtime!="html5"){
						uploadSizeError(d,f,true)}else{
							fileQueued(f)
						}
				});

				d.refresh();d.start()
			});

			uploader.bind("BeforeUpload",function(b,c){});
			uploader.bind("UploadFile",function(b,c){
				fileUploading(b,c)
			});
			uploader.bind("UploadProgress",function(b,c){
				uploadProgress(b,c)
			});
			uploader.bind("Error",function(b,c){
				uploadError(c.file,c.code,c.message,b);
				b.refresh()
			});
			uploader.bind("FileUploaded",function(b,d,c){
				uploadSuccessRedirect(d,c.response)
			});
			uploader.bind("UploadComplete",function(b,c){
				uploadComplete()
			})
		};

		uploader_init();

		// uploader.bind('Init', function(up, params) {
		// 	$('#filelist').html("<div>Current runtime: " + params.runtime + "</div>");
		// });

		// $('#uploadfiles').click(function(e) {
		// 	uploader.start();
		// 	e.preventDefault();
		// });

		// uploader.init();

		// uploader.bind('FilesAdded', function(up, files) {
		// 	$.each(files, function(i, file) {
		// 		$('#filelist').append(
		// 			'<div id="' + file.id + '">' +
		// 			file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
		// 		'</div>');
		// 	});

		// 	up.refresh(); // Reposition Flash/Silverlight
		// });

		// uploader.bind('UploadProgress', function(up, file) {
		// 	$('#' + file.id + " b").html(file.percent + "%");
		// });

		// uploader.bind('Error', function(up, err) {
		// 	$('#filelist').append("<div>Error: " + err.code +
		// 		", Message: " + err.message +
		// 		(err.file ? ", File: " + err.file.name : "") +
		// 		"</div>"
		// 	);

		// 	up.refresh(); // Reposition Flash/Silverlight
		// });

		// uploader.bind('FileUploaded', function(up, file) {
		// 	$('#' + file.id + " b").html("100%");
		// });
	});
	// $(document).ready(function(){
	//     $('#photo_file').live('change', function() {
	//         if($('#photo_file').val()){
	//             $("#photo_file_prev").html('');
	//             $("#photo_file_prev").html('<img src="'+config.public_folder.img+'/taymay/loader.gif" alt="Uploading...." />');
	//             $("#act_upload").ajaxForm({
	//                 target: '#photo_file_prev'
	//             }).submit();
	//         }
	//     });
	// });
</script>
@stop
