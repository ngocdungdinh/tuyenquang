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
						<div class="col-md-4 thumnail ">
							<img class="img-resp" src="{{ asset('assets/img/p1.png') }}"/>
							<div class="title"><a href="#">Các lễ hội đặc sắc ở Tuyên Quang</a></div>
						</div>
						<div class="col-md-4 thumnail ">
							<img class="img-resp" src="{{ asset('assets/img/thumb1.png') }}"/>
							<div class="title"><a href="#">Điểm du lịch Na Hang giữa thác và núi </a></div>
						</div>
						<div class="col-md-4 thumnail ">
							<img class="img-resp" src="{{ asset('assets/img/thumb1.png') }}"/>
							<div class="title"><a href="#">Điểm du lịch Na Hang giữa thác và núi </a></div>
						</div>
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
						<div class="tin01">
							<div class="tt_thumb2"><img class="tt_thumb" src="{{ asset('assets/img/thumb2.png') }}" align="left"/></div>
							<div class="content2">
								<p><a href="#">Sở ngoại vụ tổ chức hội nghị tổng kết công tác năm 2015 triển khai nhiệm vụ năm 2016<br/></a></p>
								<p class="date"><span >[17/03/2016]</span></p>
							</div>
						</div>
						<div class="tin01">
							<div class="tt_thumb2"><img class="tt_thumb" src="{{ asset('assets/img/thumb2.png') }}" align="left"/></div>
							<div class="content2">
								<p><a href="#">Sở ngoại vụ tổ chức hội nghị tổng kết công tác năm 2015 triển khai nhiệm vụ năm 2016<br/></a></p>
								<p class="date"><span >[17/03/2016]</span></p>
							</div>
						</div>

						<ul style="margin:0; float:left; padding:5px;;">
							<li class="link"><img src="{{ asset('assets/img/icon_text.png') }}" style="margin:5px;"><a href="#" style="color:#666;">Lễ kỉ niệm 40 năm quốc khánh CHDCNN Lào</a></li>
							<li class="link invisible-resp"><img src="{{ asset('assets/img/icon_text.png') }}" style="margin:5px;"><a href="#" style="color:#666;">Chào mừng thành công Đại hội đại biểu Đảng bộ tỉnh.</a></li>
							<li class="link invisible-resp"><img src="{{ asset('assets/img/icon_text.png') }}" style="margin:5px;"><a href="#" style="color:#666;">Trường Đại học Tân Trào tiếp nhận học sinh Lào</a></li>
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
						<div class="tin01">
							<div class="tt_thumb2"><img class="tt_thumb" src="{{ asset('assets/img/thumb2.png') }}" align="left"/></div>
							<div class="content2">
								<p><a href="#">Sở ngoại vụ tổ chức hội nghị tổng kết công tác năm 2015 triển khai nhiệm vụ năm 2016<br/></a></p>
								<p class="date"><span >[17/03/2016]</span></p>
							</div>
						</div>
						<div class="tin01">
							<div class="tt_thumb2"><img class="tt_thumb" src="{{ asset('assets/img/thumb2.png') }}" align="left"/></div>
							<div class="content2">
								<p><a href="#">Sở ngoại vụ tổ chức hội nghị tổng kết công tác năm 2015 triển khai nhiệm vụ năm 2016<br/></a></p>
								<p class="date"><span >[17/03/2016]</span></p>
							</div>
						</div>
						<ul style="margin:0; float:left; padding:5px;;">
							<li class="link"><img src="{{ asset('assets/img/icon_text.png') }}" style="margin:5px;"><a href="#" style="color:#666;">Lễ kỉ niệm 40 năm quốc khánh CHDCNN Lào</a></li>
							<li class="link invisible-resp"><img src="{{ asset('assets/img/icon_text.png') }}" style="margin:5px;"><a href="#" style="color:#666;">Chào mừng thành công Đại hội đại biểu Đảng bộ tỉnh.</a></li>
							<li class="link invisible-resp"><img src="{{ asset('assets/img/icon_text.png') }}" style="margin:5px;"><a href="#" style="color:#666;">Trường Đại học Tân Trào tiếp nhận học sinh Lào</a></li>
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
						<div class="tin1" style="padding:0;">
							<div class="col-md-3 tt_thumb2"><img src="{{ asset('assets/img/thumb3.png') }}"/></span></div>
							<div class="col-md-8 content" style="margin-left:45px;">
								<a class="title_left" href="#">Năm học 2015-2016 triển khai ứng dụng phần mềm quản lý học sinh vnEdu cho tất cả các cấp học.</a>
								<span>Mối quan hệ hợp tác hữu nghị giữa tỉnh Tuyên Quang và tỉnh Xiêng Khoảng được bắt nguồn nhân chuyến thăm và làm việc của đoàn đại biểu tỉnh Xiêng Khoảng nước Cộng hòa dân chủ nhân dân Lào do đồng chí U-thên Ma Sý Xôn Xay, Phó bí thư Tỉnh ủy, Trưởng Ban Tổ chức tỉnh Xiêng Khoảng làm Trưởng đoàn, đã đến thăm và làm việc tại tỉnh Tuyên Quang từ ngày 11 – 14/3/2012</span>
							</div>
						</div><!--tin--->
					</div>
					<ul style="margin:0; float:left; padding:5px;;">
						<li class="link"><img src="{{ asset('assets/img/icon_text.png') }}" style="margin:5px;"><a href="#" style="color:#666;">Lễ kỉ niệm 40 năm quốc khánh CHDCNN Lào</a></li>
						<li class="link invisible-resp"><img src="{{ asset('assets/img/icon_text.png') }}" style="margin:5px;"><a href="#" style="color:#666;">Chào mừng thành công Đại hội đại biểu Đảng bộ tỉnh Tuyên Quang </a></li>
						<li class="link invisible-resp"><img src="{{ asset('assets/img/icon_text.png') }}" style="margin:5px;"><a href="#" style="color:#666;">Chào mừng thành công Đại hội đại biểu Đảng bộ tỉnh Tuyên Quang </a></li>
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
						<img class="tt_thumb" src="{{ asset('assets/img/thumb2.png') }}" align="left"/>
						<a href="#">Đoàn công tác Vụ Hợp tác quốc tế – Bộ Y tế đến thăm và làm việc<br/>
							<span style="color:#999999;">[17/07/2015]</span>
						</a>
						<img class="tt_thumb" src="{{ asset('assets/img/thumb2.png') }}" align="left"/>
						<a href="#">Đoàn công tác Vụ Hợp tác quốc tế – Bộ Y tế đến thăm và làm việc<br/>
							<span style="color:#999999;">[27/05/2015]</span>
						</a>
						<img class="tt_thumb" src="{{ asset('assets/img/thumb2.png') }}" align="left"/>
						<a href="#">Đoàn công tác Vụ Hợp tác quốc tế – Bộ Y tế đến thăm và làm việc<br/>
							<span style="color:#999999;">[27/05/2015]</span>
						</a>

					</div>
				</div><!--tintuc_div-->
				<div class="col-md-5 tintuc_div_left2">
					<div class="tt_item">
						<div class="tab line_text2"><span class="tit_underline">dự án FDI</span></div>
						<img class="tt_thumb" src="{{ asset('assets/img/thumb2.png') }}" align="left"/>
						<a href="#">Đoàn công tác Vụ Hợp tác quốc tế – Bộ Y tế đến thăm và làm việc<br/>
							<span style="color:#999999;">[17/07/2015]</span>
						</a>
						<img class="tt_thumb" src="{{ asset('assets/img/thumb2.png') }}" align="left"/>
						<a href="#">Đoàn công tác Vụ Hợp tác quốc tế – Bộ Y tế đến thăm và làm việc<br/>
							<span style="color:#999999;">[27/05/2015]</span>
						</a>
						<img class="tt_thumb" src="{{ asset('assets/img/thumb2.png') }}" align="left"/>
						<a href="#">Đoàn công tác Vụ Hợp tác quốc tế – Bộ Y tế đến thăm và làm việc<br/>
							<span style="color:#999999;">[27/05/2015]</span>
						</a>

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
					<li class="link"><img src="{{ asset('assets/img/77.png') }}" style="margin:5px;"/><a href="#">Giới thiệu tỉnh Tuyên Quang</a></li>
					<li class="link invisible-resp"><img src="{{ asset('assets/img/77.png') }}" style="margin:5px;"/><a href="#">Giới thiệu Sở Ngoại vụ</a></li>
					<li class="link invisible-resp"><img src="{{ asset('assets/img/77.png') }}" style="margin:5px;"/><a href="#">Văn bản pháp quy</a></li>
					<li class="link invisible-resp"><img src="{{ asset('assets/img/77.png') }}" style="margin:5px;"/><a href="#">Thông tin đối ngoại</a></li>
					<li class="link invisible-resp"><img src="{{ asset('assets/img/77.png') }}" style="margin:5px;"/><a href="#">Thông tin đoàn</a></li>
					<li class="link invisible-resp"><img src="{{ asset('assets/img/77.png') }}" style="margin:5px;"><a href="#">Liên kết web</a></li>
					<li class="link invisible-resp"><img src="{{ asset('assets/img/77.png') }}" style="margin:5px;"><a href="#">Thư viện ảnh</a></li>
					<li class="link_1"><img src="{{ asset('assets/img/77.png') }}" style="margin:5px;"><a href="#">Liên hệ</a></li>
				</ul>
			</div>

			<div class="tintuc_div_right">
				<div class="tt_item">
					<div class="tab line_text2"><span class="tit_underline">người tuyên quang ở nước ngoài</span></div>
					<img class="tt_thumb" src="{{ asset('assets/img/thumb5.png') }}" align="left"/>
					<a href="#" style="text-align:18px;">Việt Nam tham dự Hội nghị Diễn đàn...</br>
						<span style="color:#999999;">[17/07/2015]</span>
					</a>
					<img class="tt_thumb" src="{{ asset('assets/img/thumb5.png') }}" align="left"/>
					<a href="#" style="text-align:18px;">Việt Nam tham dự Hội nghị Diễn đàn...</br>
						<span style="color:#999999;">[17/07/2015]</span>
					</a>
					<img class="tt_thumb" src="{{ asset('assets/img/thumb5.png') }}" align="left"/>
					<a href="#" style="text-align:18px;">Việt Nam tham dự Hội nghị Diễn đàn...</br>
						<span style="color:#999999;">[17/07/2015]</span>
					</a>
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