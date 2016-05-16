@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Tạo chuyên mục mới ::
@parent
@stop

{{-- Page content --}}
@section('content')
	<h3>
    	<span class="glyphicon glyphicon-pencil"></span> Tạo chuyên mục mới
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
			<label for="parent_id" class="col-lg-2 control-label">Chuyên mục cha</label>
			<div class="col-lg-4">
				<select name="parent_id" id="parent_id" class="form-control">
					<option value="0">- Chuyên mục lớn</option>
					@foreach($categories as $category)
						<option value="{{ $category->id }}">- - {{ $category->name }}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-lg-2 control-label" for="showon_menu">Thứ tự Menu</label>
			<div class="col-lg-1">
				<input class="form-control" type="text" name="showon_menu" id="showon_menu" value="{{ Input::old('showon_menu') }}" />
			</div>
		</div>

		<div class="form-group">
			<label class="col-lg-2 control-label" for="showon_homepage">Thứ tự Homepage</label>
			<div class="col-lg-1">
				<input class="form-control" type="text" name="showon_homepage" id="showon_homepage" value="{{ Input::old('showon_homepage') }}" />
			</div>
		</div>

		<div class="form-group">
			<label for="status" class="col-lg-2 control-label">Trạng thái</label>
			<div class="col-lg-2">
				<select name="status" class="form-control">
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
