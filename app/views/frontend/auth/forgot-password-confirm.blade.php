@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
Lấy lại mật khẩu
@endsection

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>Lấy lại mật khẩu</h3>
</div>
<form method="post" action="" class="form-horizontal">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- New Password -->
	<div class="form-group{{ $errors->first('password', ' has-error') }}">
		<label class="col-lg-3 control-label" for="password">Mật khẩu mới</label>
		<div class="col-lg-7">
			<input type="password" name="password" id="password" value="{{ Input::old('password') }}" />
			{{ $errors->first('password', '<span class="help-block">:message</span>') }}
		</div>
	</div>

	<!-- Password Confirm -->
	<div class="form-group{{ $errors->first('password_confirm', ' has-error') }}">
		<label class="col-lg-3 control-label" for="password_confirm">Xác nhận mật khẩu mới</label>
		<div class="col-lg-7">
			<input type="password" name="password_confirm" id="password_confirm" value="{{ Input::old('password_confirm') }}" />
			{{ $errors->first('password_confirm', '<span class="help-block">:message</span>') }}
		</div>
	</div>

	<!-- Form actions -->
	<div class="form-group">
		<div class="col-lg-offset-3 col-lg-7">
			<button type="submit" class="btn btn-info">Đổi mật khẩu</button>
		</div>
	</div>
</form>
@stop
