@extends('backend/layouts/default')

{{-- Web site Title --}}
@section('title')
Sửa nhóm người dùng ::
@parent
@stop

{{-- Content --}}
@section('content')
<h3>
	<span class="glyphicon glyphicon-user"></span> Sửa nhóm người dùng

	@if ( Sentry::getUser()->hasAnyAccess(['group','group.create']) )
		<a href="{{ route('create/group') }}" class="btn btn-xs btn-default"><i class="icon-plus-sign icon-white"></i> Tạo mới</a>
	@endif
</h3>

<form class="form-horizontal" method="post" action="" autocomplete="off">
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
						<!-- Name -->
						<div class="form-group {{ $errors->has('name') ? 'error' : '' }}">
							<label class="control-label col-md-4" for="name">Tên nhóm</label>
							<div class="col-md-8">
								<input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $group->name) }}" />
								{{ $errors->first('name', '<span class="help-inline">:message</span>') }}
							</div>
						</div>
		    		</div>
		    	</div>
		    	<div class="col-sm-4">
		    		<h4>Chuyên mục</h4>
		    		<div>
		    			<table class="table table-bordered">
		    				<tr>
                                <th>Tên</th>
                                <th style="width: 40px"><span class="label label-success">Cho phép</span></th>
                                <th style="width: 40px"><span class="label label-danger">Từ chối</span></th>
                            </tr>
		    				@foreach ($catPermissions as $key => $cps)
		    					@foreach ($cps as $cp)
			    				<tr>
	                                <td><strong>{{ $cp['label'] }}</strong></td>
                                    <td>
                                        <input type="radio" value="1" id="{{ $cp['permission'] }}_allow" name="permissions[{{ $cp['permission'] }}]"{{ (array_get($groupPermissions, $cp['permission']) === 1 ? ' checked="checked"' : '') }}>
                                    </td>
                                    <td>
                                    	<input type="radio" value="0" id="{{ $cp['permission'] }}_deny" name="permissions[{{ $cp['permission'] }}]"{{ ( ! array_get($groupPermissions, $cp['permission']) ? ' checked="checked"' : '') }}>
                                    </td>
	                            </tr>
	                            @endforeach
                            @endforeach
                        </table>
		    		</div>
		    	</div>
		    	<div class="col-sm-4">
		    		<h4>Quyền hạn</h4>
		    		<div>
		    			@foreach ($permissions as $area => $permissions)
			    			<table class="table table-bordered">
			    				<tr>
	                                <th>{{ $area }}</th>
	                                <th style="width: 40px"><span class="label label-success">Cho phép</span></th>
	                                <th style="width: 40px"><span class="label label-danger">Từ chối</span></th>
	                            </tr>
				    			@foreach ($permissions as $permission)
				    				@if($permission['type'] == 'sconf')
				    				<tr>
	                                    <td>{{ $permission['label'] }}</td>
	                                    <td>
	                                        <input type="radio" value="1" id="{{ $permission['permission'] }}_allow" name="permissions[{{ $permission['permission'] }}]"{{ (array_get($groupPermissions, $permission['permission']) === 1 ? ' checked="checked"' : '') }}>
	                                    </td>
	                                    <td>
	                                    	<input type="radio" value="0" id="{{ $permission['permission'] }}_deny" name="permissions[{{ $permission['permission'] }}]"{{ ( ! array_get($groupPermissions, $permission['permission']) ? ' checked="checked"' : '') }}>
	                                    </td>
	                                </tr>
	                                @endif
			    				@endforeach
			    			</table>
		    			@endforeach
		    		</div>
		    	</div>
		    </div>
		</div>
	</div>
	<div class="controls" align="right">
		<a class="btn btn-link" href="{{ route('groups') }}">Hủy</a>

		<button type="submit" class="btn btn-success btn-sm">Cập nhật</button>
	</div>
</form>
@stop
