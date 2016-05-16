@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Sửa người dùng ::
@parent
@stop

{{-- Page content --}}
@section('content')
<h3>
	<span class="glyphicon glyphicon-user"></span> Cập nhật thông tin người dùng
</h3>

<form class="form-horizontal" role="form" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	<div class="box box-solid">
	    <div class="box-header">
	    </div><!-- /.box-header -->
	    <div class="box-body">
	    	<div class="row">
		    	<div class="col-sm-4">
		    		<h4>Thông tin cơ bản</h4>
		    		<div>		    			
						<!-- User Name -->
						<div class="form-group {{ $errors->has('username') ? 'error' : '' }}">
							<label class="control-label col-md-4" for="username">Nickname</label>
							<div class="col-md-8">
								<input class="form-control" type="text" name="username" id="username" value="{{ Input::old('username', $user->username) }}" />
								{{ $errors->first('username', '<span class="help-inline">:message</span>') }}
							</div>
						</div>

						<!-- First Name -->
						<div class="form-group {{ $errors->has('first_name') ? 'error' : '' }}">
							<label class="control-label col-md-4" for="first_name">Tên</label>
							<div class="col-md-8">
								<input class="form-control" type="text" name="first_name" id="first_name" value="{{ Input::old('first_name', $user->first_name) }}" />
								{{ $errors->first('first_name', '<span class="help-inline">:message</span>') }}
							</div>
						</div>

						<!-- Last Name -->
						<div class="form-group {{ $errors->has('last_name') ? 'error' : '' }}">
							<label class="control-label col-md-4" for="last_name">Tên đệm</label>
							<div class="col-md-8">
								<input class="form-control" type="text" name="last_name" id="last_name" value="{{ Input::old('last_name', $user->last_name) }}" />
								{{ $errors->first('last_name', '<span class="help-inline">:message</span>') }}
							</div>
						</div>

						<!-- Email -->
						<div class="form-group {{ $errors->has('email') ? 'error' : '' }}">
							<label class="control-label col-md-4" for="email">Email</label>
							<div class="col-md-8">
								<input class="form-control" type="text" name="email" id="email" value="{{ Input::old('email', $user->email) }}" />
								{{ $errors->first('email', '<span class="help-inline">:message</span>') }}
							</div>
						</div>

						<!-- Password -->
						<div class="form-group {{ $errors->has('password') ? 'error' : '' }}">
							<label class="control-label col-md-4" for="password">Mật khẩu</label>
							<div class="col-md-8">
								<input class="form-control" type="password" name="password" id="password" value="" />
								{{ $errors->first('password', '<span class="help-inline">:message</span>') }}
							</div>
						</div>

						<!-- Password Confirm -->
						<div class="form-group {{ $errors->has('password_confirm') ? 'error' : '' }}">
							<label class="control-label col-md-4" for="password_confirm">Xác nhận mật khẩu</label>
							<div class="col-md-8">
								<input class="form-control" type="password" name="password_confirm" id="password_confirm" value="" />
								{{ $errors->first('password_confirm', '<span class="help-inline">:message</span>') }}
							</div>
						</div>

						<!-- Activation Status -->
						<div class="form-group {{ $errors->has('activated') ? 'error' : '' }}">
							<label class="control-label col-md-4" for="activated">Kích hoạt</label>
							<div class="col-md-8">
								<select class="form-control" {{ ($user->id === Sentry::getId() ? ' disabled="disabled"' : '') }} name="activated" id="activated">
									<option value="1"{{ ($user->isActivated() ? ' selected="selected"' : '') }}>@lang('general.yes')</option>
									<option value="0"{{ ( ! $user->isActivated() ? ' selected="selected"' : '') }}>@lang('general.no')</option>
								</select>
								{{ $errors->first('activated', '<span class="help-inline">:message</span>') }}
							</div>
						</div>
						@if(Permission::has_access('user', 'permission', $user->id))
						<!-- Groups -->
						<div class="form-group {{ $errors->has('groups') ? 'error' : '' }}">
							<label class="control-label col-md-4" for="groups">Nhóm</label>
							<div class="col-md-8">
								<select class="form-control" name="groups[]" id="groups[]" multiple>
									@foreach ($groups as $group)
									<option value="{{ $group->id }}"{{ (array_key_exists($group->id, $userGroups) ? ' selected="selected"' : '') }}>{{ $group->name }}</option>
									@endforeach
								</select>

								<span class="help-block">
									Chọn nhóm để gán quyền cho người dùng, mỗi người dùng chỉ có quyền hạn trên các nhóm mà họ được gán quyền.
								</span>
							</div>
						</div>
						@else
							<select class="form-control hidden" name="groups[]" id="groups[]" multiple>
								@foreach ($groups as $group)
								<option value="{{ $group->id }}"{{ (array_key_exists($group->id, $userGroups) ? ' selected="selected"' : '') }}>{{ $group->name }}</option>
								@endforeach
							</select>
						@endif
		    		</div>
		    	</div>
		    	<div class="col-sm-4">
		    		@if(Permission::has_access('user', 'permission', $user->id))
		    		<h4>Phân quyền Chuyên mục</h4>
		    		<div>
		    			<table class="table table-bordered">
		    				<tr>
                                <th>Tên</th>
                                <th style="width: 40px"><span class="label label-success">Cho phép</span></th>
                                <th style="width: 40px"><span class="label label-danger">Từ chối</span></th>
	                            <th style="width: 40px"><span class="label label-warning">Kế thừa</span></th>
                            </tr>
		    				@foreach ($catPermissions as $key => $cps)
		    					@foreach ($cps as $cp)
			    				<tr>
	                                <td><strong>{{ $cp['label'] }}</strong></td>
                                    <td>
                                        <input type="radio" value="1" id="{{ $cp['permission'] }}_allow" name="permissions[{{ $cp['permission'] }}]"{{ (array_get($userPermissions, $cp['permission']) === 1 ? ' checked="checked"' : '') }}>
                                    </td>
                                    <td>
	                                    <input type="radio" value="-1" id="{{ $cp['permission'] }}_deny" name="permissions[{{ $cp['permission'] }}]"{{ (array_get($userPermissions, $cp['permission']) === -1 ? ' checked="checked"' : '') }}>
                                    </td>
                                    <td>
                                    	@if ($cp['can_inherit'])<input type="radio" value="0" id="{{ $cp['permission'] }}_inherit" name="permissions[{{ $cp['permission'] }}]"{{ ( ! array_get($userPermissions, $cp['permission']) ? ' checked="checked"' : '') }}>@endif
                                    </td>
	                            </tr>
	                            @endforeach
                            @endforeach
                        </table>
		    		</div>
		    		@endif
		    	</div>
		    	<div class="col-sm-4">		    		
		    		@if(Permission::has_access('user', 'permission', $user->id))
		    		<h4>Quyền hạn</h4>
		    		<div>
		    			@foreach ($permissions as $area => $permissions)
			    			<table class="table table-bordered">
			    				<tr>
	                                <th>{{ $area }}</th>
	                                <th style="width: 40px"><span class="label label-success">Cho phép</span></th>
	                                <th style="width: 40px"><span class="label label-danger">Từ chối</span></th>
	                                <th style="width: 40px"><span class="label label-warning">Kế thừa</span></th>
	                            </tr>
				    			@foreach ($permissions as $permission)
				    				<tr>
	                                    <td>{{ $permission['label'] }}</td>
	                                    <td>
	                                        <input type="radio" value="1" id="{{ $permission['permission'] }}_allow" name="permissions[{{ $permission['permission'] }}]"{{ (array_get($userPermissions, $permission['permission']) === 1 ? ' checked="checked"' : '') }}>
	                                    </td>
	                                    <td>
	                                    	<input type="radio" value="-1" id="{{ $permission['permission'] }}_deny" name="permissions[{{ $permission['permission'] }}]"{{ (array_get($userPermissions, $permission['permission']) === -1 ? ' checked="checked"' : '') }}>
	                                    </td>
	                                    <td>
	                                    	@if ($permission['can_inherit'])<input type="radio" value="0" id="{{ $permission['permission'] }}_inherit" name="permissions[{{ $permission['permission'] }}]"{{ ( ! array_get($userPermissions, $permission['permission']) ? ' checked="checked"' : '') }}>@endif
	                                    </td>
	                                </tr>
			    				@endforeach
			    			</table>
		    			@endforeach
		    		</div>
		    		@endif
		    	</div>
	    	</div>
	    </div>
	</div>

	<!-- Form Actions -->
	<div class="control-group" align="right">
		<div class="controls">
			<a class="btn btn-link" href="{{ route('users') }}">Hủy</a>
			<button type="submit" class="btn btn-success">Cập nhật</button>
		</div>
	</div>
</form>
@stop
