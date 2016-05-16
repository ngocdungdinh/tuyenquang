<div rel="{{ $image->id }}" id="media_{{ $image->id }}" class="col-xs-12">
  <div class="thumbnail" style="margin-bottom: 6px;">
    <div class="row">
      <div class="col-xs-2">
        <div style="position: relative">
          @if($image->mtype == 'video')
            <img class="video-img" src="{{ asset('http://i.ytimg.com/vi/'. $image->mname.'/0.jpg') }}" width="100%" />
          @elseif($image->mtype == 'image')
            <img src="{{ asset($image->mpath .'/'.Config::get("image.featuredsize").'/'. $image->mname ) }}" width="100%" />
          @endif
        </div>
      </div>
      <div class="col-xs-1">
          @if($image->mtype == 'video')
            <span class="label label-warning">VIDEO</span>
          @elseif($image->mtype == 'image')
            <span class="label label-default">ẢNH</span>
          @endif
      </div>
      <div class="col-xs-3">
          <p><strong>{{ $image->first_name }} {{ $image->last_name }}</strong></p>
          <p><i>{{ $image->created_at }}</i></p>
      </div>
      <div class="col-xs-6" align="right">
        <div class="action_buttons">
          @if($env == 'product-images')
            <a class="btn btn-info btn-xs" rel="{{ $image->id }}" onclick="parent.addProductImage('{{ $image->id }}', this);" data-toggle="tooltip" data-placement="bottom" data-original-title="Thêm ảnh sản phẩm"><span class="glyphicon glyphicon-plus-sign"></span></a>
          @elseif($env == 'attributes')
            <a class="btn btn-warning btn-xs" href="javascript:void(0);" onclick="setCover('{{ $image->mpath }}', '{{ $image->mname }}', '{{ Config::get("image.featuredsize") }}', '{{ $image->id }}')" data-toggle="tooltip" data-placement="bottom" data-original-title="Chọn làm ảnh đại diện"><span class="glyphicon glyphicon-picture"></span></a>
          @elseif($env == 'handbooks')
            <a class="btn btn-info btn-xs" rel="{{ $image->id }}" onclick="parent.image_send_to_editor('{{ $image->mpath.'/'.Config::get('image.bodysize').'/'.$image->mname }}', this);" data-toggle="tooltip" data-placement="bottom" data-original-title="Thêm ảnh vào nội dung bài"><span class="glyphicon glyphicon-save"></span></a>
            <a class="btn btn-warning btn-xs" href="javascript:void(0);" onclick="setCover('{{ $image->mpath }}', '{{ $image->mname }}', '{{ Config::get("image.featuredsize") }}', '{{ $image->id }}')" data-toggle="tooltip" data-placement="bottom" data-original-title="Chọn làm ảnh đại diện"><span class="glyphicon glyphicon-picture"></span></a>
          @elseif($env == 'list')

          @else

          @if($image->mtype == 'video')
          @elseif($image->mtype == 'image')
            <a class="btn btn-info btn-xs" rel="{{ $image->id }}" onclick="parent.image_send_to_editor('{{ $image->mpath.'/'.Config::get('image.bodysize').'/'.$image->mname }}', this);" data-toggle="tooltip" data-placement="bottom" data-original-title="Thêm ảnh vào nội dung bài"><span class="glyphicon glyphicon-save"></span> Chèn ảnh</a>
          @endif
            <a class="btn btn-warning btn-xs" href="javascript:void(0);" onclick="setNewsCover('', '{{ $image->id }}')" data-toggle="tooltip" data-placement="bottom" data-original-title="Chọn làm ảnh đại diện"><span class="glyphicon glyphicon-picture"></span> Ảnh đại diện</a>
          @endif
          @if ( Permission::has_access('medias', 'full') || Permission::has_access('medias', 'delete', $image->user_id))
            <hr style="margin: 5px 0" />
            <a class="btn btn-danger btn-xs" onclick="removeMedia('{{ $image->id }}');" rel="{{ $image->id }}" data-toggle="tooltip" data-placement="bottom" data-original-title="Xóa ảnh"><span class="glyphicon glyphicon-remove"></span></a>
          @endif
          
          </span>
        </div>
      </div>
    </div>
  </div>
</div>