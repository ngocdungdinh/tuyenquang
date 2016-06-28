@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
Contact us ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="row">
    <div class="contact2">
        <div class="tab line_text2">
            <span style="margin:10px 0; color:#015f8a; font-size:16px;">SỞ NGOẠI VỤ TỈNH TUYÊN QUANG</span>
        </div>
        <div class="news_detail_sub2">
            <p>Số 4, Chiến Thắng sông Lô,P. Tân Quang, TP Tuyên Quang</p>
            <p>Điện thoại:027 3 817 626 - Fax: 027 3 817 133</p>
            <div class="col-md-5 form1">
                <ul>
                <li>
                    <div class="lienhe1"><span style="text-align:right; margin-right:">Họ tên<span style="color:#ff0000;">*</span></span></div>
                    <div class="lienhe2"><input style="margin-left:10px;" type="text"/></div>
                </li>
                <li>
                    <div class="lienhe1"><span style="text-align:right; margin-right:">Email<span style="color:#ff0000;">*</span></span></div>
                    <div class="lienhe2"><input style="margin-left:10px;" type="text"/></div>
                </li>
                <li>
                    <div class="lienhe1"><span style="text-align:right; margin-right:">Tiêu đề<span style="color:#ff0000;">*</span></span></div>
                    <div class="lienhe2"><input style="margin-left:10px;" type="text"/></div>
                </li>
                <li>
                    <div class="lienhe1"><span style="text-align:right; margin-right:">Nội dung<span style="color:#ff0000;">*</span></span></div>
                    <div class="lienhe2">
                        <textarea style="margin-left:10px;"></textarea>
                    </div>
                </li>
                <li><div style="float: left; width:100%; padding-right:30px; margin:10px 0;"><span class="bt1">Gửi</span></div></li>
                </ul>
            </div>
            <div class="col-md-6" id="googleMap" ><img class="map img-resp" src="{{ asset('assets/img/tqmap.png') }}" /></div><!--216-->
    </div>

     </div>
</div>
@stop
