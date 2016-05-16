@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Tạo chủ đề ::
@parent
@stop

{{-- Page content --}}
@section('content')
	<h3>
    	<span class="glyphicon glyphicon-pencil"></span> Tạo chủ đề
    </h3>
  	<form method="post" action="" autocomplete="off" class="form-horizontal" role="form">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
			<label class="col-lg-2 control-label" for="name">Tiêu đề</label>
			<div class="col-lg-5">
				<input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name') }}" />
			</div>
		</div>

		<div class="form-group">
			<label for="type" class="col-lg-2 control-label">Kiểu</label>
			<div class="col-lg-2">
				<select name="type" id="type" class="form-control">
					<option value="topic">topic</option>
					<option value="tag">tag</option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label for="status" class="col-lg-2 control-label">Trạng thái</label>
			<div class="col-lg-2">
				<select name="status" id="status" class="form-control">
					<option value="on">Hiển thị</option>
					<option value="off">Ẩn</option>
				</select>
			</div>
		</div>
		<hr />
		<label for="inputEmail1" class="col-lg-2 control-label"></label>
		<div class="col-lg-2">
			<button type="submit" class="btn btn-success btn-sm">Lưu</button>
		</div>
	</form>
@stop
