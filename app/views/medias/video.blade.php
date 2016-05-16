@extends('backend/layouts/medias')

{{-- Page title --}}
@section('title')
Tải tệp tin ::
@parent
@stop

{{-- Page content --}}
@section('content')
@if ( Permission::has_access('medias', 'full') || Permission::has_access('medias', 'upload'))
<div id="media-container" class="user-video" style="border: 2px dashed #DDD; padding: 20px;">
	<form method="post" action="/medias/get-youtube" autocomplete="off" role="form" id="addYouTubeVideo">
	<input type="hidden" name="video_id" id="videoId" value="" />
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	<div>
		<label>URL của video</label>&nbsp;<small class="text-muted">(YouTube)</small>

	    <div class="input-group">
			<input id="videoUrl" class="video-url form-control" type="text" name="video-url" value="">
			<span class="input-group-btn">
				<button class="btn btn-default" type="button"><i class="glyphicon glyphicon-random" id="getProcess"></i></button>
			</span>
	    </div><!-- /input-group -->
	    <hr />
	    <div class="row">
	    	<div class="col-sm-8">
	    		<div id="videoPreview">
	    			@if(isset($video->mtype) && $video->mtype == 'video')
	    				<iframe width="100%" height="350" src="http://www.youtube.com/embed/{{ $video->mname }}?showinfo=0&amp;ps=docs&amp;autoplay=0&amp;iv_load_policy=3&amp;vq=large&amp;modestbranding=1&amp;nologo=1" frameborder="0" allowfullscreen="1"></iframe>
	    			@endif
	    		</div>
	    	</div>
	    	<div class="col-sm-4">
	    		@if(isset($video->mtype) && $video->mtype == 'video')
	    			<a class="btn btn-info" href="javascript:void(0);" onclick="setNewsCover('', '{{ $video->id }}')">Đặt làm đại diện cho bài</a>
	    		@else
	    			<input type="submit" name="submit" class="btn btn-success" style="display: none" id="videoSubmit" value="Ok" />
	    		@endif
	    	</div>
	    </div>
	</div>
	</form>
</div>
<script type="text/javascript">
	$(function() {
		$("#videoUrl").focus();

		$("#videoUrl").change(function(){
			var videoUrl = $("#videoUrl").val();

			if(videoUrl.length <= 0) 
				return false;

			$("#getProcess").addClass("fa-spin");

		    $.ajax({
		        type: 'GET',
		        url: "/medias/get-youtube",
		        data: {
		        	videourl:videoUrl,
		        },
		        dataType: 'json',
		        ifModify: false,
		        success: function(data){
		        	if(data.status == 0) {
		        		$("#videoPreview").html('<div class="alert alert-danger">Đường dẫn video không hợp lệ</div>');
		        		$("#videoSubmit").hide();
		        	} else {
		        		$("#videoPreview").html('<iframe width="100%" height="350" src="http://www.youtube.com/embed/'+data.videoId+'?showinfo=0&amp;ps=docs&amp;autoplay=0&amp;iv_load_policy=3&amp;vq=large&amp;modestbranding=1&amp;nologo=1" frameborder="0" allowfullscreen="1"></iframe>');
		        		$("#videoSubmit").show();
		        		$("#videoId").val(data.videoId);
						$("#getProcess").removeClass("fa-spin");
		        	}
		        }
		    });
		});
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