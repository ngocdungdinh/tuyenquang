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
            <label class="col-lg-2 control-label" for="limit">Số lượng</label>
            <div class="col-lg-2">
              <select name="limit" class="form-control">
                @for($i=1; $i<20; $i++)
                  <option value="{{ $i }}" {{ isset($wdata->limit) && $wdata->limit==$i ? 'selected="selected"' : '' }}>{{$i}}</option>
                @endfor
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label" for="backdays">Số ngày trước</label>
            <div class="col-lg-2">
              <select name="backdays" class="form-control">
                @for($i=1; $i<30; $i++)
                  <option value="{{ $i }}" {{ isset($wdata->backdays) && $wdata->backdays==$i ? 'selected="selected"' : '' }}>{{$i}}</option>
                @endfor
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label" for="mostview">Đọc nhiều</label>
            <div class="col-lg-3">
              <select name="mostview" class="form-control">
                <option value="yes" {{ isset($wdata->mostview) && $wdata->mostview=='yes' ? 'selected="selected"' : '' }}>Đúng</option>
                <option value="no" {{ isset($wdata->mostview) && $wdata->mostview=='no' ? 'selected="selected"' : '' }}>Sai</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label" for="mostcomment">Bình luận nhiều</label>
            <div class="col-lg-3">
              <select name="mostcomment" class="form-control">
                <option value="yes" {{ isset($wdata->mostcomment) && $wdata->mostcomment=='yes' ? 'selected="selected"' : '' }}>Đúng</option>
                <option value="no" {{ isset($wdata->mostcomment) && $wdata->mostcomment=='no' ? 'selected="selected"' : '' }}>Sai</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label" for="lastest">Mới nhất</label>
            <div class="col-lg-3">
              <select name="lastest" class="form-control">
                <option value="yes" {{ isset($wdata->lastest) && $wdata->lastest=='yes' ? 'selected="selected"' : '' }}>Đúng</option>
                <option value="no" {{ isset($wdata->lastest) && $wdata->lastest=='no' ? 'selected="selected"' : '' }}>Sai</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label" for="showpicture">Hiện ảnh?</label>
            <div class="col-lg-3">
              <select name="showpicture" class="form-control">
                <option value="yes" {{ isset($wdata->showpicture) && $wdata->showpicture=='yes' ? 'selected="selected"' : '' }}>Đúng</option>
                <option value="no" {{ isset($wdata->showpicture) && $wdata->showpicture=='no' ? 'selected="selected"' : '' }}>Sai</option>
              </select>
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