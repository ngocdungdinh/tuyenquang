@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Quản lý bình luận ::
@parent
@stop

{{-- Page content --}}
@section('content')
	<h3>
    	<span class="glyphicon glyphicon-pencil"></span> Bình luận
    </h3>
	<div class="box">
	    <div class="box-header">
	    </div><!-- /.box-header -->
	    <div class="box-body">
		    <div>    	
			    <ul class="nav nav-tabs">
				  <li {{ $status=='' ? 'class="active"' : '' }}><a href="{{ URL::to('admin/comments') }}">Tất cả</a></li>
				  <li {{ $status=='on' ? 'class="active"' : '' }}><a href="{{ URL::to('admin/comments?status=on') }}">Hiển thị</a></li>
				  <li {{ $status=='off' ? 'class="active"' : '' }}><a href="{{ URL::to('admin/comments?status=off') }}">Xét duyệt</a></li>
				</ul>
		    </div><br />
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th width="30">#</th>
						<th class="span5">Nội dung</th>
						<th width="200">Người gửi</th>
						<th width="90">Trạng thái</th>
						<th width="100">Gửi lúc</th>
						<th width="60">@lang('table.actions')</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($comments as $comment)
					<tr>
						<td>{{ $comment->id }}</td>
						<td>
							<div style="font-size: 14px;">{{ nl2br($comment->content) }}</div>
							<div style="font-size: 11px; color: #76797c; padding-top: 4px;"><strong>Trong bài:</strong> <a href="{{ $comment->post->url() }}" target="_blank">{{ $comment->post ? $comment->post->title : '' }}</a></div>
						</td>
						<td>{{ $comment->author ? $comment->author->first_name. ' ' .$comment->author->last_name .'<br />'. $comment->author->email : $comment->fullname.'<br />'.$comment->email }}</td>
						<td>
                        	<p class="comment-status">
								<input type="checkbox" name="comment_status" value="1" class="minimal-red update-cmt-status" data-commentid="{{ $comment->id }}" {{ $comment->status == 'on' ? 'checked="checked"' : ''}} />
							</p>
						</td>
						<td>{{ $comment->created_at->diffForHumans() }}</td>
						<td>
							<div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm btn-flat dropdown-toggle" data-toggle="dropdown">
                                    <span class="glyphicon glyphicon-cog"></span> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu left" role="menu">
                                    @if ( Sentry::getUser()->hasAnyAccess(['news','news.viewcomment']) )
                                    <li><a href="{{ $comment->post->url() }}" target="_blank"><span class="glyphicon glyphicon-eye-open"> Xem</a></li>
                                    @endif
									@if ( Sentry::getUser()->hasAnyAccess(['news','news.editcomment']) )
                                    <li><a href="{{ route('update/comment', $comment->id) }}"><span class="glyphicon glyphicon-edit"></span>  @lang('button.edit')</a></li>
                                    @endif
                                    @if ( Sentry::getUser()->hasAnyAccess(['news','news.deletecomment']) )
                                    <li class="divider"></li>
                                    <li><a onclick="confirmDelete(this); return false;" href="{{ route('delete/comment', $comment->id) }}"><span class="glyphicon glyphicon-trash"></span> Xóa</a></li>
                                    @endif
                                </ul>
                            </div>
							<!-- <a href="{{ route('delete/comment', $comment->id) }}" class="btn btn-danger btn-xs">@lang('button.delete')</a> -->
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>

			{{ $comments->links() }}
		</div>
	</div>
@stop
