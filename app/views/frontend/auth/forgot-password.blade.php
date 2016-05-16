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

	<!-- Email -->
	<div class="form-group{{ $errors->first('email', ' has-error') }}">
		<label class="col-lg-3 control-label" for="email">Email</label>
		<div class="col-lg-7">
			<input class="form-control" type="text" name="email" id="email" value="{{ Input::old('email') }}" />
			{{ $errors->first('email', '<span class="help-block">:message</span>') }}
		</div>
	</div>

	<!-- Form actions -->
	<div class="form-group">
		<div class="col-lg-offset-3 col-lg-7">
			<button type="submit" class="btn">Gửi mã xác nhận</button>
		</div>
	</div>
</form>
@stop
