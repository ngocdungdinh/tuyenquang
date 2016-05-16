@extends('frontend/layouts/account')

{{-- Page title --}}
@section('title')
Đổi ảnh đại diện
@endsection

{{-- Account page content --}}
@section('account-content')
<form method="post" enctype="multipart/form-data" action="" class="form-horizontal" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- First Name -->
	<div class="form-group{{ $errors->first('first_name', ' has-error') }}">
		<label class="col-lg-1 control-label"></label>
		<label class="col-lg-3 control-label" for="first_name">
			@if(!$user->avatar)
				<img class="thumbnail" src="{{ asset('assets/img/default-avatar.png') }}" width="200">
			@else
				<img class="thumbnail" src="{{ asset('uploads/avatars/200x240_crop/'.$user->avatar) }}" width="200">
			@endif
		</label>
		<div class="col-lg-7">
			<p>Tải ảnh đại diện mới từ máy tính</p>
			<input class="form-control" type="file" name="picture" id="picture" value="{{ Input::old('picture', $user->picture) }}" />
			<p><small>Định dạng: jpg, jpeg, png. Dung lượng: nhỏ hơn 3M</small></p>
			<div><button type="submit" class="btn">Cập nhật</button></div>
		</div>
	</div>


	<!-- Form actions -->
	<div class="form-group">
		<div class="col-lg-offset-5 col-lg-7">
			
		</div>
	</div>
</form>

@stop
