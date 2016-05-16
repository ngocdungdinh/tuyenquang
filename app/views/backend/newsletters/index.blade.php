@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Quản lý tin ::
@parent
@stop

{{-- Page content --}}
@section('content')
	<h3>
    	<span class="glyphicon glyphicon-time"></span> Hệ thống tự động
    </h3>
	<hr />
	<div>
		
	</div>
	<h3>
    	<span class="glyphicon glyphicon-envelope"></span> Email đăng kí nhận newsletter
    </h3>
    <div>
	    <ul class="nav nav-tabs">
		  <li {{ $type=='' ? 'class="active"' : '' }}><a href="{{ URL::to('admin/newsletters') }}"><span class="glyphicon glyphicon-th-list"></span> Tất cả</a></li>
		  <li {{ $type=='guest' ? 'class="active"' : '' }}><a href="{{ URL::to('admin/newsletters?type=guest') }}"><span class="glyphicon glyphicon-info-sign"></span> Khách</a></li>
		  <li {{ $type=='user' ? 'class="active"' : '' }}><a href="{{ URL::to('admin/newsletters?type=user') }}"><span class="glyphicon glyphicon-user"></span> Thành viên</a></li>
		  <li {{ $type=='invalid' ? 'class="active"' : '' }}><a href="{{ URL::to('admin/newsletters?type=invalid') }}"><span class="glyphicon glyphicon-ban-circle"></span> Không hợp lệ</a></li>
		  <li {{ $type=='trash' ? 'class="active"' : '' }}><a href="{{ URL::to('admin/newsletters?type=trash') }}"><span class="glyphicon glyphicon-trash"></span> Thùng rác</a></li>
		</ul>
		<hr />
		<div>
			@if($newsletters->count())
			<table class="table table-hover">
				<thead>
					<tr>
						<th width="60"></th>
						<th class="span6">Email</th>
						<th class="span2">User</th>
						<th class="span2"></th>
						<th width="80">News</th>
						<th width="80">Status</th>
						<th width="150">Ngày</th>
						<th width="40"></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($newsletters as $nl)
					<tr>
						<td>
						</td>
						<td>
							{{ $nl->email }}
						</td>
						<td>
							@if($nl->uid)
								<a href="/admin/users/{{ $nl->uid }}/edit">{{ $nl->first_name }} {{ $nl->last_name }}</a>
							@else
								Khách
							@endif
						</td>
						<td>
							@if($nl->is_conceive)
								<div class="label label-default">Chuẩn bị mang thai</div>
							@elseif($nl->is_pregnant)
								<div class="label label-success">Đang mang thai</div>
								{{ $nl->day }}/{{ $nl->month }}/{{ $nl->year }}
							@elseif($nl->is_baby)
								<div class="label label-warning">Đã chào đời</div>
								{{ $nl->day }}/{{ $nl->month }}/{{ $nl->year }}
							@endif
						</td>
						<td>
							@if($nl->is_news)
								<span class="glyphicon glyphicon-ok"></span>
							@endif
						</td>
						<td>
							@if($nl->ntype == 'invalid')
								<span class="glyphicon glyphicon-ban-circle text-danger"></span>
							@endif
						</td>
						<td>
							{{ $nl->created_at->diffForHumans() }}
						</td>
						<td>
							<div class="dropdown">
							  <a data-toggle="dropdown" href="#" class="btn btn-info btn-xs">...</a>
							  <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel" style="right: 0; left: auto">
							  	@if($nl->ntype !== 'invalid')
							    	<li><a onclick="confirmDelete(this); return false;" href="/admin/newsletters/{{ $nl->id }}/1/invalid">Không hợp lệ</a></li>
							    @else
							    	<li><a onclick="confirmDelete(this); return false;" href="/admin/newsletters/{{ $nl->id }}/0/invalid">Hợp lệ</a></li>
							    @endif
							    @if($nl->trashed())
							    	<li><a onclick="confirmDelete(this); return false;" href="/admin/newsletters/{{ $nl->id }}/restore">Khôi phục</a></li>
							    @else
							    	<li><a onclick="confirmDelete(this); return false;" href="/admin/newsletters/{{ $nl->id }}/delete">Xóa</a></li>
							    @endif
							  </ul>
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@else
				<div class="well"> - chưa có dữ liệu - </div>
			@endif
		</div>
    </div>
    <hr />
    {{ $newsletters->appends(array('type' => $type))->links() }}
@stop