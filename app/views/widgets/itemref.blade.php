<li class="link-item big" data-wrid="{{$widget->wrid}}" data-position="{{$widget->position}}">
	<p class="btn btn-default btn-block">
		<span class="handle-item {{ $widget->wrstatus }}" style="cursor: move"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></span>
		<span><strong>{{ $widget->title }}</strong> <small> - {{ $widget->name }}</small> </span>
		<a href="{{ URL::to('admin/widgets/updatewidgetref?name='.$widget->form.'&id='.$widget->wrid) }}" data-toggle="modal" data-target="#modal_widgets" class="btn btn-xs show-modal pull-right"><i class="glyphicon glyphicon-edit"></i></a>
		<a href="javascript:void(0)" onclick="removeWidget('{{ $widget->wrid }}', this)" class="btn btn-xs pull-right"><i class="glyphicon glyphicon-remove"></i></a>
	</p>
</li>