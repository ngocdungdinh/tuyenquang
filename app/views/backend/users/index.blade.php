@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Quản lý người dùng ::
@parent
@stop

{{-- Page content --}}
@section('content')
<h3>
	<span class="glyphicon glyphicon-user"></span> Quản lý người dùng

	@if ( Sentry::getUser()->hasAnyAccess(['news','user.create']) )
		<a href="{{ route('create/user') }}" class="btn btn-xs btn-default"><i class="icon-plus-sign icon-white"></i> Tạo mới</a>
	@endif
</h3>
<div class="box">
    <div class="box-header">
    </div><!-- /.box-header -->
    <div class="box-body">
	    <form method="get" action="" autocomplete="off" role="form" class="form-inline">
			<!-- CSRF Token -->
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<div class="form-group {{ $errors->has('key') ? 'has-error' : '' }}">
				<input class="form-control" type="text" name="key" id="key" value="{{ Input::old('key', (isset($key) ? $key : '')) }}" placeholder="Tên" />
			</div>
			<div class="form-group {{ $errors->has('groupId') ? 'has-error' : '' }}">
				<select class="form-control" name="groupId" id="groupId">
					<option value="0">- Nhóm -</option>
					@foreach ($groups as $group)
						<option value="{{ $group->id }}"{{ $groupId == $group->id ? ' selected="selected"' : '' }}>{{ $group->name }}</option>
					@endforeach
				</select>
			</div>
			<input type="submit" class="btn btn-default btn-info" name="search" value="Tìm" />
		</form>
		<hr />
		<div>    	
		    <ul class="nav nav-tabs">
			  <li {{ $withTrashed || !$onlyTrashed ? 'class="active"' : '' }} ><a href="{{ URL::to('admin/users?withTrashed=true') }}">Tất cả</a></li>
			  <li {{ $onlyTrashed ? 'class="active"' : '' }}><a href="{{ URL::to('admin/users?onlyTrashed=true') }}">Không kích hoạt</a></li>
			</ul>
		</div><br />

		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th class="span1">@lang('admin/users/table.id')</th>
					<th class="span2">@lang('admin/users/table.first_name')</th>
					<th class="span2">@lang('admin/users/table.last_name')</th>
					<th class="span3">@lang('admin/users/table.email')</th>
					<th class="span3">Quyền hạn</th>
					<th class="span2">@lang('admin/users/table.activated')</th>
					<th class="span2">@lang('admin/users/table.created_at')</th>
					<th class="span2">Đăng nhập lúc</th>
					<th class="span2">@lang('table.actions')</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($users as $user)
				<tr>
					<td>{{ $user->id }}</td>
					<td>{{ $user->first_name }}</td>
					<td>{{ $user->last_name }}</td>
					<td>{{ $user->email }}</td>
					<td>
						@foreach($user->groups as $key => $group)
							{{ $group->name.($key+1 == $user->groups->count() ? '' : ', ') }}
						@endforeach
					</td>
					<td>@lang('general.' . ($user->isActivated() ? 'yes' : 'no'))</td>
					<td>{{ $user->created_at->diffForHumans() }}</td>
					<td>{{ $user->last_login }}</td>
					<td>
						@if ( Sentry::getUser()->hasAnyAccess(['user','user.edit']) )
							<a href="{{ route('update/user', $user->id) }}" class="btn btn-default btn-xs">@lang('button.edit')</a>
						@endif
						@if ( ! is_null($user->deleted_at))
							@if ( Sentry::getUser()->hasAnyAccess(['user','user.delete']) )
								<a href="{{ route('restore/user', $user->id) }}" class="btn btn-xs btn-warning">@lang('button.restore')</a>
							@endif
						@else
							@if (Sentry::getId() !== $user->id && Sentry::getUser()->hasAnyAccess(['user','user.delete']))
								<a href="{{ route('delete/user', $user->id) }}" class="btn btn-xs btn-danger">@lang('button.delete')</a>
							@else
								<span class="btn btn-xs btn-danger disabled">@lang('button.delete')</span>
							@endif
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>

		{{ $users->links() }}
	</div>
</div>
@stop
