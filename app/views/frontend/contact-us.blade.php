@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
Contact us ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>Liên hệ</h3>
</div>
<div class="well">	
	<dl class="dl-horizontal">
	  <dt>Trang chủ: </dt>
	  <dd><a href="http://binhbeer.com">http://binhbeer.com</a></dd>
	  <dt>Điện thoại:</dt>
	  <dd>090.320.1241</dd>
	  <dt>Email:</dt>
	  <dd>nightwishx@gmail.com <br />binhbeer@taymay.vn</dd>
	</dl>
</div>
<hr />
<form method="post" action="" class="form-horizontal" role="form">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<fieldset>
		<!-- Name -->
		<div  class="form-group{{ $errors->first('name', ' has-error') }}">
			<div class="col-lg-7">
				<input type="text" id="name" name="name" class="input-block-level form-control" placeholder="Tên bạn">
				{{ $errors->first('name', '<span class="help-block">:message</span>') }}
			</div>
		</div>

		<!-- Email -->
		<div  class="form-group{{ $errors->first('email', ' has-error') }}">
			<div class="col-lg-7">
				<input type="text" id="email" name="email" class="input-block-level form-control" placeholder="Địa chỉ Email">
				{{ $errors->first('email', '<span class="help-block">:message</span>') }}
			</div>
		</div>
		<!-- Description -->
		<div  class="form-group{{ $errors->first('description', ' has-error') }}">
			<div class="col-lg-12">
				<textarea rows="4" id="description" name="description" class="input-block-level form-control" placeholder="Nội dung"></textarea>
				{{ $errors->first('description', '<span class="help-block">:message</span>') }}
			</div>
		</div>

		<!-- Form actions -->
		<button type="submit" class="btn btn-warning pull-right">Gửi</button>
	</fieldset>
</form>
@stop
