@extends('frontend/layouts/modal')

{{-- Page content --}}
@section('content')
<div class="modal-dialog modal-xs">
	<div class="modal-content">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h4 class="modal-title">Thông tin thêm</h4>
	  </div>
	  <div class="modal-body">
	  	@if(isset($status) & !$status)
	  		<div class="alert alert-danger">
	  			{{ isset($message) ? $message : '' }}
	  		</div>
	  	@endif
	  	<div class="row">
	  		<div class="col-sm-6">
				<h4>Đăng nhập bằng: </h4>
				<a href="{{ URL::to('oauth/session/facebook') }}" class="popup_oauth">
				    <div class="btn-group">
				        <button type="button" class='btn btn-primary disabled'><i class="fa fa-facebook"></i></button>
				        <button type="button" class='btn btn-primary'> Facebook</button>
				    </div>
			    </a>
				<a href="{{ URL::to('oauth/session/google') }}" class="popup_oauth">
				    <div class="btn-group">
				        <button type="button" class='btn btn-danger disabled'><i class="fa fa-google-plus"></i></button>
				        <button type="button" class='btn btn-danger'> Google</button>
				    </div>
			    </a>
			    <hr class="visible-xs" />
	  		</div>
	  		<div class="col-sm-6">
			    <h4>Hoặc nhập thông tin của bạn:</h4>
			    <div>
			    	<form action="/comments/{{ $postId }}/add" method="post" class="form-horizontal" role="form" id="submitComment2" data-serialize >
						<div style="padding-bottom: 8px;">
							<label for="fullname">Họ tên</label>
							<input type="text" class="form-control" name="fullname" id="fullname" placeholder="- bắt buộc -">
						</div>
						<div>
							<label for="email">Địa chỉ email</label>
							<input type="text" class="form-control" name="email" id="email" placeholder="- bắt buộc -">
						</div>
						<div style="margin-top: 4px;" align="right">
							<input type="submit" class="btn btn-color" name="submit" value="Gửi" />
						</div>
  						<input type="hidden" name="comment_content" value="{{ nl2br($comment_content) }}" />
  						<input type="hidden" name="step" value="1" />
  						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			    	</form>
			    </div>
	  		</div>
	  	</div>
	  </div>
	</div>
</div>