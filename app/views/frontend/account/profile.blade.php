@extends('frontend/layouts/account')

{{-- Page title --}}
@section('title')
Đổi thông tin cá nhân
@endsection

{{-- Account page content --}}
@section('account-content')
<form method="post" action="" class="form-horizontal" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	<input type="hidden" id="placeId" name="place_id" value="{{ $user->place_id }}" />
	<div class="row">
		<div class="col-lg-1"></div>	
		<div class="col-lg-8">
			<!-- First Name -->
			<div class="form-group{{ $errors->first('username', ' has-error') }}">
				<label class="col-lg-3 control-label" for="username">Nick name</label>
				<div class="col-lg-8">
					<input class="form-control" type="text" disabled name="username" id="username" value="{{ Input::old('username', $user->username) }}" />
					{{ $errors->first('username', '<span class="help-block">:message</span>') }}
				</div>
			</div>
			<!-- First Name -->
			<div class="form-group{{ $errors->first('first_name', ' has-error') }}">
				<label class="col-lg-3 control-label" for="first_name">Tên</label>
				<div class="col-lg-8">
					<input class="form-control" type="text" name="first_name" id="first_name" value="{{ Input::old('first_name', $user->first_name) }}" />
					{{ $errors->first('first_name', '<span class="help-block">:message</span>') }}
				</div>
			</div>

			<!-- Last Name -->
			<div class="form-group{{ $errors->first('last_name', ' has-error') }}">
				<label class="col-lg-3 control-label" for="last_name">Họ</label>
				<div class="col-lg-8">
					<input class="form-control" type="text" name="last_name" id="last_name" value="{{ Input::old('last_name', $user->last_name) }}" />
					{{ $errors->first('last_name', '<span class="help-block">:message</span>') }}
				</div>
			</div>

			<!-- Last Name -->
			<div class="form-group{{ $errors->first('gender', ' has-error') }}">
				<label class="col-lg-3 control-label" for="gender">Giới tính</label>
				<div class="col-lg-4">
					<select class="form-control" name="gender" id="gender">
						<option value="male" {{ Input::old('gender', $user->gender)=='male' ? 'selected="selected"' : '' }}>Nam</option>
						<option value="female" {{ Input::old('gender', $user->gender)=='female' ? 'selected="selected"' : '' }}>Nữ</option>
						<option value="na" {{ Input::old('gender', $user->gender)=='na' ? 'selected="selected"' : '' }}>Không xác định</option>
					</select>
					{{ $errors->first('gender', '<span class="help-block">:message</span>') }}
				</div>
			</div>
			<!-- Last Name -->
			<div class="form-group{{ $errors->first('birth_day', ' has-error') }}">
				<label class="col-lg-3 control-label" for="birth_day">Sinh nhật</label>
				<div class="col-lg-3" style="padding-right: 5px; width: 100px">
					<select class="form-control" name="birth_day" id="gender">
						<option value="0" {{ Input::old('birth_day', $user->birth_day)==0 ? 'selected="selected"' : '' }}>--</option>
						@for($i = 1; $i < 32; $i++)
							<option value="{{$i}}" {{ Input::old('birth_day', $user->birth_day)==$i ? 'selected="selected"' : '' }}>{{$i}}</option>
						@endfor
					</select>
				</div>
				<div class="col-lg-3" style="padding-right: 5px; padding-left: 5px; width: 100px">
					<select class="form-control" name="birth_month" id="gender">
						<option value="0" {{ Input::old('birth_month', $user->birth_month)==0 ? 'selected="selected"' : '' }}>--</option>
						@for($i = 1; $i < 13; $i++)
							<option value="{{$i}}" {{ Input::old('birth_month', $user->birth_month)==$i ? 'selected="selected"' : '' }}>{{$i}}</option>
						@endfor
					</select>
				</div>
				<div class="col-lg-3" style=" padding-left: 5px;">
					<select class="form-control" name="birth_year" id="gender">
						<option value="0" {{ Input::old('birth_year', $user->birth_year)==0 ? 'selected="selected"' : '' }}>--</option>
						@for($i = 1949; $i < 2013; $i++)
							<option value="{{$i}}" {{ Input::old('birth_year', $user->birth_year)==$i ? 'selected="selected"' : '' }}>{{$i}}</option>
						@endfor
					</select>
				</div>
			</div>
			<hr />
			<!-- Last Name -->
			<div class="form-group{{ $errors->first('phone', ' has-error') }}">
				<label class="col-lg-3 control-label" for="phone">Điện thoại</label>
				<div class="col-lg-4">
					<input class="form-control" type="tel" name="phone" id="phone" value="{{ Input::old('phone', $user->phone) }}" />
					{{ $errors->first('phone', '<span class="help-block">:message</span>') }}
				</div>
				<div class="col-lg-4" style="padding-left: 5px;">
					<select class="form-control" name="phone_cog" id="phone_cog">
						<option value="2" {{ Input::old('phone_cog', $user->phone_cog)==2 ? 'selected="selected"' : '' }}>Công khai</option>
						<option value="0" {{ Input::old('phone_cog', $user->phone_cog)==0 ? 'selected="selected"' : '' }}>Riêng tư</option>
					</select>
				</div>
			</div>

			<!-- Hometown -->
			<div class="form-group{{ $errors->first('hometown', ' has-error') }}">
				<label class="col-lg-3 control-label" for="hometown">Quê quán</label>
				<div class="col-lg-8">
					<input class="form-control" type="text" name="hometown" id="hometown" value="{{ Input::old('hometown', $user->hometown) }}" />
					{{ $errors->first('hometown', '<span class="help-block">:message</span>') }}
				</div>
			</div>

			<!-- Website URL -->
			<div class="form-group{{ $errors->first('website', ' has-error') }}">
				<label class="col-lg-3 control-label" for="website">Trang chủ</label>
				<div class="col-lg-8">
					<input class="form-control" type="text" name="website" id="website" value="{{ Input::old('website', $user->website) }}" />
					{{ $errors->first('website', '<span class="help-block">:message</span>') }}
				</div>
			</div>

			<!-- Country -->
			<div class="form-group{{ $errors->first('bio', ' has-error') }}">
				<label class="col-lg-3 control-label" for="bio">Giới thiệu</label>
				<div class="col-lg-8">
					<textarea style="height:200px;" class="form-control" type="text" name="bio" id="bio">{{ Input::old('bio', $user->bio) }}</textarea>
					{{ $errors->first('bio', '<span class="help-block">:message</span>') }}
				</div>
			</div>
		</div>
	</div>
	<hr />
	<!-- Form actions -->
	<div class="form-group">
		<div align="center">
			<button type="submit" class="btn btn-info">Cập nhật</button>
		</div>
	</div>
</form>
@stop
