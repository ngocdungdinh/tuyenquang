<div class="dd-handle nested-list-handle">
<span class="glyphicon glyphicon-move"></span>
</div>
<div class="nested-list-content">
	{{ $link->title }} - <small>{{ $link->url }}</small> 
<div class="pull-right">
	<small>{{ ucwords($link->type) }}</small>
	<a href="javascript:void(0)" onclick="$('#editLinkForm{{$link->id}}').toggle();" class="btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
</div>
</div>
<div id="editLinkForm{{$link->id}}" style="display: none">
	@if ( Sentry::getUser()->hasAnyAccess(['menus','menus.edit']) )
		<div class="box box-solid">
			<div class="box-body">
				<form method="post" action="{{ route('create/link') }}" autocomplete="off" class="form-horizontal" role="form">
					<!-- CSRF Token -->
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<input type="hidden" name="link_id" value="{{ $link->id }}" />
					<input type="hidden" name="menu_id" value="{{ $link->menu_id }}" />
					<input type="hidden" name="parent_id" value="{{ $link->parent_id }}" />
					<input type="hidden" name="type" id="type" value="{{ $link->type }}" />
					<input type="hidden" name="item_id" id="item_id" value="{{ $link->item_id }}" />
					<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
						<label class="col-sm-3 control-label" for="link-title">Tên liên kết</label>
						<div class="col-sm-4">
							<input class="form-control" type="text" name="title" id="link-title" value="{{  $link->title }}" />
						</div>
						<div class="col-sm-4">
							<input class="form-control" type="text" name="alt" id="" value="{{ $link->alt ? $link->alt : $link->title }}" placeholder="alt..." />
						</div>
					</div>
					<div class="form-group {{ $errors->has('alt') ? 'has-error' : '' }}">
						<label class="col-sm-3 control-label" for="url">Đường dẫn</label>
						<div class="col-sm-8" style="padding-top: 7px;">
							@if($link->type == 'category')
								Chuyên mục: <a href="/{{ $link->cat_slug }}" target="_blank">{{ $link->cat_name }}</a>
							@elseif($link->type == 'page')

							@else
								<input class="form-control" type="text" name="url" id="url" value="{{ $link->url }}" placeholder="http://" />
							@endif
						</div>
					</div>
					<div class="form-group">
						<label for="target" class="col-sm-3 control-label">Loại</label>
						<div class="col-sm-5">
							<select name="target" id="target" class="form-control">
								<option value="_self" {{ $link->target=='_self' ? 'selected="selected"' : '' }}>Mở ở trang hiện tại</option>
								<option value="_blank" {{ $link->target=='_blank' ? 'selected="selected"' : '' }}>Mở ở cửa sổ mới</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="target" class="col-sm-4 control-label"></label>
						<div class="col-sm-5">
							<button type="submit" class="btn btn-success btn-sm">Sửa</button>
							@if ( Sentry::getUser()->hasAnyAccess(['menus','menus.delete']) )
								<a onclick="confirmDelete(this); return false;" href="{{ route('delete/link', $link->id) }}" class="btn btn-danger btn-xs">@lang('button.delete')</a>
							@endif
						</div>
					</div>
				</form>
			</div>
		</div>
	@endif
</div>