@extends('backend/layouts/widget')

{{-- Page content --}}
@section('content')
<div class=""  >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Kiểu luồng sự kiện</h4>
      </div>
      <div class="modal-body">
      	<form method="post" action="javascript:void(0)" autocomplete="off" class="form-horizontal" role="form" id="topicInfo">
			<!-- CSRF Token -->
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<input type="hidden" name="post_tag_id" id="post_tag_id" value="{{ $pt->id }}" />
			<div class="form-group">
				<label for="author" class="col-sm-4 control-label">Kiểu</label>
				<div class="col-sm-6">
					<select name="type" id="post_tag_type" class="form-control">
						<option value="default" {{ $pt->type == 'default' ? 'selected="selected"' : '' }}>Mặc định sau tóm tắt</option>
						<option value="related" {{ $pt->type == 'related' ? 'selected="selected"' : '' }}>Tin liên quan</option>
						<option value="mostview" {{ $pt->type == 'mostview' ? 'selected="selected"' : '' }}>Tin đọc nhiều</option>
						<option value="mostcomment" {{ $pt->type == 'mostcomment' ? 'selected="selected"' : '' }}>Tin nhiều bình luận</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-6">
					<button type="submit" class="btn btn-success" onclick="updateTopicInfo('{{ $pt->id }}');">Cập nhật</button>
				</div>
			</div>
      	</form>
      </div>
    </div>
  </div>
</div>