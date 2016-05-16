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
        <h4 class="modal-title">Thêm Sidebar</h4>
      </div>
      <div class="modal-body">
		<div class="row">
			@foreach($sidebars as $sidebar)
				<div class="col-md-6">					
					<div class="box box-primary" id="sidebar-{{ $sidebar->id }}">
					  <div class="box-header">
					  	<h3 class="box-title">#{{ $sidebar->id }} {{ $sidebar->name }}
					  	</h3>
					  	<div class="box-tools pull-right">
					  		<span class="label label-default label-xs">{{ $sidebar->position }}</span>
					  		<a href="javascript:void(0)" onclick="addSidebarRef('{{ $sidebar->id }}', '{{ $item_id }}', '{{ $type }}')" class="btn btn-default btn-xs"><i class="fa fa-plus"></i></a>
					  	</div>
					  </div>
					</div>
				</div>
			@endforeach
		</div>
      </div>
   	</div>
  </div>
</div>