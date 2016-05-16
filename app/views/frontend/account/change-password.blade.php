@extends('frontend/layouts/account')

{{-- Page title --}}
@section('title')
Đổi mật khẩu
@endsection

{{-- Account page content --}}
@section('account-content')
<form method="post" action="" class="form-horizontal" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- Old Password -->
	<div class="form-group{{ $errors->first('old_password', ' has-error') }}">
		<label class="col-lg-3 control-label" for="old_password">Mật khẩu cũ</label>
		<div class="col-lg-7">
			<input class="form-control" type="password" name="old_password" id="old_password" value="" />
			{{ $errors->first('old_password', '<span class="help-block">:message</span>') }}
		</div>
	</div>

	<!-- New Password -->
	<div class="form-group{{ $errors->first('password', ' has-error') }}">
		<label class="col-lg-3 control-label" for="password">Mật khẩu mới</label>
		<div class="col-lg-7">
			<input class="form-control" type="password" name="password" id="password" value="" />
			{{ $errors->first('password', '<span class="help-block">:message</span>') }}
		</div>
	</div>

	<!-- Confirm New Password  -->
	<div class="form-group{{ $errors->first('password_confirm', ' has-error') }}">
		<label class="col-lg-3 control-label" for="password_confirm">Xác nhận mật khẩu mới</label>
		<div class="col-lg-7">
			<input class="form-control" type="password" name="password_confirm" id="password_confirm" value="" />
			{{ $errors->first('password_confirm', '<span class="help-block">:message</span>') }}
		</div>
	</div>

	<hr>

	<!-- Form actions -->
	<div class="form-group">
		<div class="col-lg-offset-3 col-lg-7">
			<button type="submit" class="btn">Cập nhật</button>

			<a href="{{ route('forgot-password') }}" class="btn btn-link">Quên mật khẩu?</a>
		</div>
	</div>
</form>
@stop