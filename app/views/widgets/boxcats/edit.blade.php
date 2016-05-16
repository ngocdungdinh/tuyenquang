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
            <div class="col-lg-6">
              <input class="form-control" type="text" name="title" id="title" value="{{ $widget->title }}" />
            </div>
            <div class="col-lg-3">
              <select name="showtitle" class="form-control">
                <option value="no" {{ isset($wdata->showtitle) && $wdata->showtitle=='no' ? 'selected="selected"' : '' }}>Ẩn</option>
                <option value="yes" {{ isset($wdata->showtitle) && $wdata->showtitle=='yes' ? 'selected="selected"' : '' }}>Hiện</option>
              </select></div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label" for="title">Chuyên mục</label>
            <div class="col-lg-9">
              <select name="category_id" class="form-control">
                @foreach(Category::where('status', 'on')->where('parent_id', '0')->orderBy('showon_menu', 'ASC')->get() as $cat)
                  <option value="{{ $cat->id }}" {{ isset($wdata->category_id) && $wdata->category_id==$cat->id ? 'selected="selected"' : '' }}>{{ $cat->name }}</option>
                  @foreach ($cat->subscategories as $subcate)
                  <option value="{{ $subcate->id }}" {{ isset($wdata->category_id) && $wdata->category_id==$subcate->id ? 'selected="selected"' : '' }}>-- {{ $subcate->name }}</option>
                  @endforeach
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label" for="title">Giao diện</label>
            <div class="col-lg-4">
              <select name="template" class="form-control">
                  <option value="style-one" {{ isset($wdata->template) && $wdata->template=='style-one' ? 'selected="selected"' : '' }}>Kiểu 1</option>
                  <option value="style-two" {{ isset($wdata->template) && $wdata->template=='style-two' ? 'selected="selected"' : '' }}>Kiểu 2</option>
                  <option value="style-three" {{ isset($wdata->template) && $wdata->template=='style-three' ? 'selected="selected"' : '' }}>Kiểu 3</option>
                  <option value="style-four" {{ isset($wdata->template) && $wdata->template=='style-four' ? 'selected="selected"' : '' }}>Kiểu 4</option>
                  <option value="style-six" {{ isset($wdata->template) && $wdata->template=='style-six' ? 'selected="selected"' : '' }}>Kiểu 6</option>
                  <option value="style-seven" {{ isset($wdata->template) && $wdata->template=='style-seven' ? 'selected="selected"' : '' }}>Kiểu 7</option>
                  <option value="style-picture" {{ isset($wdata->template) && $wdata->template=='style-picture' ? 'selected="selected"' : '' }}>Kiểu Hình ảnh</option>
                  <option value="style-video" {{ isset($wdata->template) && $wdata->template=='style-video' ? 'selected="selected"' : '' }}>Kiểu Video</option>
              </select>
            </div>
            <label class="col-lg-2 control-label" for="title">Số lượng</label>
            <div class="col-lg-3">
              <select name="limit" class="form-control">
                @for($i=1; $i<20; $i++)
                  <option value="{{ $i }}" {{ isset($wdata->limit) && $wdata->limit==$i ? 'selected="selected"' : '' }}>{{$i}}</option>
                @endfor
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label" for="refpost">Hiện tin chéo</label>
            <div class="col-lg-4">
              <select name="refpost" class="form-control">
                <option value="yes" {{ isset($wdata->refpost) && $wdata->refpost=='yes' ? 'selected="selected"' : '' }}>Đúng</option>
                <option value="no" {{ isset($wdata->refpost) && $wdata->refpost=='no' ? 'selected="selected"' : '' }}>Sai</option>
              </select>
            </div>
            <label class="col-lg-2 control-label" for="sort">Theo sắp xếp</label>
            <div class="col-lg-3">
              <select name="sort" class="form-control" onchange='$(this).val()=="yes" ? $(".shownotsort").hide() : $(".shownotsort").show() '>
                <option onclick='$(".shownotsort").show()' value="no" {{ isset($wdata->sort) && $wdata->sort=='no' ? 'selected="selected"' : '' }}>Sai</option>
                <option onclick='' value="yes" {{ isset($wdata->sort) && $wdata->sort=='yes' ? 'selected="selected"' : '' }}>Đúng</option>
              </select>
            </div>
          </div>
          <hr />
          <div class="form-group shownotsort" style="{{ isset($wdata->sort) && $wdata->sort=='yes' ? 'display: none' : ''  }}">
            <label class="col-lg-2 control-label" for="title">Bài nổi bật</label>
            <div class="col-lg-4">
              <select name="is_featured" class="form-control">
                <option value="yes" {{ isset($wdata->is_featured) && $wdata->is_featured=='yes' ? 'selected="selected"' : '' }}>Đúng</option>
                <option value="no" {{ isset($wdata->is_featured) && $wdata->is_featured=='no' ? 'selected="selected"' : '' }}>Sai</option>
              </select>
            </div>
            <label class="col-lg-2 control-label" for="title">Phổ biến</label>
            <div class="col-lg-3">
              <select name="is_popular" class="form-control">
                <option value="yes" {{ isset($wdata->is_popular) && $wdata->is_popular=='yes' ? 'selected="selected"' : '' }}>Đúng</option>
                <option value="no" {{ isset($wdata->is_popular) && $wdata->is_popular=='no' ? 'selected="selected"' : '' }}>Sai</option>
              </select>
            </div>
          </div>
          <div class="form-group shownotsort" style="{{ isset($wdata->sort) && $wdata->sort=='yes' ? 'display: none' : ''  }}">
            <label class="col-lg-2 control-label" for="title">Hiện ở Danh mục</label>
            <div class="col-lg-4">
              <select name="showon_category" class="form-control">
                <option value="yes" {{ isset($wdata->showon_category) && $wdata->showon_category=='yes' ? 'selected="selected"' : '' }}>Đúng</option>
                <option value="no" {{ isset($wdata->showon_category) && $wdata->showon_category=='no' ? 'selected="selected"' : '' }}>Sai</option>
              </select>
            </div>
            <label class="col-lg-2 control-label" for="showon_homepage">Hiện ở Trang chủ</label>
            <div class="col-lg-3">
              <select name="showon_homepage" class="form-control">
                <option value="yes" {{ isset($wdata->showon_homepage) && $wdata->showon_homepage=='yes' ? 'selected="selected"' : '' }}>Đúng</option>
                <option value="no" {{ isset($wdata->showon_homepage) && $wdata->showon_homepage=='no' ? 'selected="selected"' : '' }}>Sai</option>
              </select>
            </div>
          </div>
          <hr />
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