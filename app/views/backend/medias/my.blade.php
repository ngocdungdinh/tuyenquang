@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Thư viện của tôi ::
@parent
@stop

{{-- Page content --}}
@section('content')
<h3>
  <span class="glyphicon glyphicon-cloud-upload"></span> Thư viện

  @if ( Sentry::getUser()->hasAnyAccess(['group','group.create']) )
    <a href="{{ route('upload/media') }}" class="btn btn-xs btn-default"><i class="icon-plus-sign icon-white"></i> Tải tệp tin</a>
  @endif
</h3>
  <div>     
    <ul class="nav nav-tabs">
    <li {{ Request::is('admin/medias') ? 'class="active"' : '' }}><a href="{{ URL::to('admin/medias') }}">Tất cả</a></li>
    <li {{ Request::is('admin/medias/my') ? 'class="active"' : '' }}><a href="{{ URL::to('admin/medias/my') }}">Tôi</a></li>
  </ul>
  </div><br />
<div class="row" style="padding-left: 25px;">
    @foreach ($images as $image)
      @include('backend/medias/item')
    @endforeach
</div>
{{ $images->links() }}
@stop
