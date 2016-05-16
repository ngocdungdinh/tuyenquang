@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
Theo dõi sự phát triển của bé ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="row">
	<div class="fast-news">
	</div>
</div>
<div class="row">
	<div class="col-md-5">
		<div class="box-info">
			<div class="well p2">
				@if(Session::get('tempemail') || isset($newsletter->email))
					<div class="alert alert-success">
						<div><strong>Nhận email thành công</strong></div>
						<div>Hệ thống sẽ tự động phân tích thông tin bạn đăng kí nhận email để thông báo hàng tuần về tình trạng phát triển của bé. Cảm ơn bạn!</div>
					</div>
					<div>
						<a href="/" class="btn btn-default">Quay lại trang chủ</a>
					</div>
				@else
					<form method="post" action="{{ URL::to('newsletters') }}" class="form-horizontal" role="form">
						<!-- CSRF Token -->
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />
						<h3>Theo dõi sự phát triển của bé</h3>
						<p>Nhận thư thông báo <strong>hàng tuần</strong> về quá trình phát triển của bé và sức khỏe của bạn trong thời kỳ mang thai.</p>
						<p style="overflow: hidden">
							<select name="ntype" class="form-control" id="newsletterType" style="width: 250px;">
								<option value="1">Tôi đang cố gắng thụ thai</option>
								<option value="2">Tôi đang đang mang thai</option>
								<option value="3">Con tôi đã chào đời</option>
							</select>
						</p>
						<div id="newsletterDate" style="display: none">
							<p><strong>Nhập ngày bắt đầu mang thai hoặc sinh nhật con bạn.</strong></p>
							<p style="overflow: hidden;">
								<span style="width: 70px; float: left; margin-right: 12px">
									<span style="font-size:11px;">Ngày</span><br />
									<span>
										<select class="form-control" name="day">
											@for($d = 1; $d <= 31; $d++ )
												<option> {{ $d }} </option>
											@endfor
										</select>
									</span>
								</span>
								<span style="width: 70px; float: left; margin-right: 12px">
									<span style="font-size:11px;">Tháng</span><br />
									<span>
										<select class="form-control" name="month">
											@for($m = 1; $m <= 12; $m++ )
												<option> {{ $m }} </option>
											@endfor
										</select>
									</span>
								</span>
								<span style="width: 90px; float: left">
									<span style="font-size:11px;">Năm</span><br />
									<span>
										<select class="form-control" name="year">
											@for($y = 2005; $y <= 2015; $y++ )
												<option {{ $y == 2013 ? 'selected="selected"' : '' }}> {{ $y }} </option>
											@endfor
										</select>
									</span>
								</span>
							</p>
						</div>
						<p style="overflow: hidden">
							<div class="checkbox">
								<label><input type="checkbox" name="other_news" value="1" checked="checked"> Nhận bản tin khác</label>
							</div>
						</p>
						@if(!Sentry::check())
							<p style="overflow: hidden">					
								<div class="form-group {{ $errors->has('email-newsletter') ? 'has-error' : '' }}" style="margin:0">
									<span style="font-size:11px;">Email của bạn:</span><br />
									<span>
										<input style="width: 250px;" class="form-control" name="email-newsletter" value="{{ Input::old('email-newsletter') }}" placeholder="địa chỉ email" />
									</span>
								</div>
							</p>
						@else
							<input type="hidden" name="email-newsletter" value="{{ Sentry::getUser()->email }}" />
						@endif
						<p style="overflow: hidden" align="left">
							<input type="submit" class="btn btn-info" name="submit" value="Nhận bản tin" />
						</p>
						<p style="overflow: hidden" align="left">
							Đang có <strong>6548</strong> người nhận bản tin tuần
						</p>
					</form>
				@endif
			</div>
		</div>
	</div>
	<div class="col-md-7">
		<div class="box-info">
			<div class="well p2">
				@if( !Sentry::check() )
					<h3>Đăng ký thành viên</h3>				
					<div class="">
						<p>
							Tham gia cộng đồng Vì Bé Yêu, để nhận được sự hỗ trợ tốt hơn từ những người có kinh nghiệm.
						</p>
						<form class="form-horizontal" role="form" method="post" action="{{ route('signup') }}" class="form-horizontal" autocomplete="off">
							<!-- CSRF Token -->
							<input type="hidden" name="_token" value="{{ csrf_token() }}" />
							<div class="form-group">
								<label for="first_name" class="col-lg-4 control-label{{ $errors->first('first_name', ' has-error') }}">Tên tài khoản</label>
								<div class="col-lg-6">
									<input type="text" class="form-control" name="first_name" id="first_name" value="{{ Input::old('first_name') }}" />
									{{ $errors->first('first_name', '<span class="help-block">:message</span>') }}
								</div>
							</div>
							<div class="form-group{{ $errors->first('email', ' has-error') }}">
								<label for="email" class="col-lg-4 control-label">Địa chỉ Email</label>
								<div class="col-lg-6">
									<input type="text" class="form-control" name="email" id="email" value="{{ Input::old('email') }}" />
									{{ $errors->first('email', '<span class="help-block">:message</span>') }}
								</div>
							</div>
							<div class="form-group{{ $errors->first('password', ' has-error') }}">
								<label for="password" class="col-lg-4 control-label">Mật khẩu</label>
								<div class="col-lg-6">
									<input type="password" class="form-control" name="password" id="password" value="" />
									{{ $errors->first('password', '<span class="help-block">:message</span>') }}
								</div>
							</div>
							<div class="form-group{{ $errors->first('password_confirm', ' has-error') }}">
								<label for="password_confirm" class="col-lg-4 control-label">Xác nhận mật khẩu</label>
								<div class="col-lg-6">
									<input type="password" class="form-control" name="password_confirm" id="password_confirm" value="" />
									{{ $errors->first('password_confirm', '<span class="help-block">:message</span>') }}
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-offset-4 col-lg-6">
									<button type="submit" class="btn btn-default">Đăng ký</button>
								</div>
							</div>
						</form>
					</div>
				@else
					<h3>Chào <strong>{{ Sentry::getUser()->first_name }}</strong></h3>				
					<div class="">
						<ul class="nav">
							@if(Sentry::getUser()->hasAccess('admin'))
								<li><a href="{{ route('admin') }}"><i class="icon-cog"></i> Quản trị</a></li>
							@endif
							<li{{ (Request::is('account/profile') ? ' class="active"' : '') }}><a href="{{ route('profile') }}"><i class="icon-user"></i> Thông tin cá nhân</a></li>
							<li class="divider"></li>
							<li><a href="{{ route('logout') }}"><i class="icon-off"></i> Thoát</a></li>
						</ul>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
@stop