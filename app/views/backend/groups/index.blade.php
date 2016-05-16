@extends('backend/layouts/default')

{{-- Web site Title --}}
@section('title')
Quản lý nhóm ::
@parent
@stop

{{-- Content --}}
@section('content')
<h3>
	<span class="glyphicon glyphicon-user"></span> Quản lý nhóm

	@if ( Sentry::getUser()->hasAnyAccess(['group','group.create']) )
		<a href="{{ route('create/group') }}" class="btn btn-xs btn-default"><i class="icon-plus-sign icon-white"></i> Tạo mới</a>
	@endif
</h3>
<div class="box">
    <div class="box-header">
    </div><!-- /.box-header -->
    <div class="box-body">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th class="span1">@lang('admin/groups/table.id')</th>
					<th class="span6">@lang('admin/groups/table.name')</th>
					<th class="span2">@lang('admin/groups/table.users')</th>
					<th class="span2">@lang('admin/groups/table.created_at')</th>
					<th class="span2">@lang('table.actions')</th>
				</tr>
			</thead>
			<tbody>
				@if ($groups->count() >= 1)
				@foreach ($groups as $group)
				<tr>
					<td>{{ $group->id }}</td>
					<td>{{ $group->name }}</td>
					<td>{{ $group->users()->count() }}</td>
					<td>{{ $group->created_at->diffForHumans() }}</td>
					<td>
						@if ( Sentry::getUser()->hasAnyAccess(['group','group.edit']) )
							<a href="{{ route('update/group', $group->id) }}" class="btn btn-xs btn-default">@lang('button.edit')</a>
						@endif
						@if ( Sentry::getUser()->hasAnyAccess(['group','group.delete']) )
							<a href="{{ route('delete/group', $group->id) }}" class="btn btn-mini btn-danger">@lang('button.delete')</a>
						@endif
					</td>
				</tr>
				@endforeach
				@else
				<tr>
					<td colspan="5">Chưa có bản ghi nào.</td>
				</tr>
				@endif
			</tbody>
		</table>

		{{ $groups->links() }}
	</div>
</div>
@stop
