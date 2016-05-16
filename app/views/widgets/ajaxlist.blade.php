@extends('backend/layouts/widget')

{{-- Page title --}}
@section('title')
Thư viện của tôi ::
@parent
@stop
{{-- Page content --}}
@section('content')
<div class=""  >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Thêm Widgets</h4>
      </div>
      <div class="modal-body">
		<div class="row">
			@foreach($widgets as $widget)
				<div class="col-md-6">
					<div class="panel panel-default">
					  <div class="panel-heading">
					  	<span class="fa fa-puzzle-piece"></span> {{ $widget->name }}
					  	<a class="btn btn-info btn-xs pull-right" rel="{{ $widget->id }}" onclick="parent.addWidget('{{ $widget->id }}', '{{ $item_id }}', '{{ $type }}', this);" data-toggle="tooltip" data-placement="bottom" title="Thêm widget này"><span class="glyphicon glyphicon-plus-sign"></span></a>
					  </div>
					  <div class="panel-body">
					    <p>ID: {{ $widget->id }}</p>
					    <p>{{ $widget->description }}</p>
					    #{{ $widget->form }}
					  </div>
					</div>
				</div>
			@endforeach
		</div>
      </div>
   	</div>
  </div>
</div>