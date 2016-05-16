@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Quản lý Chủ đề ::
@parent
@stop

{{-- Page content --}}
@section('content')
<h3>	
    <span class="glyphicon glyphicon-pencil"></span> {{ isset($type) && $type == 'tag' ? 'Chủ đề' : 'Luồng sự kiện' }}
	@if ( Sentry::getUser()->hasAnyAccess(['news','news.createtag']) )
		<a href="{{ route('create/tag') }}" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-plus-sign"></i> Tạo mới</a>
	@endif
</h3>
<div class="box">
    <div class="box-header">
    </div><!-- /.box-header -->
    <div class="box-body">
	  	<form method="get" action="" autocomplete="off" role="form" class="form-inline">
			<!-- CSRF Token -->
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<div class="form-group {{ $errors->has('key') ? 'has-error' : '' }}">
				<input class="form-control" type="text" name="key" id="key" value="{{ Input::old('key', (isset($keyword) ? $keyword : '')) }}" placeholder="Tiêu đề" />
			</div>
			<div class="form-group">
				<select class="form-control" name="type">
					<option value="0">- Kiểu -</option>
					<option value="tag" {{ isset($type) && $type == 'tag' ? 'selected="selected"' : '' }}>Chủ đề</option>
					<option value="topic" {{ isset($type) && $type == 'topic' ? 'selected="selected"' : '' }}>Luồng sự kiện</option>
				</select>
			</div>
			<div class="form-group">
				<select class="form-control" name="status">
					<option value="0">- Trạng thái -</option>
					<option value="on" {{ isset($status) && $status == 'on' ? 'selected="selected"' : '' }}>Bật</option>
					<option value="off" {{ isset($status) && $status == 'off' ? 'selected="selected"' : '' }}>Tắt</option>
				</select>
			</div>
			<div class="form-group">
				<select class="form-control" name="user_id">
					<option value="0">- Người tạo -</option>
					<option value="{{ $u->id }}"> - Tôi -</option>
					@foreach($writers as $writer)
						<option value="{{ $writer->id }}" {{ (isset($user_id) && $writer->id == $user_id) ? 'selected="selected"' : '' }}> {{ $writer->first_name }} {{ $writer->last_name }}</option>
					@endforeach
				</select>
			</div>
			<input type="submit" class="btn btn-default btn-info" name="search" value="Tìm" />
	  	</form>
	  	<hr />
        <table class="table table-bordered">
            <tr>
                <th style="width: 10px">#</th>
                <th>Tiêu đề</th>
                <th>Slug</th>
                <th>Trạng thái</th>
                <th>Kiểu</th>
                <th>Số bài</th>
                <th>Người tạo</th>
                <th style="width: 160px">Ngày tạo</th>
            </tr>
			@foreach ($tags as $tag)
				<tr>
					<td>{{ $tag->id }}</td>
					<td>
						@if ( Permission::has_access('news', 'edittag', $tag->user_id) )
							<a href="{{ route('update/tag', $tag->id) }}"><strong>{{ $tag->name }}</strong></a>
						@else
							{{ $tag->name }}
						@endif
					</td>
					<td>{{ $tag->slug }}</td>
					<td>
						@if($tag->status == 'on')
							<label class="label label-success">Bật</label>
						@else
							<label class="label label-default">Tắt</label>
						@endif
					</td>
					<td>
						@if($tag->type == 'tag')
							<label class="label label-default">Chủ đề</label>
						@else
							<label class="label label-danger">Luồng sự kiện</label>
						@endif
					</td>
					<td>{{ $tag->news_count }}</td>
					<td>{{ $tag->first_name }} {{ $tag->last_name }}</td>
					<td>{{ $tag->created_at }}</td>
				</tr>
			@endforeach
        </table>
    </div>
    <div class="box-footer clearfix">
        {{ $tags->links() }}
    </div>
</div>
@stop
