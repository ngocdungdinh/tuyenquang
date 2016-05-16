<div rel="{{ $image->id }}" style="width: 110px; float: left; margin: 5px 5px; ">
  <div class="thumbnail">
    <div style="height:100px;">
      <img src="{{ asset($image->mpath .'/100x100_crop/'. $image->mname ) }}" width="100" />
    </div>
    <div class="caption">
      <div class="action_buttons">
        <a onclick="confirmDelete(this); return false;" href="{{ route('delete/media', $image->id) }}" class="btn btn-danger btn-xs">@lang('button.delete')</a>
      </div>
    </div>
  </div>
</div>