@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Sửa bình luận ::
@parent
@stop

{{-- Page content --}}
@section('content')
	<h3>
    	<span class="glyphicon glyphicon-pencil"></span> Sửa bình luận
    </h3>	
	<form method="post" action="" autocomplete="off" role="form" class="form-horizontal">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		<!-- Comment Content -->
		<div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
			<label class="control-label col-lg-2" for="content">Nội dung</label>
			<div class="col-lg-10">
				<textarea class="form-control" name="content" id="content" rows="5">{{ Input::old('content', $comment->content) }}</textarea>
			</div>
		</div>
		<div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
			<label class="control-label col-lg-2" for="content">Trạng thái</label>
			<div class="col-lg-2">
				<select name="status" class="form-control">
					<option value="on" {{ $comment->status=='on' ? 'selected="selected"' : '' }}>Hiện</option>
					<option value="off" {{ $comment->status=='off' ? 'selected="selected"' : '' }}>Ẩn</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-lg-2" for="content">Gửi trong bài</label>
			<div class="col-lg-10">
				<a href="" target="_blank"># {{ $comment->post->title }}</a>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-lg-2" for="content">Ngày gửi</label>
			<div class="col-lg-10">
				{{ $comment->created_at }}
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-lg-2" for="content">Người gửi</label>
			<div class="col-lg-10">
				{{ $comment->author ? $comment->author->first_name. ' ' .$comment->author->last_name .' - '. $comment->author->email : '' }}
			</div>
		</div>
		<hr />
		<div class="form-group">
			<label class="control-label col-lg-2" for="content"> </label>
			<div class="col-lg-10">
				<button type="submit" class="btn btn-success">Cập nhật</button>
				@if ( Sentry::getUser()->hasAnyAccess(['news','news.deletecomment']) )
					<a onclick="confirmDelete(this); return false;" href="{{ route('delete/comment', $comment->id) }}" class="btn btn-danger">@lang('button.delete')</a> 
				@endif
			</div>
		</div>
	</form>
@stop
