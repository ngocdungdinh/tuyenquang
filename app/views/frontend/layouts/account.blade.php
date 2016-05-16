@extends('frontend/layouts/default')

{{-- Page content --}}
@section('content')
<div class="row">
	<div>
		<div class="box-info">
			<div class="well p2">
				<div>
					<div class="nav-top">
				        <ul class="nav nav-tabs">
							<li{{ Request::is('account/profile') ? ' class="active"' : '' }}><a href="{{ URL::route('profile') }}{{ Request::has('uid') ? '?uid='.Request::query('uid') : '' }}">Thông tin cá nhân</a></li>
							<li{{ Request::is('account/avatar') ? ' class="active"' : '' }}><a href="{{ URL::route('avatar') }}{{ Request::has('uid') ? '?uid='.Request::query('uid') : '' }}">Ảnh đại diện</a></li>
							<li{{ Request::is('account/change-password') ? ' class="active"' : '' }}><a href="{{ URL::route('change-password') }}{{ Request::has('uid') ? '?uid='.Request::query('uid') : '' }}">Đổi mật khẩu</a></li>
							<li{{ Request::is('account/change-email') ? ' class="active"' : '' }}><a href="{{ URL::route('change-email') }}{{ Request::has('uid') ? '?uid='.Request::query('uid') : '' }}">Đổi Email</a></li>
						</ul>
				    </div>
				</div>
				@yield('account-content')
			</div>
		</div>
	</div>
</div>
@stop
