@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
{{ $category->name }} ::
@parent
@stop

{{-- Page content --}}
@section('content')
	<div class="row mix_content">
		<!---------------------------------------------- left content-------------------------------------------------->
		<div class="col-md-8 left-content">
			<div class="row">
				<div class="col-md-10 tintuc_div">
					<div class="tt_item">
						<div class="tab line_text2">
							<p><span class="tit_underline">{{ strtoupper($category->name) }}</span></p>
							<p class="sub_tab">
								@foreach($subcate as $submenu)
									<span><a href="{{ route('view-category', $submenu->slug) }}">{{ $submenu->name }}</a></span>
									<span> | </span>
								@endforeach
							</p>
						</div>
						<!--
                        <div class="tin1">
							<div class="col-md-4 tt_thumb2"><img src="{{ asset('assets/img/thumb3.png') }}"/></span></div>
							<div class="col-md-8 content">
								<a class="title_left" href="#">Năm học 2015-2016 triển khai ứng dụng phần mềm quản lý học sinh vnEdu cho tất cả các cấp học.<br/>
									<span style="color:#999999;">[17/03/2016]</span>
								</a>
								<span>triển khai ứng dụng phần mềm quản lý học sinh</span>
                            </div>
                        </div>
                        -->
                        @foreach ($posts as $key => $post)
                        <div class="tin">
							<div class="col-md-4 tt_thumb2"><span><img src="{{ asset($post->mpath . '/235x178_crop/'. $post->mname) }}"/></span></div>
							<div class="col-md-8 content">
								<a class="title_left" href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }}<br/>
									<span style="color:#999999;">[17/03/2016]</span>
								</a>
								<span>{{ Str::words($post->excerpt, 24) }}</span>
							</div>
						</div>
                        @endforeach
					</div>

				</div>
                <div class="paging">
                    {{ $posts->links() }}
                </div>
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
