@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
    Thư viện ảnh ::
    @parent
@stop

{{-- Update the Meta Title --}}
@section('meta_title')

    @parent
@stop

{{-- Update the Meta Description --}}
@section('meta_description')

    @parent
@stop

{{-- Update the Meta Keywords --}}
@section('meta_keywords')

    @parent
@stop

{{-- Page content --}}
@section('content')
    <div class="row mix_content">
        <!---------------------------------------------- left content-------------------------------------------------->
        <div class="col-md-9 left-content">
            <div class="row">
                <div class="contact" >
                    <div class="tab line_text2">
                        <span class="tit_underline" style="margin-left:10px">HÌNH ẢNH TRUYỀN THÔNG</span>
                    </div>
                    <div class="top-content gallery">
                    @foreach($posts as $key => $post)
                        <div class="col-md-4 item1">
                            <a href="#"><div class="it_img ">
                                    <img src="{{ asset($post->mpath . '/220x170_crop/'. $post->mname) }}" data-big-src='{{ asset($post->mpath . '/'. $post->mname) }}'/>
                                    <p>{{$post->excerpt}}</p>
                                </div></a>
                            <div class="caption"></div>
                        </div>
                    @endforeach
                    </div>	<!--top content-->
                </div>
            </div><!--row-->
        </div>
        <!---------------------------------------------------end left------------------------------------------------------------->

        <div class="col-md-3 right-content">
            @include('frontend/partials/right-content')
        </div><!---end right-content---->

    </div>
    <!--view anh-->
    <script type='text/javascript'>
        //init Gallery
        $('.gallery').easyGallery();
    </script>
@stop