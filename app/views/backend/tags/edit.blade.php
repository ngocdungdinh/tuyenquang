@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Sửa chủ đề ::
@parent
@stop

{{-- Page content --}}
@section('content')
	<h3>
    	<span class="glyphicon glyphicon-pencil"></span> Sửa chủ đề
    	<a href="{{ route('create/tag') }}" class="btn btn-default btn-xs">Tạo mới</a>
    </h3>
    <div class="row">
    	<div class="col-md-5"><br /><br />
		  	<form method="post" action="" autocomplete="off" class="form-horizontal" role="form">
				<!-- CSRF Token -->
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />

				<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
					<label class="col-lg-3 control-label" for="name">Tiêu đề</label>
					<div class="col-lg-8">
						<input class="form-control" type="text" name="name" id="name" value="{{ $tag->name }}" />
					</div>
				</div>

				<div class="form-group">
					<label for="type" class="col-lg-3 control-label">Kiểu</label>
					<div class="col-lg-5">
						<select name="type" id="type" class="form-control">
							<option value="topic" {{ $tag->type=='topic' ? 'selected="selected"' : '' }}>topic</option>
							<option value="tag" {{ $tag->type=='tag' ? 'selected="selected"' : '' }}>tag</option>
						</select>
					</div>
				</div>
				@if ( Permission::has_access('news', 'edittopic', $tag->user_id) )
				<div class="form-group">
					<label for="status" class="col-lg-3 control-label">Nổi bật</label>
					<div class="col-lg-5">
						<div class="checkbox">
							<label><input type="checkbox" name="is_featured" value="1" {{ $tag->is_featured ? 'checked="checked"' : ''}}> </label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="status" class="col-lg-3 control-label">Hiện trang chủ</label>
					<div class="col-lg-5">
						<div class="checkbox">
							<label><input type="checkbox" name="showon_homepage" value="1" {{ $tag->showon_homepage ? 'checked="checked"' : ''}}> </label>
						</div>
					</div>
				</div>
				@endif
				<div class="form-group">
					<label for="status" class="col-lg-3 control-label">Trạng thái</label>
					<div class="col-lg-5">
						<select name="status" id="status" class="form-control">
							<option value="on" {{ $tag->status=='on' ? 'selected="selected"' : '' }}>Hiển thị</option>
							<option value="off" {{ $tag->status=='off' ? 'selected="selected"' : '' }}>Ẩn</option>
						</select>
					</div>
				</div>
				<hr />
				<label for="inputEmail1" class="col-lg-3 control-label"></label>
				<div class="col-lg-5">
					<button type="submit" class="btn btn-success btn-sm">Lưu</button>
					@if ( Sentry::getUser()->hasAnyAccess(['news','news.deletetag']) )
						<a onclick="confirmDelete(this); return false;" href="{{ route('delete/tag', $tag->id) }}" class="btn btn-danger btn-xs">@lang('button.delete')</a>
					@endif
				</div>
			</form>
		</div>
		<div class="col-md-7">
			<h4>
				{{$postlist->count()}} Bài viết
				<a data-toggle="modal" href="{{ URL::to('admin/news/postlist?tag_id='.$tag->id) }}" data-target="#modal_addposts" class="btn btn-default btn-xs show-modal">Thêm</a>
			</h4>
			<table class="table table-hover">
				<thead>
					<tr>
						<th class="span6">Tiêu đề</th>		
						<th class="span2">Ngày</th>
						<th class="span2">@lang('table.actions')</th>
					</tr>
				<thead>
				<tbody>
					@foreach($postlist as $post)
					<tr>							
						<td>{{ $post->title }}</td>
						<td>
							<span title="{{ $post->publish_date }}">{{ $post->publish_date }}</span>
						</td>
						<td>
							<a onclick="confirmDelete(this); return false;" href="{{ URL::to('admin/tags/removepost?tag_id='.$tag->id.'&post_id='.$post->id) }}" class="btn btn-danger btn-xs">bỏ</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
    </div>
	<!-- add news to tag -->
	<div class="modal fade" id="modal_addposts" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" ></div><!-- /.modal -->
@stop
