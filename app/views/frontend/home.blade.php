@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')

@parent
@stop

{{-- Page content --}}
@section('content')
<div class="row">
	<div class="col-sm-12 col-md-8 col-home-left">
		<div class="row">
			<div class="col-sm-4 col-md-4 p10 hidden-xs">
				<ul class="nav nav-tabs nav-justified top-home-nav">
					<li class="active"><a href="#hot" data-toggle="tab">NÓNG</a></li>
					<li><a href="#new" data-toggle="tab">MỚI</a></li>
				</ul>
				<div class="tab-content" style="max-height: 629px; overflow: hidden">
					<div class="tab-pane active" id="hot">
						@foreach ($featured_posts as $key => $post)
							@if($key >= 4 & $key < 5)
								<div class="news-item">
									<a href="{{ $post->url() }}" title="{{ $post->title }}">
									@if($post->mtype == 'video')
										<span class="video-thumb">
											<img class="img-responsive full-width" src="{{ asset('http://i.ytimg.com/vi/'. $post->mname.'/0.jpg') }}" />
											<span class="play-icon small"><i class="ion-play"></i></span>
										</span>
									@elseif($post->mtype == 'image')
										<img src="{{ asset($post->mpath . '/320x210_crop/'. $post->mname) }}" width="100%" />
									@endif</a>
									<h5 class="link-title"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} @include('frontend/news/frags/status')</a></h5>
								</div>
							@elseif($key >= 5)
								<div class="news-item">
									<h6 class="link-title"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} @include('frontend/news/frags/status')</a></h6>
								</div>
							@endif
						@endforeach
					</div>
					<div class="tab-pane" id="new">
						@foreach ($lastest_posts as $key => $post)
							<div class="news-item">
								<h6 class="link-title"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} @include('frontend/news/frags/status')</a></h6>
							</div>
						@endforeach
					</div>
				</div>
			</div>
			<div class="col-sm-8 col-md-8">
				<div class="row">
					@foreach ($featured_posts as $key => $post)
						@if($key < 1)
							<div class="home-featured-post col-xs-12 p7">
								<a href="{{ $post->url() }}" title="{{ $post->title }}"><img alt="{{ $post->title }}" src="{{ asset($post->mpath . '/500x300_crop/'. $post->mname) }}" width="100%" /></a>
								<h4 class=""><a href="{{ $post->url() }}" class="link-red" title="{{ $post->title }}" style="font-size: 20px; line-height: 25px;">{{ $post->title }} @include('frontend/news/frags/status')</a></h4>
								<p style="margin-bottom: 3px;">{{ Str::words($post->excerpt, 50) }}</p>
								@if($post->relate_posts)
									@foreach($post->relates() as $pr)
										<p class="relate-post"><a href="{{ $pr->url() }}">{{ $pr->title }}</a></p>
									@endforeach
								@endif
							</div>
						@elseif($key>=1 && $key< 4)
							<div class="col-sm-6 col-lg-4 col-xs-6 p7 {{ $key == 3 ? ' hidden-xs hidden-sm hidden-md' : '' }}">
								<a href="{{ $post->url() }}" title="{{ $post->title }}">
									@if($post->mtype == 'video')
										<span class="video-thumb">
											<img class="img-responsive full-width" src="{{ asset('http://i.ytimg.com/vi/'. $post->mname.'/0.jpg') }}" />
											<span class="play-icon small"><i class="ion-play"></i></span>
										</span>
									@elseif($post->mtype == 'image')
										<img src="{{ asset($post->mpath . '/320x210_crop/'. $post->mname) }}" width="100%" />
									@endif</a>
								<h5 class="link-title"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} @include('frontend/news/frags/status')</a></h5>
							</div>
						@endif
					@endforeach
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4 col-home-right hidden-sm">
		<div class="row ">
			<div class="col-sm-12">
				<div class="ads-space hidden-xs">
					<a href="http://www.vuoncaovietnam.com/" target="_blank">			
						<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" border="0" width="300" height="250"><param name="movie" value="/assets/img/bnr/vinamilk-300x250.swf"><param name="AllowScriptAccess" value="always"><param name="quality" value="High"><param name="wmode" value="transparent">
						<param name="FlashVars" value="link=http://www.vuoncaovietnam.com/">
						<embed src="/assets/img/bnr/vinamilk-300x250.swf" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" play="true" loop="true" wmode="transparent" allowscriptaccess="always" width="300" height="250" flashvars="link=http://www.vuoncaovietnam.com/"></object>
						<i style="  display: block;  height: 240px;  width: 300px;  position: relative;  z-index: 9;  margin-top: -250px;"></i>
					</a>
				</div>
				<div class="ads-space hidden-xs">
					<a href="http://uvpharco.com.vn" target="_blank"><img class="hidden-sm" src="/assets/img/bnr/vietuc.jpg" width="100%" border="0"></a>
				</div>
				<div class="box-info" style="margin-top: 2px;">
					<div style="padding: 5px 0; height: 82px; overflow: hidden">
						<div style="font-size: 12px; padding: 3px 10px; background-color: #f1f1f1;">Nhận bản tin pháp luật qua MXH</div>
						<div class="fb-like-box" data-href="{{ Config::get('app.socialapp.facebook.url') }}" data-width="285" data-height="60" data-show-faces="false" data-header="false" data-stream="false" data-show-border="false"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div style="padding: 10px; background-color: #eeeeee; margin: 15px 0 10px 0;">
	<div class="row">
		<div class="col-sm-6 hidden">
			<a href="http://www.hongsamhanquoc.org" target="_blank"><img src="/assets/img/hongsam.png" class="img-responsive" /></a>
		</div>
		<div class="col-sm-12">
			<div class="row">				
				<div class="col-sm-12">					
					<img class="hidden-sm" src="/assets/img/baucuquochoi.png" width="100%" border="0">
				</div>
			</div>
		</div>
	</div>
</div>
<hr class="visible-xs" />
<div class="row">
	<div class="col-sm-8">	
		<div class="row">
			<div class="col-sm-8">
				{{ $currentCat->widgets('home-left-0') }}
			</div>
			<div class="col-sm-4">
				{{ $currentCat->widgets('home-left-1') }}
			</div>
		</div>
	</div>
	<div class="col-sm-4">
		{{ $currentCat->widgets('home-right-0') }}
	</div>
</div>
<hr />
<div class="row">
	<div class="col-sm-6">
		<div class="box-info list-popular-news row">
			<h3 style="text-transform: uppercase; border-bottom: 1px solid #cccccc; padding: 0px; margin: 0px 8px; font-size: 17px; font-weight: bold;"><span style="display: inline-block; padding: 8px 8px 4px; background-color: #eeeeee; color: #aa1801">Tin mới nhận</span></h3>
			@foreach ($popular_posts as $key => $post)
				<div class="col-xs-6 col-sm-12">
					<div class="list-news-item row">
						<div class="col-sm-5 col-md-4 p7">
							<a href="{{ $post->url() }}" title="{{ $post->title }}">
								@if($post->mtype == 'video')
									<span class="video-thumb">
										<img class="img-responsive full-width" src="{{ asset('http://i.ytimg.com/vi/'. $post->mname.'/0.jpg') }}" />
										<span class="play-icon small"><i class="ion-play"></i></span>
									</span>
								@elseif($post->mtype == 'image')
									<img class="img-responsive full-width" src="{{ asset($post->mpath . '/200x130_crop/'. $post->mname) }}" />
								@endif
							</a>
						</div>
						<div class="col-sm-7 col-md-8 p7">
							<h5 class="link-title"><a href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }} @include('frontend/news/frags/status')</a></h5>
							<p class="p-desc hidden-xs">{{ Str::words($post->excerpt, 32) }}</p>
							<!--  -->
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
	<div class="col-sm-6">
		<div>
			{{ $currentCat->widgets('home-right-1') }}
		</div>
	</div>
</div>
<div style="padding: 10px; background-color: #eeeeee; margin-bottom: 15px; text-align: center; overflow: hidden" class="hidden">
	<div>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- du-2 -->
		<ins class="adsbygoogle"
		     style="display:block"
		     data-ad-client="ca-pub-5128894772635532"
		     data-ad-slot="8535970001"
		     data-ad-format="auto"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">	
		{{ $currentCat->widgets('home-left-2') }}
	</div>
	<div class="col-sm-6">
		<div class="row">
			<div class="col-sm-8 p7">
				{{ $currentCat->widgets('home-right-2') }}
			</div>
			<div class="col-sm-4 p7 hidden-xs" style="overflow: hidden">
				<div class="ads-space">					
					<a href="http://www.sotuphaphanoi.gov.vn" target="_blank"><img src="/assets/img/bnr/qcsotuphaphn.gif" width="100%" border="0"></a>
				</div>
				<div class="ads-space hidden">		
					<a href="http://meg.com.vn/meg/index.jsp" target="_blank">			
					<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" border="0" width="165" height="300"><param name="movie" value="/assets/img/bnr/vinaphone3_Roaming_300x600.swf"><param name="AllowScriptAccess" value="always"><param name="quality" value="High"><param name="wmode" value="transparent">
					<param name="FlashVars" value="link=http://www.vinaphone.com.vn/">
					<embed src="/assets/img/bnr/vinaphone3_Roaming_300x600.swf" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" play="true" loop="true" wmode="transparent" allowscriptaccess="always" width="165" height="300" flashvars="link=http://www.vinaphone.com.vn/"></object>
					<i style="display:block; height: 305px; width: 165px;  position: relative; z-index: 9; margin-top: -334px;"></i>
					</a>
				</div>
				<div class="ads-space">					
					<a href="http://www.tuvanvinhomes.com" target="_blank"><img src="/assets/img/bnr/vinhomes.jpg?v=2" border="0" width="100%"></a>
				</div>
				<div class="sidestick-container">
					<div class="box-stitle" style="margin-top: 10px; margin-bottom: 0">CHUYÊN ĐỀ NÓNG</div>
					<div style="padding: 10px; background-color: #eeeeee">
						@foreach($featured_tags as $ht)
							<a href="/tags/{{ $ht->slug }}"><img class="img-responsive full-width" src="{{ asset($ht->mpath . '/200x130_crop/'. $ht->mname) }}" /></a>
							<a href="/tags/{{ $ht->slug }}" style="color: #000000; display: block; padding: 7px 0 14px 0">{{ $ht->name }}</a>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop