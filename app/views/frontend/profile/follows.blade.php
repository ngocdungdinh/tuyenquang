@extends('frontend/layouts/profile')

{{-- Page title --}}
@section('title')
{{ $profile->first_name }} {{ $profile->last_name }} - Trang cá nhân
@endsection

{{-- Update the Meta Description --}}
@section('meta_description')
{{ $profile->bio }}
@endsection

{{-- Account page content --}}
@section('profile-content')
<div class="row">
	<ol class="breadcrumb">
	  <li class="active">Trang cá nhân</li>
	  <li class="active">{{ $profile->first_name }} {{ $profile->last_name }}</li>
	</ol>
</div>

<div class="box-info">
	<div class="well bshadown">
		<div class="row">
			<div class="col-md-4">
				<br />
				<div class="box-info">
					<div class="well p2" style="border: none">
						<div align="center">
							<div class="row">
								<div class="col-md-5" style="padding-left: 0">
									<a class="avatar_link circle" href="{{ URL::to('/u/'.$profile->username) }}" title="{{ $profile->first_name }} {{ $profile->last_name }}">
									{{ User::avatar($profile->avatar, '100x100_crop', 100) }}</a>
								</div>
								<div class="col-md-7">
									<div style="text-align: left;">
										<div style="padding-bottom: 8px;"><a class="avatar_link circle" style="font-weight: bold; font-size: 13px;" href="{{ URL::to('/u/'.$profile->username) }}" title="{{ $profile->first_name }} {{ $profile->last_name }}">{{ $profile->first_name }} {{ $profile->last_name }}</a></div>
										<span>{{ $profile->gender=='male' ? 'Nam' : ($profile->gender=='female' ? 'Nữ' : '2fi') }}</span>
										<span>{{ ($profile->birth_year) ? ', '.(date("Y")-$profile->birth_year).' tuổi' : '' }}</span>
										@if($profile->fb_id)
										<br />
										<span><a target="_blank" href="{{$profile->fb_link}}"><img src="/assets/img/icons/ico_fb.png" /></a></span>
										@endif
										@if(!is_null($u) && $profile->id != $u->id)	
											<div>
												<a href="#" id="composeMessage" data-url="{{ URL::to('profile/messages/compose/'.$profile->id) }}">
													<span class="label label-info"><span class="glyphicon glyphicon-plus"></span> Gửi tin nhắn</span>
												</a>
											</div>
										@endif
									</div>
								</div>
							</div>
							@if($profile->bio)
								<hr />
								<span style="color:#666666; font-size: 16px;">{{ nl2br($profile->bio) }}</span>
							@endif
							<hr />

							<dl class="dl-horizontal user_info">
							  @if($profile->hometown)
							  <dt><span class="glyphicon glyphicon-home"></span> Quê quán</dt>
							  <dd>{{ $profile->hometown }}</dd>
							  @endif
							  @if($profile->location)
							  <dt><span class="glyphicon glyphicon-flag"></span> Nơi sống</dt>
							  <dd>{{ $profile->location }}</dd>
							  @endif
							  @if($profile->phone_cog==2 && $profile->phone)
							  <dt><span class="glyphicon glyphicon-earphone"></span> Điện thoại</dt>
							  <dd>{{ $profile->phone }}</dd>
							  @endif
							  @if($profile->website)
							  <dt><span class="glyphicon glyphicon-link"></span> Homepage</dt>
							  <dd><a href="{{ $profile->website }}">{{ $profile->website }}</a></dd>
							  @endif
							</dl>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-8" style="border-left: 1px solid #dddddd; min-height: 600px">
				@if(!is_null($u) && $profile->id == $u->id)
				<div>
					<div class="row">
					</div>
				</div>
				@endif
				<div>
					<div class="box-info">
						<div class="well p2" style="border: none">
							<ul class="nav nav-tabs bold">
							  <li><a href="{{ URL::to('/u/'.$profile->username) }}"><span class="glyphicon glyphicon-question-sign"></span> Hỏi đáp</a></li>
							  <li class="active"><a href="{{ URL::to('/u/'.$profile->username.'?p=follows') }}"><span class="glyphicon glyphicon-heart"></span> Bác sĩ yêu thích</a></li>
							</ul>
						</div>
					</div>
					<div class="box-info">
						<div class="well p2" style="border: none">
							<p align="center" style="padding-top: 20px;">- Chưa có dữ liệu -</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop