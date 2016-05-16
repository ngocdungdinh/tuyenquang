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
            <div class="col-lg-5">
              <input class="form-control" type="text" name="title" id="title" value="{{ $widget->title }}" />
            </div>
            <label class="col-lg-2 control-label">Hiện?</label>
            <div class="col-lg-3">
              <select name="showtitle" class="form-control">
                <option value="no" {{ isset($wdata->showtitle) && $wdata->showtitle=='no' ? 'selected="selected"' : '' }}>Sai</option>
                <option value="yes" {{ isset($wdata->showtitle) && $wdata->showtitle=='yes' ? 'selected="selected"' : '' }}>Đúng</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label" for="title">Tọa độ</label>
            <div class="col-lg-6">
              <input class="form-control" type="text" name="location" id="location" value="{{ isset($wdata->location) ? $wdata->location : '' }}" placeholder="vd: 36.125,65.321" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label">Zoom</label>
            <div class="col-lg-2">
              <select name="zoom" class="form-control">
              	@for($z=1; $z < 20; $z++)
                	<option value="{{$z}}" {{ isset($wdata->zoom) && $wdata->zoom==$z ? 'selected="selected"' : '' }}>{{$z}}</option>
              	@endfor
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label">Kiểu</label>
            <div class="col-lg-4">
              <select name="maptype" class="form-control">
                <option value="HYBRID" {{ isset($wdata->maptype) && $wdata->maptype=='HYBRID' ? 'selected="selected"' : '' }}>HYBRID</option>
                <option value="ROADMAP" {{ isset($wdata->maptype) && $wdata->maptype=='ROADMAP' ? 'selected="selected"' : '' }}>ROADMAP</option>
                <option value="SATELLITE" {{ isset($wdata->maptype) && $wdata->maptype=='SATELLITE' ? 'selected="selected"' : '' }}>SATELLITE</option>
                <option value="TERRAIN" {{ isset($wdata->maptype) && $wdata->maptype=='TERRAIN' ? 'selected="selected"' : '' }}>TERRAIN</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label" for="width">Rộng</label>
            <div class="col-lg-2">
              <input class="form-control" type="text" name="width" id="width" value="{{ isset($wdata->width) ? $wdata->width : '' }}" placeholder="px" />
            </div>
            <label class="col-lg-2 control-label" for="height">Cao</label>
            <div class="col-lg-2">
              <input class="form-control" type="text" name="height" id="height" value="{{ isset($wdata->height) ? $wdata->height : '' }}" placeholder="px" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label" for="title">Nội dung bản đồ</label>
            <div class="col-lg-9">
              <textarea class="form-control" name="content" id="htmlcontent" style="height: 100px;">{{ isset($wdata->content) ? $wdata->content : '' }}</textarea>
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