@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
{{ $post->meta_title ? $post->meta_title : $post->title }} ::
@parent
@stop

{{-- Update the Meta Title --}}
@section('meta_title', $post->meta_title ? $post->meta_title : $post->title)
@section('meta_keywords', $post->meta_keywords.','.Config::get('settings.keywords'))
@section('meta_description', $post->meta_description ? $post->meta_description : $post->excerpt)
@section('meta_image', ($post->mname ? asset($post->mpath . '/550x500/'. $post->mname) : ''))

{{-- Page content --}}
@section('content')

	<div class="row mix_content">
		<!---------------------------------------------- left content-------------------------------------------------->
		<div class="col-md-8 left-content">
			<div class="row">
				<div class="col-md-7 contact">
					<div class="tab line_text2">
						<span class="tit_underline" style="margin-left:10px">{{ $parent_category->name }}</span>
					</div>
					<div class="top-content">
						<div class="news_detail">
							<div class="col-md-8 news_detail_text">
								<div class="item-news-bottom">
									<div class="news_detail_sub">
										<a href="#" class="tit3">{{ $post->title }}</a>
										<div class="col-md-8 ddmmyy">
											<span style="color:#999;">[{{ date("H:i - d/m/Y",strtotime($post->publish_date)) }}]</span>
										</div>
										<p class="news-content-excerpt"><strong>{{ $post->excerpt }}</strong></p>
										<p>{{ $post->content }}</p>
									</div>

									<div class="news_detail_sub" style="margin-top:20px;">
										<a href="#" class="tit3"><i>Bài viết khác</i></a>
										<ul style="margin:0; float:left; padding:5px;">
											@foreach ($category_posts as $key => $cp)
												<li class="link"><img src="{{ asset('assets/img/icon_text.png') }}" style="margin:5px;"><a href="{{ $cp->url() }}" title="{{ $cp->title }}" style="color:#666;">{{ $cp->title }}</a></li>
											@endforeach
											{{--<li class="link"><img src="{{ asset('assets/img/icon_text.png') }}" style="margin:5px;"><a href="#" style="color:#666;">Liên hiệp các tổ chức hữu nghị tỉnh Tuyên Quang làm việc với Liên hiệp các Tổ chức hữu nghị Việt Nam</a></li>--}}
											{{--<li class="link invisible-resp"><img src="{{ asset('assets/img/icon_text.png') }}" style="margin:5px;"><a href="#" style="color:#666;">Đoàn đại biểu Liên hiệp các Tổ chức hữu nghị tỉnh Tuyên Quang thăm và giao lưu hữu nghị tại nước CHDCND Lào</a></li>--}}
											{{--<li class="link invisible-resp"><img src="{{ asset('assets/img/icon_text.png') }}" style="margin:5px;"><a href="#" style="color:#666;">Đoàn đại biểu Liên hiệp các Tổ chức hữu nghị tỉnh Tuyên Quang thăm và giao lưu hữu nghị tại nước CHDCND Lào</a></li>--}}
											{{--<li class="link invisible-resp"><img src="{{ asset('assets/img/icon_text.png') }}" style="margin:5px;"><a href="#" style="color:#666;">Đoàn đại biểu Liên hiệp các Tổ chức hữu nghị tỉnh Tuyên Quang thăm và giao lưu hữu nghị tại nước CHDCND Lào</a></li>--}}
										</ul>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div><!--row-->
		</div>
		<!---------------------------------------------------end left------------------------------------------------------------->

		<div class="col-md-3 right-content">
			<div class="tintuc_div_right">
				<div class="tab line_text1a"><span class="tit_underline">Video về Tuyên Quang</span></div>
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
                    <li class="link_1"><img src="{{ asset('assets/img/77.png') }}" style="margin:5px;"><a href="{{route('lien-he')}}">Liên hệ</a></li>
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
					<div class="tab line_text2"><span class="tit_underline">Liên kết website</span></div>
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
<script type="text/javascript">

	BB.updateViewCount('{{ $currPostId }}');
	BB.commentList('vote');
</script>
@stop
