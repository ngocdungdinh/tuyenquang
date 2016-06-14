@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')

@parent
@stop

{{-- Page content --}}
@section('content')
	<div class="row">

		<link rel="stylesheet" href="{{ asset('assets/nivo-slider/themes/default/default.css') }}" type="text/css" media="screen" />
		<link rel="stylesheet" href="{{ asset('assets/nivo-slider/nivo-slider.css') }}" type="text/css" media="screen" />
		<div id="sitewide_banner">
			<div id="my_slider_content" class="mydata">
				<div class="slider-wrapper theme-default">
					<div id="slider" class="nivoSlider">
						<a href="javascript:;"><img src="{{ asset('assets/img/banner.png') }}" alt="Photo by: Missy S Link: http://www.flickr.com/photos/listenmissy/5087404401/"></a>
						<a href="javascript:;"><img src="{{ asset('assets/img/banner_2.jpg') }}" alt="Photo by: Daniel Parks Link: http://www.flickr.com/photos/parksdh/5227623068/"></a>
						<a href="javascript:;"><img src="{{ asset('assets/img/banner.png') }}" alt="Photo by: Mike Ranweiler Link: http://www.flickr.com/photos/27874907@N04/4833059991/"></a>
						<a href="javascript:;"><img src="{{ asset('assets/img/banner.png') }}" alt="Photo by: Stuart SeegerLink: http://www.flickr.com/photos/stuseeger/97577796/"></a>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="{{ asset('assets/nivo-slider/jquery.nivo.slider.js') }}"></script>
		<script type="text/javascript">
			$(window).load(function() {
				$('#sitewide_banner').html($('#my_slider_content').html());
				$('#my_slider_content').html('');
				$('#slider').nivoSlider({controlNav: false, pauseTime: 2000});
			});
		</script>

	</div>
	<div class="row mix_content">
		<!---------------------------------------------- left content-------------------------------------------------->
		<div class="col-md-9 left-content">
			<div class="row">
				<div class="col-md-12 tintuc_div">
					<div class="tab line_text1">
						<span class="tit_underline">GIỚI THIỆU TỈNH TUYÊN QUANG</span></div>
					<div class="button_next">
						<span style="float:left"><a href="#"><img src="{{ asset('assets/img/pre.png') }}"></a></span>
						<span style="float:left"><a href="#"><img src="{{ asset('assets/img/next.png') }}"></a></span>
					</div>
					<div class="col-md-12 tintuc_item inner-left">
						@foreach($intro as $key => $intro)
						<div class="col-md-4 thumnail ">
							<img class="img-resp" src="{{ asset($intro->mpath . '/235x178_crop/'. $intro->mname) }}"/>
							<div class="title"><a href="{{ $intro->url() }}" title="{{ $intro->title }}">{{ $intro->title }}</a></div>
						</div>
						@endforeach
					</div>
				</div>
			</div><!--tintuc_div-->
			<div style="margin-top:10px;"></div>
			<div class="row">
				<div class="col-md-5 tintuc_div_left">
					<div class="tt_item">
						<div class="tab line_text2">
							<p><span class="tit_underline">TIN TỨC & SỰ KIỆN</span></p>
							<p class="sub_tab">
								<span><a href="#">Tin trong tỉnh</a></span>
								<span> | </span>
								<span><a href="#">Tin trong nước</a></span>
								<span> | </span>
								<span><a href="#">Tin quốc tế</a></span>
							</p>
						</div>
						@if(count($newshome) > 0)
							@for ($i = 0; $i <= 1; $i++)
								<div class="tin01">
									<div class="tt_thumb2"><img class="tt_thumb" src="{{ asset($newshome[$i]->mpath . '/140x106_crop/'. $newshome[$i]->mname) }}" align="left"/></div>
									<div class="content2">
										<p><a href="{{ $newshome[$i]->url() }}" title="{{ $newshome[$i]->title }}">{{ $newshome[$i]->title }}<br/></a></p>
										<p class="date"><span >[{{ date("H:i - d/m/Y",strtotime($newshome[$i]->created_at)) }}]</span></p>
									</div>
								</div>
							@endfor
						@endif

						<ul style="margin:0; float:left; padding:5px;;">
							@if(count($newshome) > 0)
								@for ($i = 2; $i < count($newshome); $i++)
									<li class="link invisible-resp"><img src="{{ asset('assets/img/icon_text.png') }}" style="margin:5px;"><a href="{{ $newshome[$i]->url() }}" title="{{ $newshome[$i]->title }}" style="color:#666;">{{ $newshome[$i]->title }}</a></li>
								@endfor
							@endif
						</ul>
					</div>
				</div><!--tintuc_div-->

				<div class="col-md-5 tintuc_div_left2">
					<div class="tt_item">
						<div class="tab line_text2">
							<p><span class="tit_underline">LÃNH SỰ - VIỆT KIỀU</span></p>
							<p class="sub_tab">
								<span><a href="#">Lễ tân ngoại giao</a></span>
								<span> | </span>
								<span><a href="#">Thủ tục hành chính</a></span>
							</p>
						</div>
						@if(count($overseas) > 0)
							@for ($i = 0; $i <= 1; $i++)
								<div class="tin01">
									<div class="tt_thumb2"><img class="tt_thumb" src="{{ asset($overseas[$i]->mpath . '/140x106_crop/'. $overseas[$i]->mname) }}" align="left"/></div>
									<div class="content2">
										<p><a href="{{ $overseas[$i]->url() }}" title="{{ $overseas[$i]->title }}">{{ $overseas[$i]->title }}<br/></a></p>
										<p class="date"><span >[{{ date("d/m/Y",strtotime($overseas[$i]->created_at)) }}]</span></p>
									</div>
								</div>
							@endfor
						@endif
						<ul style="margin:0; float:left; padding:5px;;">
							@if(count($overseas) > 0)
								@for ($i = 2; $i < count($overseas); $i++)
									<li class="link invisible-resp"><img src="{{ asset('assets/img/icon_text.png') }}" style="margin:5px;"><a href="{{ $overseas[$i]->url() }}" title="{{ $overseas[$i]->title }}" style="color:#666;">{{ $overseas[$i]->title }}</a></li>
								@endfor
							@endif
						</ul>
					</div>
				</div><!--tintuc_div-->
			</div>

			<div class="row">
				<div class="col-md-10 tintuc_div">
					<div class="tt_item">
						<div class="tab line_text2">
							<p><span class="tit_underline">hợp tác quốc tế</span></p>
							<p class="sub_tab">
								<span><a href="#">Quan hệ với các nước</a></span>
								<span> | </span>
								<span><a href="#">Quan hệ với tổ chức quốc tế</a></span>
								<span> | </span>
								<span><a href="#">Cơ chế chính sách</a></span>
							</p>
						</div>
						@if(count($overseas) > 0)
						<?php
						$topInt = $international->first();
						?>
						<div class="tin1" style="padding:0;">
							<div class="col-md-3 tt_thumb2"><img src="{{ asset($topInt->mpath . '/235x178_crop/'. $topInt->mname) }}"/></span></div>
							<div class="col-md-8 content" style="margin-left:45px;">
								<a class="title_left" href="{{ $topInt->url() }}" title="{{ $topInt->title }}">{{ $topInt->title }}</a>
								<span>{{$topInt->excerpt}}</span>
							</div>
						</div><!--tin--->
						@endif
					</div>
					<ul style="margin:0; float:left; padding:5px;">
						@foreach($international as $key => $int)
							@if($key > 0)
								<li class="link invisible-resp"><img src="{{ asset('assets/img/icon_text.png') }}" style="margin:5px;"><a href="{{$int->url()}}" title="{{$int->title}}" style="color:#666;">{{$int->title}}</a></li>
							@endif
						@endforeach
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-md-10 tintuc_div">
					<div class="tab line_text1">
						<span class="tit_underline">thư viện hình ảnh</span>
					</div>
					<div class="button_next">
						<span style="float:left"><a href="#"><img src="{{ asset('assets/img/pre.png') }}"></a></span>
						<span style="float:left"><a href="#"><img src="{{ asset('assets/img/next.png') }}"></a></span>
					</div>
					<div class="tintuc_item inner-left">
						<div class="col-md-2 thumnail2 "><img class="img-resp" src="{{ asset('assets/img/thumb4.png') }}"/></div>
						<div class="col-md-2 thumnail2 "><img class="img-resp" src="{{ asset('assets/img/thumb4_1.png') }}"/></div>
						<div class="col-md-2 thumnail2 "><img class="img-resp" src="{{ asset('assets/img/thumb4_2.png') }}"/></div>
						<div class="col-md-2 thumnail2 "><img class="img-resp" src="{{ asset('assets/img/thumb4_1.png') }}"/></div>
						<div class="col-md-2 thumnail2 "><img class="img-resp" src="{{ asset('assets/img/thumb4_2.png') }}"/></div>
						<div class="col-md-2 thumnail2 "><img class="img-resp" src="{{ asset('assets/img/thumb4.png') }}"/></div>
					</div>
				</div>
			</div><!--tintuc_div-->
			<div class="row" style="margin-top:10px;">
				<div class="col-md-5 tintuc_div_left">
					<div class="tt_item">
						<div class="tab line_text2"><span class="tit_underline">dự án fngo</span></div>
						@if(count($fngo) > 0)
							@foreach($fngo as $key => $fngo)
							<img class="tt_thumb" src="{{ asset($fngo->mpath . '/140x106_crop/'. $fngo->mname) }}" align="left"/>
							<a href="{{$fngo->url()}}" title="{{$fngo->title}}">{{$fngo->title}}<br/>
								<span style="color:#999999;">{{ date("d/m/Y",strtotime($fngo->created_at)) }}</span>
							</a>
							@endforeach
						@endif
					</div>
				</div><!--tintuc_div-->
				<div class="col-md-5 tintuc_div_left2">
					<div class="tt_item">
						<div class="tab line_text2"><span class="tit_underline">dự án FDI</span></div>

						@if(count($fdi) > 0)
							@foreach($fdi as $key => $fdi)
								<img class="tt_thumb" src="{{ asset($fdi->mpath . '/140x106_crop/'. $fdi->mname) }}" align="left"/>
								<a href="{{$fdi->url()}}" title="{{$fdi->title}}">{{$fdi->title}}<br/>
									<span style="color:#999999;">{{ date("d/m/Y",strtotime($fdi->created_at)) }}</span>
								</a>
							@endforeach
						@endif


					</div>
				</div><!--tintuc_div-->
			</div>
		</div>
		<!---------------------------------------------------end left------------------------------------------------------------->

		<div class="col-md-3 right-content">
			<div class="tintuc_div_right">
				<div class="tab line_text1a"><span class="tit_underline">VIDEO VỀ TUYÊN QUANG</span></div>
				<div class="clip"><iframe width="560" height="315" src="https://www.youtube.com/embed/mVPnavjyVGg" frameborder="0" allowfullscreen></iframe></div>
				<div class="clip_ul">
					<li><a href="#" style="color:#666;">Giới thiệu về Tuyên Quang</a></li>
					<li><a href="#" style="color:#666;">Nét đẹp lễ hội văn hoá Tuyên Quang</a></li>
					<li><a href="#" style="color:#666;">Lễ hội Thanh Tuyên</a></li>
				</div>
			</div>

			<div class="list_right2">
				<ul style="margin:0; float:left; padding:5px;">
					@foreach($sidebarcate as $sidemenu)
						@if($sidemenu->parent_id == 0)
						<li class="link invisible-resp"><img src="{{ asset('assets/img/77.png') }}" style="margin:5px;"/><a href="{{ route('view-category', $sidemenu->slug) }}">{{ $sidemenu->name }}</a></li>
						@endif
					@endforeach
					<li class="link invisible-resp"><img src="{{ asset('assets/img/77.png') }}" style="margin:5px;"><a href="#">Liên kết web</a></li>
					<li class="link invisible-resp"><img src="{{ asset('assets/img/77.png') }}" style="margin:5px;"><a href="#">Thư viện ảnh</a></li>
					<li class="link_1"><img src="{{ asset('assets/img/77.png') }}" style="margin:5px;"><a href="#">Liên hệ</a></li>
				</ul>
			</div>

			<div class="tintuc_div_right">
				<div class="tt_item">
					<div class="tab line_text2"><span class="tit_underline">Bài viết nổi bật</span></div>

					@foreach ($featured_posts as $featured)
                        <img class="tt_thumb" src="{{ asset($featured->mpath . '/100x76_crop/'. $featured->mname) }}" alt="{{ $featured->title }}" align="left"/>
                        <a href="{{ $featured->url() }}" title="{{ $featured->title }}" style="text-align:18px;">{{ $featured->title }}</br>
                            <span style="color:#999999;">[{{ date("d/m/Y",strtotime($featured->created_at)) }}]</span>
                        </a>
					@endforeach

				</div>
			</div>
			<div class="tintuc_div_right">
				<div class="tt_item">
					<div class="tab line_text2"><span class="tit_underline">LIÊN KẾT WEBSITE</span></div>
					<div class="tt_item2">
						<img src="{{ asset('assets/img/thumbr.png') }}" />
						<img src="{{ asset('assets/img/r2.png') }}" />
						<img src="{{ asset('assets/img/r3.png') }}" />
						<img src="{{ asset('assets/img/r4.png') }}" />
						<img src="{{ asset('assets/img/r5.png') }}" />
						<img src="{{ asset('assets/img/r6.png') }}" />
					</div>
				</div>
			</div>
			<!--
             <div class="col-md-4 tintuc_div_right">
                 Ho tro truc tuyen
             </div> -->
		</div><!---end right-content---->

	</div>
@stop