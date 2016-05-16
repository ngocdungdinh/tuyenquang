@if($post->status=='published')
	<span class="label label-success">Bài viết đã xuất bản</span> <a href="{{ $post->url() }}" target="_blank" class="btn btn-xs"><i class="fa fa-eye"></i> Xem</a> - 
	@if (Permission::has_access('news', 'publish') || Permission::has_access('news', 'unpublish') || Permission::has_access('news', 'full'))
		<a data-toggle="modal" href="{{ URL::to('admin/news/addnote?post_id='.$post->id.'&status=unpublish') }}" data-target="#modal_display" class="btn btn-app btooltip show-modal" data-toggle="tooltip" title="Ngừng xuất bản bài này"><span class="glyphicon glyphicon-repeat"></span> Gỡ bài</a>
	@endif
@elseif($post->status=='reviewed')
	<span class="label label-success">Bài viết đã được biên tập</span> - 
	@if (Permission::has_access('news', 'publish') || Permission::has_access('news', 'full'))
		<button onclick="updatePost('published')" class="btn btn-app btooltip" data-toggle="tooltip" title="Xuất bản bài này"><span class="glyphicon glyphicon-ok-sign"></span> Xuất bản</button>
	@endif
	@if (Permission::has_access('news', 'review') || Permission::has_access('news', 'publish') || Permission::has_access('news', 'full'))
		<button data-toggle="modal" href="{{ URL::to('admin/news/addnote?post_id='.$post->id.'&status=returned') }}" data-target="#modal_display" class="btn btn-app btooltip show-modal" data-toggle="tooltip" title="Trả lại bài này cho người viết"><span class="glyphicon glyphicon-repeat"></span> Trả lại</button>
	@endif
@elseif($post->status=='reviewing')
	<span class="label label-info">Bài viết đang được biên tập</span> - 
	@if (Permission::has_access('news', 'publish') || Permission::has_access('news', 'full'))
		<button onclick="updatePost('published')" class="btn btn-app btooltip" data-toggle="tooltip" title="Xuất bản bài này"><span class="glyphicon glyphicon-ok-sign"></span> Xuất bản</button>
	@endif
	@if (Permission::has_access('news', 'review') || Permission::has_access('news', 'publish') || Permission::has_access('news', 'full'))
		<button data-toggle="modal" href="{{ URL::to('admin/news/addnote?post_id='.$post->id.'&status=reviewed') }}" data-target="#modal_display" class="btn btn-app btooltip show-modal" data-toggle="tooltip" title="Biên tập xong bài này"><span class="fa fa-pencil-square"></span> Duyệt xong</button>
		<button onclick="updatePost('returned')" class="btn btn-app btooltip" data-toggle="tooltip" title="Trả lại bài này cho người viết"><span class="glyphicon glyphicon-repeat"></span> Trả lại</button>
	@endif
@elseif($post->status=='submitted')
	<span class="label label-info">Bài viết đang đợi xét duyệt</span> - 
	@if (Permission::has_access('news', 'publish') || Permission::has_access('news', 'full'))
		<button onclick="updatePost('published')" class="btn btn-app btooltip" data-toggle="tooltip" title="Xuất bản bài này"><span class="glyphicon glyphicon-ok-sign"></span> Xuất bản</button>
	@endif
	@if (Permission::has_access('news', 'review') || Permission::has_access('news', 'publish') || Permission::has_access('news', 'full'))
		<button onclick="updatePost('reviewing')" class="btn btn-app btooltip" data-toggle="tooltip" title="Nhận duyệt và biên tập bài này"><span class="fa fa-pencil-square"></span> Nhận duyệt</button>
		<button onclick="updatePost('returned')" class="btn btn-app btooltip" data-toggle="tooltip" title="Trả lại bài này cho người viết"><span class="glyphicon glyphicon-repeat"></span> Trả lại</button>
	@endif
@elseif($post->status=='unpublish')
	<span class="label label-default">Bài viết bị gỡ bỏ</span> - 
	@if (Permission::has_access('news', 'edit'))
		<a onclick="confirmDelete(this); return false;" href="{{ route('restore/news', $post->id) }}" class="btn btn-app btn-default btooltip" data-toggle="tooltip" title="Nhận viết bài này"><span class="glyphicon glyphicon-import"></span> Nhận viết</a>
	@endif
@elseif($post->status=='returned')
	<span class="label label-default">Bài viết bị trả lại</span> - 
	@if (Permission::has_access('news', 'edit'))
		<a onclick="confirmDelete(this); return false;" href="{{ route('restore/news', $post->id) }}" class="btn btn-app btn-default btooltip" data-toggle="tooltip" title="Nhận viết bài này"><span class="glyphicon glyphicon-import"></span> Nhận viết</a>
	@endif
@elseif($post->status=='draft')
	<span class="label label-default">Bản nháp</span> - 
	@if (Permission::has_access('news', 'publish') || Permission::has_access('news', 'full'))
		<button onclick="updatePost('published')" class="btn btn-app btooltip" data-toggle="tooltip" title="Xuất bản bài này"><span class="glyphicon glyphicon-ok-sign"></span> Xuất bản</button>
	@endif
	@if (Permission::has_access('news', 'edit', $post->user_id) || Permission::has_access('news', 'editowner', $post->user_id))
		<button onclick="updatePost('submitted')" class="btn btn-app btooltip" data-toggle="tooltip" title="Đẩy lên đợi xét duyệt để xuất bản"><span class="glyphicon glyphicon-repeat"></span> Xét duyệt</button>
	@endif
@endif
@if($post->status!='returned' && $post->status!='unpublish')
	@if (($post->status=='published' && Permission::has_access('news', 'editpublish')) || (($post->status=='draft') && Permission::has_access('news', 'edit', $post->user_id)) || (($post->status=='draft') && Permission::has_access('news', 'editowner', $post->user_id)))
		<button onclick="updatePost('{{ $post->status }}')" class="btn btn-app btooltip"><span class="glyphicon glyphicon-floppy-disk"></span> Lưu</button>
	@endif
@endif

@if ( ($post->status=='returned' || $post->status=='unpublish' || $post->status=='draft') && Permission::has_access('news', 'delete', $post->user_id))
	<a onclick="confirmDelete(this); return false;" href="{{ route('delete/news', $post->id) }}" class="btn btn-app"><span class="glyphicon glyphicon-trash"></span> @lang('button.delete')</a>
@endif