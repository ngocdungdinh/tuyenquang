<div class="tintuc_div_right">
    <div class="tab line_text1a"><span class="tit_underline">VIDEO VỀ TUYÊN QUANG</span></div>
    <div class="clip"><iframe width="560" height="315" src="https://www.youtube.com/embed/RwWQ6aDxl2A" frameborder="0" allowfullscreen></iframe></div>
</div>

<div class="list_right2">
    <ul style="margin:0; float:left; padding:5px;">
        @foreach($sidebarcate as $sidemenu)
            @if($sidemenu->parent_id == 0)
                <li class="link invisible-resp"><img src="{{ asset('assets/img/77.png') }}" style="margin:5px;"/><a href="{{ route('view-category', $sidemenu->slug) }}">{{ $sidemenu->name }}</a></li>
            @endif
        @endforeach
        <li class="link invisible-resp"><img src="{{ asset('assets/img/77.png') }}" style="margin:5px;"><a href="{{ route('web-link') }}">Liên kết web</a></li>
        <li class="link invisible-resp"><img src="{{ asset('assets/img/77.png') }}" style="margin:5px;"><a href="{{ route('image-gallery') }}">Thư viện ảnh</a></li>
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
            <a href="http://ipc.tuyenquang.gov.vn/" target="_blank">
                <img src="{{ asset('assets/img/thumbr.png') }}" />
            </a>
            <a href="http://www.baotuyenquang.com.vn/" target="_blank">
                <img src="{{ asset('assets/img/r2.png') }}" />
            </a>
            <a href="http://congbao.tuyenquang.gov.vn/" target="_blank">
                <img src="{{ asset('assets/img/r3.png') }}" />
            </a>
            <a href="http://www.mofa.gov.vn/" target="_blank">
                <img src="{{ asset('assets/img/r4.png') }}" />
            </a>
            <a href="http://www.tuyenquang.gov.vn/" target="_blank">
                <img src="{{ asset('assets/img/r5.png') }}" />
            </a>
            <a href="http://www.chinhphu.vn/" target="_blank">
                <img src="{{ asset('assets/img/r6.png') }}" />
            </a>
        </div>
    </div>
</div>
