<div class="col-md-6 col-sm-6 col-xs-12" id="sidebarref-{{ $sidebar->srid }}">
	<div class="box box-primary">
	  <div class="box-header">
	  	<h3 class="box-title">#{{ $sidebar->id }} {{ $sidebar->name }}</h3>
	  	<div class="box-tools pull-right">
	  		<label class="label label-default">{{ $sidebar->position }}</label>
	  		<a class="btn btn-default btn-xs" href="{{ URL::to('admin/sidebars') }}"><i class="fa fa-puzzle-piece"></i> Sửa widgets </a>
	  		<a href="javascript:void(0)" onclick="removeSidebarRef('{{ $sidebar->srid }}', this)" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-remove"></i> Xóa </a>
	  	</div>
	  </div>
	</div>
</div>