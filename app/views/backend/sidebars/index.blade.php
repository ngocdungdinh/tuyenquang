@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Sidebars ::
@parent
@stop

{{-- Page content --}}
@section('content')
<h3>
	<span class="fa fa-columns"></span> Sidebars  
	<a data-toggle="modal" data-target="#modal_display" class="btn btn-info btn-xs show-modal" href="{{ URL::to('admin/sidebars/form') }}"><i class="fa fa-plus-circle"></i> Tạo mới </a>
</h3>
<hr />
<div class="row">
	@foreach($sidebars as $sidebar)
		@if($sidebar->position == 'bottom' || $sidebar->position == 'default' || $sidebar->position == 'top')
			<div class="col-md-4 col-sm-4 col-xs-12">
				<div class="box box-info" id="sidebar-{{ $sidebar->id }}">
				  <div class="box-header">
				  	<h3 class="box-title">#{{ $sidebar->id }} {{ $sidebar->name }} <small>{{ $sidebar->code }}</small></h3>
				  	<div class="box-tools pull-right">
				  		<label class="label label-default">{{ $sidebar->position }}</label>
				  		<a data-toggle="modal" data-target="#modal_display" class="btn btn-default btn-xs show-modal" href="{{ URL::to('admin/widgets/ajaxlist?item_id='. $sidebar->id .'&type=sidebar') }}"><i class="fa fa-puzzle-piece"></i> Thêm widgets </a>
				  		<a data-toggle="modal" data-target="#modal_display" class="btn btn-default btn-xs show-modal" href="{{ URL::to('admin/sidebars/form?sid='. $sidebar->id) }}"><i class="fa fa-edit"></i> Sửa </a>
				  		<!-- <input type="checkbox" name="status" value="on" class="flat-red" data-id="{{ $sidebar->id }}" {{ $sidebar->status=='on' ? 'checked="checked"' : ''}} /> -->
				  		<button class="btn btn-default btn-xs" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-plus"></i></button>
				  	</div>
				  </div>
				  <div class="box-body" style="display: none;">
						<div id="widgetList{{ $sidebar->id }}" style="padding-bottom: 6px">
							@if($sidebar->widgets()->count())
								<ol class="itemsort">
									@foreach($sidebar->widgets as $widget)
										<li class="link-item big" data-wrid="{{$widget->wrid}}" data-position="{{$widget->position}}">
											<p class="btn btn-default btn-block">
												<span class="handle-item {{ $widget->wrstatus }}" style="cursor: move"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></span>
												<span><strong>{{ $widget->title }}</strong> <small> - {{ $widget->name }}</small> </span>
												<a href="{{ URL::to('admin/widgets/updatewidgetref?name='.$widget->form.'&id='.$widget->wrid.'&v='.time()) }}" data-toggle="modal" data-target="#modal_display" class="btn btn-xs show-modal pull-right"><i class="glyphicon glyphicon-edit"></i></a>
												<a href="javascript:void(0)" onclick="removeWidget('{{ $widget->wrid }}', this)" class="btn btn-xs pull-right"><i class="glyphicon glyphicon-remove"></i></a>
											</p>
										</li>
									@endforeach
								</ol>
							@else
								<ol class="itemsort">
								</ol>
							<p>- no widget -</p>
							@endif
						</div>
				  </div>
				</div>
			</div>
		@endif
	@endforeach
</div>
<div class="row">
	<div class="col-md-4 col-sm-4 col-xs-12">
		<h3>Left</h3>
		@foreach($sidebars as $sidebar)
			@if($sidebar->position == 'left')
				<div class="box box-info" id="sidebar-{{ $sidebar->id }}">
				  <div class="box-header">
				  	<h3 class="box-title">#{{ $sidebar->id }} {{ $sidebar->name }} <small>{{ $sidebar->code }}</small></h3>
				  	<div class="box-tools pull-right">
				  		<label class="label label-default">{{ $sidebar->position }}</label>
				  		<a data-toggle="modal" data-target="#modal_display" class="btn btn-default btn-xs show-modal" href="{{ URL::to('admin/widgets/ajaxlist?item_id='. $sidebar->id .'&type=sidebar') }}"><i class="fa fa-puzzle-piece"></i> Thêm widgets </a>
				  		<a data-toggle="modal" data-target="#modal_display" class="btn btn-default btn-xs show-modal" href="{{ URL::to('admin/sidebars/form?sid='. $sidebar->id) }}"><i class="fa fa-edit"></i> Sửa </a>
				  		<!-- <input type="checkbox" name="status" value="on" class="flat-red" data-id="{{ $sidebar->id }}" {{ $sidebar->status=='on' ? 'checked="checked"' : ''}} /> -->
				  		<button class="btn btn-default btn-xs" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-plus"></i></button>
				  	</div>
				  </div>
				  <div class="box-body" style="display: none;">
						<div id="widgetList{{ $sidebar->id }}" style="padding-bottom: 6px">
							@if($sidebar->widgets()->count())
								<ol class="itemsort">
									@foreach($sidebar->widgets as $widget)
										<li class="link-item big" data-wrid="{{$widget->wrid}}" data-position="{{$widget->position}}">
											<p class="btn btn-default btn-block">
												<span class="handle-item {{ $widget->wrstatus }}" style="cursor: move"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></span>
												<span><strong>{{ $widget->title }}</strong> <small> - {{ $widget->name }}</small> </span>
												<a href="{{ URL::to('admin/widgets/updatewidgetref?name='.$widget->form.'&id='.$widget->wrid.'&v='.time()) }}" data-toggle="modal" data-target="#modal_display" class="btn btn-xs show-modal pull-right"><i class="glyphicon glyphicon-edit"></i></a>
												<a href="javascript:void(0)" onclick="removeWidget('{{ $widget->wrid }}', this)" class="btn btn-xs pull-right"><i class="glyphicon glyphicon-remove"></i></a>
											</p>
										</li>
									@endforeach
								</ol>
							@else
								<ol class="itemsort">
								</ol>
							<p>- no widget -</p>
							@endif
						</div>
				  </div>
				</div>
			@endif
		@endforeach
	</div>
	<div class="col-md-4 col-sm-4 col-xs-12">
		<h3>Center</h3>
		@foreach($sidebars as $sidebar)
			@if($sidebar->position == 'center')
				<div class="box box-info" id="sidebar-{{ $sidebar->id }}">
				  <div class="box-header">
				  	<h3 class="box-title">#{{ $sidebar->id }} {{ $sidebar->name }} <small>{{ $sidebar->code }}</small></h3>
				  	<div class="box-tools pull-right">
				  		<label class="label label-default">{{ $sidebar->position }}</label>
				  		<a data-toggle="modal" data-target="#modal_display" class="btn btn-default btn-xs show-modal" href="{{ URL::to('admin/widgets/ajaxlist?item_id='. $sidebar->id .'&type=sidebar') }}"><i class="fa fa-puzzle-piece"></i> Thêm widgets </a>
				  		<a data-toggle="modal" data-target="#modal_display" class="btn btn-default btn-xs show-modal" href="{{ URL::to('admin/sidebars/form?sid='. $sidebar->id) }}"><i class="fa fa-edit"></i> Sửa </a>
				  		<!-- <input type="checkbox" name="status" value="on" class="flat-red" data-id="{{ $sidebar->id }}" {{ $sidebar->status=='on' ? 'checked="checked"' : ''}} /> -->
				  		<button class="btn btn-default btn-xs" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-plus"></i></button>
				  	</div>
				  </div>
				  <div class="box-body" style="display: none;">
						<div id="widgetList{{ $sidebar->id }}" style="padding-bottom: 6px">
							@if($sidebar->widgets()->count())
								<ol class="itemsort">
									@foreach($sidebar->widgets as $widget)
										<li class="link-item big" data-wrid="{{$widget->wrid}}" data-position="{{$widget->position}}">
											<p class="btn btn-default btn-block">
												<span class="handle-item {{ $widget->wrstatus }}" style="cursor: move"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></span>
												<span><strong>{{ $widget->title }}</strong> <small> - {{ $widget->name }}</small> </span>
												<a href="{{ URL::to('admin/widgets/updatewidgetref?name='.$widget->form.'&id='.$widget->wrid.'&v='.time()) }}" data-toggle="modal" data-target="#modal_display" class="btn btn-xs show-modal pull-right"><i class="glyphicon glyphicon-edit"></i></a>
												<a href="javascript:void(0)" onclick="removeWidget('{{ $widget->wrid }}', this)" class="btn btn-xs pull-right"><i class="glyphicon glyphicon-remove"></i></a>
											</p>
										</li>
									@endforeach
								</ol>
							@else
								<ol class="itemsort">
								</ol>
							<p>- no widget -</p>
							@endif
						</div>
				  </div>
				</div>
			@endif
		@endforeach
	</div>
	<div class="col-md-4 col-sm-4 col-xs-12">
		<h3>Right</h3>
		@foreach($sidebars as $sidebar)
			@if($sidebar->position == 'right')
				<div class="box box-info" id="sidebar-{{ $sidebar->id }}">
				  <div class="box-header">
				  	<h3 class="box-title">#{{ $sidebar->id }} {{ $sidebar->name }} <small>{{ $sidebar->code }}</small></h3>
				  	<div class="box-tools pull-right">
				  		<label class="label label-default">{{ $sidebar->position }}</label>
				  		<a data-toggle="modal" data-target="#modal_display" class="btn btn-default btn-xs show-modal" href="{{ URL::to('admin/widgets/ajaxlist?item_id='. $sidebar->id .'&type=sidebar') }}"><i class="fa fa-puzzle-piece"></i> Thêm widgets </a>
				  		<a data-toggle="modal" data-target="#modal_display" class="btn btn-default btn-xs show-modal" href="{{ URL::to('admin/sidebars/form?sid='. $sidebar->id) }}"><i class="fa fa-edit"></i> Sửa </a>
				  		<!-- <input type="checkbox" name="status" value="on" class="flat-red" data-id="{{ $sidebar->id }}" {{ $sidebar->status=='on' ? 'checked="checked"' : ''}} /> -->
				  		<button class="btn btn-default btn-xs" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-plus"></i></button>
				  	</div>
				  </div>
				  <div class="box-body" style="display: none;">
						<div id="widgetList{{ $sidebar->id }}" style="padding-bottom: 6px">
							@if($sidebar->widgets()->count())
								<ol class="itemsort">
									@foreach($sidebar->widgets as $widget)
										<li class="link-item big" data-wrid="{{$widget->wrid}}" data-position="{{$widget->position}}">
											<p class="btn btn-default btn-block">
												<span class="handle-item {{ $widget->wrstatus }}" style="cursor: move"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></span>
												<span><strong>{{ $widget->title }}</strong> <small> - {{ $widget->name }}</small> </span>
												<a href="{{ URL::to('admin/widgets/updatewidgetref?name='.$widget->form.'&id='.$widget->wrid.'&v='.time()) }}" data-toggle="modal" data-target="#modal_display" class="btn btn-xs show-modal pull-right"><i class="glyphicon glyphicon-edit"></i></a>
												<a href="javascript:void(0)" onclick="removeWidget('{{ $widget->wrid }}', this)" class="btn btn-xs pull-right"><i class="glyphicon glyphicon-remove"></i></a>
											</p>
										</li>
									@endforeach
								</ol>
							@else
								<ol class="itemsort">
								</ol>
							<p>- no widget -</p>
							@endif
						</div>
				  </div>
				</div>
			@endif
		@endforeach
	</div>
</div>
<script src="{{ asset('assets/js/jquery-sortable.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var adjustment;
		var p = 1;
	  	$("ol.itemsort").sortable({
		  group: 'itemsort',
		  handle: '.handle-item',
		  pullPlaceholder: true,
		  onDrop: function  ($item, container, _super) {
			$item.removeClass("dragged").removeAttr("style")
			$("body").removeClass("dragging")

			p = 1;
			$("ol.itemsort").children("li").each(function(){
				$(this).attr('data-position', p++);
			});
			updateWidgetsPosition();
		  }
		});
	});
</script>
@stop