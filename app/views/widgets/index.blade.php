@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Widgets ::
@parent
@stop

{{-- Page content --}}
@section('content')
<h3>
	<span class="fa fa-puzzle-piece"></span> Widgets
</h3>
<hr />
<div class="row">
	@foreach($widgets as $widget)
		<div class="col-md-3 col-sm-4 col-xs-6">
			<div class="box {{ $widget->status }} widget" id="widget-{{ $widget->id }}">
			  <div class="box-header">
			  	<h3 class="box-title">{{ $widget->name }}</h3>
			  	<div class="box-tools pull-right">
			  		<input type="checkbox" name="status" value="on" class="flat-red" data-id="{{ $widget->id }}" {{ $widget->status=='on' ? 'checked="checked"' : ''}} />
			  	</div>
			  </div>
			  <div class="box-body">
			    <p>ID: {{ $widget->id }}</p>
			    <p>{{ $widget->description }}</p>
			    #{{ $widget->form }}
			  </div>
			</div>
		</div>
	@endforeach
</div>
@stop