@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
Đăng ký tài khoản
@endsection

{{-- Page content --}}
@section('content')
<hr />
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Đăng ký tài khoản</h3>
  </div>
  <div class="panel-body">
	<div class="">
		<form class="form-horizontal" role="form" method="post" action="{{ route('signup') }}" class="form-horizontal" autocomplete="off">
			<!-- CSRF Token -->
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<div class="form-group">
				<label for="username" class="col-lg-4 control-label{{ $errors->first('username', ' has-error') }}">Nickname</label>
				<div class="col-lg-6">
					<input type="text" class="form-control" name="username" id="username" value="{{ Input::old('username') }}" />
					{{ $errors->first('username', '<span class="help-block">:message</span>') }}
				</div>
			</div>
			<div class="form-group">
				<label for="first_name" class="col-lg-4 control-label{{ $errors->first('first_name', ' has-error') }}">Tên</label>
				<div class="col-lg-6">
					<input type="text" class="form-control" name="first_name" id="first_name" value="{{ Input::old('first_name') }}" />
					{{ $errors->first('first_name', '<span class="help-block">:message</span>') }}
				</div>
			</div>
			<div class="form-group{{ $errors->first('email', ' has-error') }}">
				<label for="email" class="col-lg-4 control-label">Email</label>
				<div class="col-lg-6">
					<input type="text" class="form-control" name="email" id="email" value="{{ Input::old('email') }}" />
					{{ $errors->first('email', '<span class="help-block">:message</span>') }}
				</div>
			</div>
			<hr />
			<div class="form-group{{ $errors->first('password', ' has-error') }}">
				<label for="password" class="col-lg-4 control-label">Mật khẩu</label>
				<div class="col-lg-6">
					<input type="password" class="form-control" name="password" id="password" value="" />
					{{ $errors->first('password', '<span class="help-block">:message</span>') }}
				</div>
			</div>
			<div class="form-group{{ $errors->first('password_confirm', ' has-error') }}">
				<label for="password_confirm" class="col-lg-4 control-label">Xác nhận mật khẩu</label>
				<div class="col-lg-6">
					<input type="password" class="form-control" name="password_confirm" id="password_confirm" value="" />
					{{ $errors->first('password_confirm', '<span class="help-block">:message</span>') }}
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-offset-4 col-lg-6">
					<button type="submit" class="btn btn-default">Đăng ký</button>
				</div>
			</div>
		</form>
	</div>
  </div>
</div>

@stop
