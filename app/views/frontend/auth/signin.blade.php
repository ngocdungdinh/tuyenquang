@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
Đăng nhập
@endsection

{{-- Page content --}}
@section('content')
<hr />
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Đăng nhập</h3>
  </div>
  <div class="panel-body">
	<div class="">
		<form class="form-horizontal" role="form" method="post" action="{{ route('signin') }}">
			<!-- CSRF Token -->
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		  <div class="form-group{{ $errors->first('email', ' has-error') }}">
		    <label for="email" class="col-lg-3 control-label">Email</label>
		    <div class="col-lg-7">
		      <input class="form-control" type="text" name="email" id="email" value="{{ Input::old('email') }}" />
					{{ $errors->first('email', '<span class="help-block">:message</span>') }}
		    </div>
		  </div>
		  <div class="form-group{{ $errors->first('password', ' has-error') }}">
		    <label for="password" class="col-lg-3 control-label">Mật khẩu</label>
		    <div class="col-lg-7">
		      <input type="password" class="form-control" name="password" id="password" value="" />
					{{ $errors->first('password', '<span class="help-block">:message</span>') }}
		    </div>
		  </div>
		  <div class="form-group">
		    <div class="col-lg-offset-3 col-lg-7">
		      <div class="checkbox">
		        <label>
		          <input type="checkbox" name="remember-me" id="remember-me" value="1" /> Duy trì đăng nhập
		        </label>
		      </div>
		    </div>
		  </div>
		  <div class="form-group">
		    <div class="col-lg-offset-3 col-lg-7">
		      <button type="submit" class="btn btn-default">Đăng nhập</button> - 
		      <a href="{{ route('forgot-password') }}">Quên mật khẩu?</a>
		    </div>
		  </div>
		  <div class="form-group">
		    <div class="col-lg-offset-3 col-lg-7">
	            <hr />
	            <div style="padding-bottom: 10px">
	              <a id="fb-connect" rel="0" href="{{ URL::to('oauth/session/facebook') }}" class="popup_oauth"></a>
	            </div>
		    </div>
		  </div>
		</form>
	</div>
  </div>
</div>
@stop
