@extends('backend/layouts/widget')

{{-- Page title --}}
@section('title')
Thư viện của tôi ::
@parent
@stop
{{-- Page content --}}
@section('content')
<div class=""  >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Thêm chủ đề vào bài viết</h4>
      </div>
      <div class="modal-body">
		<div class="form-group {{ $errors->has('keyword') ? 'has-error' : '' }} row">
			<div class="col-lg-3">
				<select class="form-control" name="order" id="orderByDate">
					<option {{ $order == 'desc' ? 'selected="selected"' : '' }} value="desc">Mới nhất</option>
					<option {{ $order == 'asc' ? 'selected="selected"' : '' }} value="asc">Cũ nhất</option>
				</select>
			</div>
			<div class="col-lg-4">
				<input class="form-control pull-left" type="text" name="keyword" id="keyword" value="{{ Input::old('key', (isset($keyword) ? $keyword : '')) }}" placeholder="tìm kiếm" />
			</div>
			<div class="col-lg-1">
				<button class="btn btn-default btn-info" id="searchTags" onclick="ajaxSearchTags()">Tìm</button>
			</div>
		</div>
		<form method="post" action="{{ URL::to('admin/tags/listpopup') }}" autocomplete="off" role="form">
			<!-- CSRF Token -->
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<table class="table table-hover" id="postList">
				<thead>
					<tr>
						<th class="span6">@lang('admin/news/table.title')</th>
						<th width="150">Ngày</th>
						<th width="50"></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($tags as $tag)
					<tr>
						<td>
							{{ $tag->name }}
						</td>
						<td>		
							<span title="{{ $tag->created_at }}">{{ $tag->created_at }}</span>
						</td>
						<td>		
							<a href="javascript:void(0);" onclick="addTopictoPost('{{ $tag->id }}')" class="btn btn-default">Thêm</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</form>
		@if(isset($keyword)) 
			{{ $tags->appends(array('key' => $keyword))->links() }}
		@else
			{{ $tags->links() }}
		@endif
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop
