@extends('backend/layouts/widget')
@parent
@stop
{{-- Page content --}}
@section('content')
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">Tạo mới Sidebar</h4>
    </div>
    <div class="modal-body">
      <form method="post" action="{{ route('sidebars/update') }}" autocomplete="off" class="form-horizontal" role="form" id="sidebarForm">
        <input type="hidden" value="{{ isset($sidebar->id) ? $sidebar->id : 0 }}" name="sidebar_id" />
        <div class="form-group">
          <label class="col-lg-2 control-label" for="name">Tiêu đề</label>
          <div class="col-lg-8">
            <input class="form-control" type="text" name="name" id="name" value="{{ isset($sidebar->name) ? $sidebar->name : '' }}" />
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-2 control-label" for="position">Vị trí</label>
          <div class="col-lg-4">
            <select name="position" id="position" class="form-control">
              <option value="right" {{ isset($sidebar->position) ? ($sidebar->position == 'right' ? 'selected="selected"' : '') : '' }}>Bên phải</option>
              <option value="left" {{ isset($sidebar->position) ? ($sidebar->position == 'left' ? 'selected="selected"' : '') : '' }}>Bên trái</option>
              <option value="top" {{ isset($sidebar->position) ? ($sidebar->position == 'top' ? 'selected="selected"' : '') : '' }}>Trên cùng</option>
              <option value="bottom" {{ isset($sidebar->position) ? ($sidebar->position == 'bottom' ? 'selected="selected"' : '') : '' }}>Dưới cùng</option>
              <option value="center" {{ isset($sidebar->position) ? ($sidebar->position == 'center' ? 'selected="selected"' : '') : '' }}>Chính giữa</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-2 control-label" for="status">Trạng thái</label>
          <div class="col-lg-4">
            <select name="status" id="status" class="form-control">
              <option value="on">Hiển thị</option>
              <option value="off">Ẩn</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-2 control-label" for="title"></label>
          <div class="col-lg-4">
            <input class="btn btn-info" type="submit" name="submit" value="Cập nhật" />
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@stop