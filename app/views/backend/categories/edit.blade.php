@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Sửa chuyên mục ::
@parent
@stop

{{-- Page content --}}
@section('content')
	<h3>
    	<span class="glyphicon glyphicon-pencil"></span> Sửa chuyên mục 
    	<a href="{{ route('create/category') }}" class="btn btn-info btn-xs">Tạo chuyên mục</a>
    </h3>
  	<form method="post" action="" autocomplete="off" class="form-horizontal" role="form">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		<div class="box box-solid">
		    <div class="box-header">
		    </div><!-- /.box-header -->
		    <div class="box-body">
		    	<div class="row">
			    	<div class="col-md-5 col-sm-6">
						<!-- Tabs -->
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab-general" data-toggle="tab"><strong><span class="glyphicon glyphicon-list-alt"></span> Thông tin cơ bản</a></strong></li>
								<li><a href="#tab-meta-data" data-toggle="tab"><span class="glyphicon glyphicon-info-sign"></span> SEO</a></li>
							</ul>
							<!-- Tabs Content -->
							<div class="tab-content" style="overflow: hidden">
								<!-- General tab -->
								<div class="tab-pane active" id="tab-general">
									<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
										<label class="col-md-4 control-label" for="name">Tiêu đề</label>
										<div class="col-md-8">
											<input class="form-control" type="text" name="name" id="name" value="{{ $category->name }}" />
										</div>
									</div>

									<div class="form-group">
										<label for="parent_id" class="col-md-4 control-label">Chuyên mục cha</label>
										<div class="col-md-8">
											<select name="parent_id" id="parent_id" class="form-control">
												<option value="0">- Chuyên mục lớn</option>
												@foreach($categories as $cat)
													<option {{ $cat->id == $category->parent_id ? 'selected="selected"' : '' }} value="{{ $cat->id }}">- - {{ $cat->name }}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-4 control-label" for="showon_menu">Thứ tự Menu</label>
										<div class="col-md-4">
											<input class="form-control" type="text" name="showon_menu" id="showon_menu" value="{{ $category->showon_menu }}" />
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-4 control-label" for="showon_homepage">Thứ tự Homepage</label>
										<div class="col-md-4">
											<input class="form-control" type="text" name="showon_homepage" id="showon_homepage" value="{{ $category->showon_homepage }}" />
										</div>
									</div>

									<div class="form-group">
										<label for="showon_position" class="col-md-4 control-label">Vị trí hiển thị</label>
										<div class="col-md-6">
											<select name="showon_position" class="form-control">
												<option value="1" {{ $category->showon_position=='1' ? 'selected="selected"' : '' }}>Menu chính</option>
												<option value="2" {{ $category->showon_position=='2' ? 'selected="selected"' : '' }}>Sidebar</option>
											</select>
										</div>
									</div>

									<div class="form-group">
										<label for="status" class="col-md-4 control-label">Trạng thái</label>
										<div class="col-md-6">
											<select name="status" class="form-control">
												<option value="on" {{ $category->status=='on' ? 'selected="selected"' : '' }}>Hiển thị</option>
												<option value="off" {{ $category->status=='off' ? 'selected="selected"' : '' }}>Ẩn</option>
											</select>
										</div>
									</div>
								</div>
								<!-- Meta Data tab -->
								<div class="tab-pane" id="tab-meta-data">
									<div class="col-md-12">
										@include('backend/inc/seo_update')
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="status" class="col-md-4 control-label"></label>
							<div class="col-md-6">
								<button type="submit" class="btn btn-success btn-sm">Lưu</button>
								@if ( Sentry::getUser()->hasAnyAccess(['news','news.deletecategory']) )
									<a onclick="confirmDelete(this); return false;" href="{{ route('delete/category', $category->id) }}" class="btn btn-danger btn-xs">@lang('button.delete')</a>
								@endif
							</div>
						</div>
			    	</div>
			    	<div class="col-md-7 col-sm-6">
			    		<h3>
							<span class="fa fa-columns"></span> Sidebars <a data-toggle="modal" data-target="#modal_display" class="btn btn-default btn-xs show-modal" href="{{ URL::to('admin/sidebars/ajaxlist?item_id='.$category->id.'&type=Category') }}"><i class="fa fa-list"></i> Thêm </a>
						</h3>
						<div class="row" id="sidebarList">
							@foreach($category->sidebars()->get() as $sidebar)
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
							@endforeach
						</div>
			    	</div>
			    </div>
			</div>
		</div>
	</form>
@stop
