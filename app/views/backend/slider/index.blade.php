@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    Quản lý slider ::
    @parent
@stop

{{-- Page content --}}
@section('content')
    <h3>
        <span class="glyphicon glyphicon-pencil"></span> Quản lý slider trang chủ
    </h3>
    <ul class="nav nav-tabs" style="margin: 15px 0">
        <li class="active"><a href="#tab-general" data-toggle="tab">Thông tin chung</a></li>
    </ul>
    <div class="row">
        <div class="col-md-9" style="border-right: 1px solid #cccccc">
            <div class="tab-content">
                <div class="tab-pane active" id="tab-general">
                    <div class="panel panel-info">
                        <div class="panel-heading"><span class="glyphicon glyphicon-picture"></span> Danh sách ảnh</div>
                        <div class="panel-body">
                            <div id="image-list" style="overflow: hidden">
                                @foreach($slider->slidermedias as $m)
                                    <div id="productImg{{ $m->id }}" style="width: 110px; float: left; margin: 5px 5px; ">
                                        <div class="thumbnail">
                                            <div style="height:100px;">
                                                <img src="{{ asset($m->mpath .'/100x100_crop/'. $m->mname ) }}" width="100" />
                                            </div>
                                            <a class="label label-default" href="javascript:void(0)" onclick="removeSliderImage('{{ $m->id }}')" >Bỏ ảnh</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <a data-toggle="modal" href="#modal_updateMedia" class="btn btn-info media-modal" data-url="{{ URL::to('medias/upload?env=slider-images') }}"><span class="glyphicon glyphicon-plus"></span> Thêm ảnh</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
