@extends('frontend/layouts/profile')

{{-- Page title --}}
@section('title')
Tin nhắn - Trang cá nhân
@endsection

{{-- Account page content --}}
@section('profile-content')
<div class="row">
	<div class="col-md-4">
		<div class="box-info">
			<div class="">
				<div>
					<h3 style="margin-left: 0px;">Tin nhắn</h3>
				</div>
				<div id="inner-conversations">
					<div class="list-group" style="overflow: hidden">
						@foreach ($conversations as $con)
							<a href="{{ URL::to('profile/messages/'.$con->c_id) }}" class="list-group-item {{ isset($cId) && $cId == $con->c_id ? 'active' : '' }}" style="overflow: hidden">
								<span style="display:block; width: 70px; float: left">{{ User::avatar($con->avatar, '60x60_crop', 60) }}</span>
							    <h5 class="list-group-item-heading">{{ $con->first_name }} {{ $con->last_name }}</h5>
							    <p class="list-group-item-text" style="font-size: 12px;">{{ date("H:i - d/m",strtotime($con->updated_at)) }}</p>
							</a>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="box-info">
			<div class="well">
				<div id="inner-messages">
					@if(isset($messages) && $messages->count())
						@foreach($messages as $msg)
							<dl class="dl-horizontal">
							  <dt>
							  	<a class="avatar_link" href="{{ URL::to('u/'.$msg->username) }}">
							  	{{ $msg->first_name }} {{ $msg->last_name }}
					      		{{ User::avatar($msg->avatar, '60x60_crop', 40) }}
								</a>
							  </dt>
							  <dd>
							  	{{ nl2br($msg->reply) }}
							  	<span class="pull-right" style="font-size: 11px; color:#999999">{{ date("H:i - d/m",strtotime($msg->created_at)) }}</span>
							  </dd>
							</dl>
						@endforeach
					@else
						<div align="center">Chọn 1 hội thoại bên trái.</div>
					@endif
				</div>
				@if(isset($messages) && $messages->count())
					<div style="border-top: 1px solid #eeeeee; " align="right">
					  	<form role="form" method="post" action="/profile/messages/compose" id="from-messages-compose" class="form-inline" role="form">
						  <!-- CSRF Token -->
						  <input type="hidden" name="_token" value="{{ csrf_token() }}" />
						  <input type="hidden" name="receipt_id" class="form-control" value="{{ $toUser  }}">

						  <div class="form-group">
						    <label for="content" class="col-sm-1 control-label"></label>
					   		<textarea name="content" style="width:400px;" class="form-control" placeholder="Viết trả lời"></textarea>
						  </div>
						  <div class="form-group">
						    <label for="submit" class="col-sm-1 control-label"></label>
							<input type="submit" class="btn btn-success btn-lg" name="submit" value="Gửi" />
						  </div>
						</form>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
	    $('#inner-messages').slimScroll({
	        height: '500px',
	        start: 'bottom',
	    });
	    $('#inner-conversations').slimScroll({
	        height: '560px'
	    });
	});
</script>
@stop