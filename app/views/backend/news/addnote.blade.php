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
        <h4 class="modal-title">Thêm ghi chú cho thao tác này:</h4>
      </div>
      <div class="modal-body">
		<form method="post" action="/admin/news/addnote" autocomplete="off" role="form" id="updatePost">
			<!-- CSRF Token -->
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<input type="hidden" name="status" value="{{ $status }}" />
			<input type="hidden" name="postid" value="{{ $post_id }}" />
	      	<textarea id="noteContent2" name="content" class="form-control" style="height: 150px;" placeholder="Nội dung ghi chú?"></textarea>
	      	<p style="padding-top: 6px;" align="right"> 
	      		<button type="submit" class="btn btn-info btn-sm btn-flat"><span class="glyphicon glyphicon-chevron-down"></span> OK</button>
	      	</p>
      	</form>
      </div>
    </div>
  </div>
</div>