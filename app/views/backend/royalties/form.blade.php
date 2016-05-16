@extends('backend/layouts/widget')

{{-- Page title --}}
@section('title')
Sửa nhuận bút ::
@parent
@stop
{{-- Page content --}}
@section('content')
<div class=""  >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Thêm/sửa nhuận bút</h4>
      </div>
      <div class="modal-body">
		<form method="post" action="{{ URL::to('admin/royalties/form') }}" autocomplete="off" class="form-horizontal" role="form" id="royaltiesForm">
			<!-- CSRF Token -->
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<input type="hidden" name="royal_id" id="royalId" value="{{ $royal_id }}" />
			<input type="hidden" name="item_id" id="itemId" value="{{ isset($royalty->item_id) ? $royalty->item_id : $item_id }}" />
			<div class="form-group">
				<label for="author" class="col-sm-4 control-label">Người nhận</label>
				<div class="col-sm-6">
				  <input type="text" name="author" required class="form-control" id="author" placeholder="Chọn tên người nhận" value="{{ isset($royalty->user_id) ? $royalty->author->fullName() : $writer->fullName() }}">
				  <input type="hidden" name="user_id" id="user_id" value="{{ isset($royalty->item_id) ? $royalty->user_id : $writer->id }}">
				</div>
			</div>
			<div class="form-group">
				<label for="royalty" class="col-sm-4 control-label">Nhuận bút</label>
				<div class="col-sm-4">
				  <input type="text" required class="form-control" name="royalty" id="royalty" placeholder="Số tiền" value="{{ isset($royalty->item_id) ? $royalty->royalty : '' }}">
				</div>
			</div>
			<div class="form-group">
				<label for="tax" class="col-sm-4 control-label">Thuế</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="tax" name="tax" placeholder="" value="{{ isset($royalty->item_id) ? $royalty->tax : 0 }}">
				</div>
			</div>
			<div class="form-group">
				<label for="description" class="col-sm-4 control-label">Ghi chú</label>
				<div class="col-sm-6">
					<textarea name="description" id="description" class="form-control">{{ isset($royalty->item_id) ? $royalty->description : '' }}</textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="received" class="col-sm-4 control-label">Đã nhận?</label>
				<div class="col-sm-6">
					<input type="checkbox" value="1" name="received" id="received" {{ (isset($royalty->item_id) && $royalty->received) ? 'checked="checked"' : '' }}>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-4 col-sm-6">
					<button type="submit" class="btn btn-success">Cập nhật</button>
				</div>
			</div>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
	$(document).ready(function(){
		UpdateRoyalties();

	    jQuery('input#author').typeahead({
		  name: 'author',
		  local: {{ $writers }},
		  valueKey: 'name'
		}).bind('typeahead:selected', function(obj, datum, name) {
			$('#user_id').val(datum.id);
		});
	});
</script>
@stop
