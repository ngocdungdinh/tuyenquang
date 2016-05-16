@extends('backend/layouts/widget')

{{-- Page title --}}
@section('title')
Chỉnh ảnh ::
@parent
@stop
{{-- Page content --}}
@section('content')
<script src="/assets/js/cropper.js"></script>
<div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h4 class="modal-title">Chỉnh ảnh</h4>
	  </div>
	  <div class="modal-body">
	  	<div class="row">
	  		<div class="col-sm-9">
		    	<img class="cropper" src="{{ asset($media->mpath . '/'. $media->mname) }}" width="100%">
	  		</div>
	  		<div class="col-sm-3">
	  			<form class="form-horizontal" role="form">
		  			<div class="img-preview img-preview-sm" style="width: 193px; height: 116px; border: 1px solid #dddddd; margin-bottom: 6px; "></div>
		  			<hr />
		  			<div class="form-group">
		                <label for="data-width" class="col-sm-3 control-label">Rộng:</label>
		                <div class="col-sm-9">
		                    <input type="text" class="form-control" id="data-width" placeholder="width">
		                </div>
		            </div>
		  			<div class="form-group">
		                <label for="data-height" class="col-sm-3 control-label">Cao:</label>
		                <div class="col-sm-9">
		                    <input type="text" class="form-control" id="data-height" placeholder="height">
		                </div>
		            </div>
		  			<p>
		  				<a href="javascript:void(0)" onclick='reThumb();' class="btn btn-warning"><i class="fa fa-scissors"></i> Cắt</a>
		  			</p>
		  			<p id="cropStatus"></p>
	  			</form>
	  		</div>
		</div>
	  </div>
	</div>
</div>
<script type="text/javascript">
var $image = $(".img-container img"),
    $dataHeight = $("#data-height"),
    $dataWidth = $("#data-width");

	$(".cropper").cropper({
	    aspectRatio: 500/300,
	    // data: {"x1":398,"y1":10,"width":500,"height":300},
	    preview: '.img-preview',
	    done: function(data) {
	        // console.log(data);
	        $dataHeight.val(data.height);
	        $dataWidth.val(data.width);
	    }
	});
	function reThumb(){
		var data = $(".cropper").cropper("getData");
		$('#cropStatus').html('<img src="/assets/img/loader.gif" />');
        $.ajax({
            type: 'POST',
            url: "/medias/cropthumb/{{ $media->id }}",
            data: data,
            dataType: 'json',
            ifModify: false,
            success: function(data){
                if(data.status==1) {
                	$('#cropStatus').html('<strong>Cắt ảnh thành công!</strong>');
                	setTimeout(function() {
				        window.location.href = window.location.href
				    }, 500)
                } else {
                	$('#cropStatus').html('Có lỗi xảy ra!');
                }
            }
        });
	}
</script>
@stop