@extends('backend/layouts/default')

{{-- Web site Title --}}
@section('title')
Tạo nhóm mới ::
@parent
@stop

{{-- Content --}}
@section('content')
<h3>
	<span class="glyphicon glyphicon-user"></span> Tạo nhóm mới
</h3>


<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	<div class="box box-solid">
	    <div class="box-header">
	    </div><!-- /.box-header -->
	    <div class="box-body">
	    	<div class="row">
		    	<div class="col-md-4 col-sm-5">
		    		<h4>Thông tin cơ bản</h4>
		    		<div>
						<!-- Name -->
						<div class="form-group {{ $errors->has('name') ? 'error' : '' }}">
							<label class="control-label col-md-4" for="name">Tên nhóm</label>
							<div class="col-md-8">
								<input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name') }}" />
								{{ $errors->first('name', '<span class="help-inline">:message</span>') }}
							</div>
						</div>
		    		</div>
		    	</div>
		    	<div class="col-md-8 col-sm-7">
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
				    				<tr>
	                                    <td>{{ $permission['label'] }}</td>
	                                    <td>
	                                        <input type="radio" value="1" id="{{ $permission['permission'] }}_allow" name="permissions[{{ $permission['permission'] }}]"{{ (array_get($selectedPermissions, $permission['permission']) === 1 ? ' checked="checked"' : '') }}>
	                                    </td>
	                                    <td>
	                                    	<input type="radio" value="0" id="{{ $permission['permission'] }}_deny" name="permissions[{{ $permission['permission'] }}]"{{ ( ! array_get($selectedPermissions, $permission['permission']) ? ' checked="checked"' : '') }}>
	                                    </td>
	                                </tr>
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
		<button type="submit" class="btn btn-success btn-sm">Tạo mới</button>
	</div>
</form>
@stop
