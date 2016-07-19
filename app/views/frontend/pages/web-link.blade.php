@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
    {{ $wLink->title }} ::
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
        <div class="col-md-8 left-content">
            <div class="row">
                <div class="col-md-7 contact">
                    <div class="tab line_text2">
                        <span class="tit_underline" style="margin-left:10px">LIÊN KẾT WEBSITE</span>
                    </div>
                    <div class="top-content">
                        <div class="news_detail">
                            <div class="col-md-8 news_detail_text">
                                <div class="item-news-bottom">

                                    <div class="news_detail_sub">
                                        <p>{{ $wLink->content }}</p>
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
            @include('frontend/partials/right-content')
        </div><!---end right-content---->

    </div>
@stop