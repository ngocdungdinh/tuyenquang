@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Sửa trang ::
@parent
@stop

{{-- Page content --}}
@section('content')
	<h3>
    	<span class="glyphicon glyphicon-book"></span> Sửa nội dung
    </h3>
	<!-- Tabs -->
	<ul class="nav nav-tabs" style="margin: 15px 0">
		<li class="active"><a href="#tab-general" data-toggle="tab">Thông tin chung</a></li>
	</ul>

	<form method="post" action="" autocomplete="off" role="form">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<div class="row">
			<div class="col-md-9" style="border-right: 1px solid #cccccc">
				<!-- Tabs Content -->
				<div class="tab-content">
					<!-- General tab -->
					<div class="tab-pane active" id="tab-general">

						<!-- excerpt -->
						<div class="form-group {{ $errors->has('excerpt') ? 'has-error' : '' }}">
							<label class="control-label" for="excerpt">Tóm tắt</label>
							<textarea class="form-control" name="excerpt" id="excerpt" value="excerpt" rows="3">{{ Input::old('excerpt', $post->excerpt) }}</textarea>
						</div>
						<hr />
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<!-- Form actions -->
				<div>
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="pull-left">
								<select name="status" class="form-control">
									<option value="hidden" {{ $post->status=='hidden' ? 'selected="selected"' : '' }}>Ẩn</option>									
									<option value="published" {{ $post->status=='published' ? 'selected="selected"' : '' }}>Hiển thị</option>
								</select>
							</div>
							<div class="controls pull-right">
								<button type="submit" class="btn btn-success btn-sm">Lưu</button>
							</div>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">Hình ảnh</div>
					<div class="panel-body">
					  <div class="form-group">
					    <p class="help-block" id="cover-image">
					    	@if($media)
					    		<img src="{{ asset($media->mpath . '/200x130_crop/' . $media->mname) }}" width="175" />
					    		<a class="label label-default" href="javascript:void(0)" onclick="removeNewsCover()" >Bỏ ảnh</a>
					    	@else
					    		Chưa có ảnh
					    	@endif
					    </p>
					    <input type="hidden" name="media_id" value="{{ $post->media_id }}" id="media-cover-id" />
					  </div>
					</div>
				</div>
				@if ( Sentry::getUser()->hasAnyAccess(['pages','pages.delete']) )
					<a onclick="confirmDelete(this); return false;" href="{{ route('delete/gallery', $post->id) }}" class="btn btn-danger btn-xs">@lang('button.delete')</a>
				@endif
			</div>
		</div>
	</form>
@stop
