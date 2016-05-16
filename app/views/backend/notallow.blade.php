@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Khu vực hạn chế ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="alert alert-danger">
	<h4>Khu vực hạn chế!</h4>
	Bạn không đủ quyền hạn để truy cập vào đây.
</div>
@stop