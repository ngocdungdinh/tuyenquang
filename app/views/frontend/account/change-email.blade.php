@extends('frontend/layouts/account')

{{-- Page title --}}
@section('title')
Đổi Email
@endsection

{{-- Account page content --}}
@section('account-content')
<form method="post" action="" class="form-horizontal" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- Form type -->
	<input type="hidden" name="formType" value="change-email" />

	<!-- New Email -->
	<div class="form-group{{ $errors->first('email', ' has-error') }}">
		<label class="col-lg-3 control-label" for="email">Email mới</label>
		<div class="col-lg-7">
			<input class="form-control" type="text" name="email" id="email" value="" />
			{{ $errors->first('email', '<span class="help-block">:message</span>') }}
		</div>
	</div>

	<!-- Confirm New Email -->
	<div class="form-group{{ $errors->first('email_confirm', ' has-error') }}">
		<label class="col-lg-3 control-label" for="email_confirm">Xác nhận Email mới</label>
		<div class="col-lg-7">
			<input class="form-control" type="text" name="email_confirm" id="email_confirm" value="" />
			{{ $errors->first('email_confirm', '<span class="help-block">:message</span>') }}
		</div>
	</div>

	<!-- Current Password -->
	<div class="form-group{{ $errors->first('current_password', ' has-error') }}">
		<label class="col-lg-3 control-label" for="current_password">Mật khẩu hiện tại</label>
		<div class="col-lg-7">
			<input class="form-control" type="password" name="current_password" id="current_password" value="" />
			{{ $errors->first('current_password', '<span class="help-block">:message</span>') }}
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
