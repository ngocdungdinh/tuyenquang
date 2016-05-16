@extends('backend/layouts/widget')
@parent
@stop
{{-- Page content --}}
@section('content')
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Sửa Widgets</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ route('updatewr/widgets') }}" autocomplete="off" class="form-horizontal" role="form" id="widgetForm">
          <input type="hidden" value="{{ $widget->id }}" name="id" />
          <div class="form-group">
            <label class="col-lg-2 control-label" for="title">Tiêu đề</label>
            <div class="col-lg-7">
              <input class="form-control" type="text" name="title" id="title" value="{{ $widget->title }}" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label">Hiện?</label>
            <div class="col-lg-4">
              <select name="showtitle" class="form-control">
                <option value="no" {{ isset($wdata->showtitle) && $wdata->showtitle=='no' ? 'selected="selected"' : '' }}>Sai</option>
                <option value="yes" {{ isset($wdata->showtitle) && $wdata->showtitle=='yes' ? 'selected="selected"' : '' }}>Đúng</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label" for="title">Nội dung</label>
            <div class="col-lg-9">
              <textarea class="form-control" name="content" id="htmlcontent" style="height: 250px;">{{ isset($wdata->content) ? $wdata->content : '' }}</textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label" for="title">Trạng thái</label>
            <div class="col-lg-4">
              <select name="status" class="form-control">
                <option value="close" {{ $widget->status=='close' ? 'selected="selected"' : '' }}>Ẩn</option>
                <option value="open" {{ $widget->status=='open' ? 'selected="selected"' : '' }}>Hiển thị</option>
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
  <script type="text/javascript">
    updateWidget();
    // CKEDITOR.replace('htmlcontent',{ toolbar:'MinToolbar', height: '250px'} );
  </script>
@stop