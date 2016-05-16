@extends('frontend/layouts/default')

{{-- Page content --}}
@section('content')
<div class="row">
	<div class="span3">
		<ul class="nav nav-pills">
		</ul>
	</div>
	<div class="span9">
		@yield('profile-content')
	</div>
</div>
@stop