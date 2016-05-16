@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Quản lý chuyên mục ::
@parent
@stop

{{-- Page content --}}
@section('content')
	<div class="box box-solid">
	    <div class="box-body">
	    	<div class="row">
	    		<div class="col-ld-2 col-md-3 col-sm-3">
                    <div class="box-header">
			    		<span class="glyphicon glyphicon-pencil"></span> 
			    		<h3 class="box-title">Chuyên mục</h3>
                    </div>
			    	@if ( Sentry::getUser()->hasAnyAccess(['news','news.createcategory']) )
			    		<a href="{{ route('create/category') }}" class="btn btn-block btn-primary">Tạo chuyên mục</a>
			    	@endif
                </div>
	    		<div class="col-ld-10 col-md-9 col-sm-9">	   
	    			<div style="padding: 10px 0">
	    			</div>
	    			<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th class="span6">Id</th>
									<th class="span6">Chuyên mục</th>		
									<th class="span2">Thứ tự Menu</th>
									<th class="span2">Thứ tự Homepage</th>
									<th class="span2">Trạng thái</th>
									<th class="span2">@lang('table.actions')</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($categories as $category)
									@if($category->parent_id == 0)
										<tr>
											<td>{{ $category->id }}</td>
											<td><strong>{{ $category->name }}</strong></td>
											<td>{{ $category->showon_menu }}</td>
											<td>{{ $category->showon_homepage }}</td>
											<td>{{ $category->status }}</td>
											<td>
												@if ( Sentry::getUser()->hasAnyAccess(['news','news.editcategory']) )
													<a href="{{ route('update/category', $category->id) }}" class="btn btn-default btn-xs">@lang('button.edit')</a>
												@endif
											</td>
										</tr>
										@foreach ($category->subscategories as $subcate)						
											<tr>
												<td>{{ $subcate->id }}</td>
												<td> - - {{ $subcate->name }}</td>
												<td>{{ $subcate->showon_menu }}</td>
												<td>{{ $subcate->showon_homepage }}</td>
												<td>{{ $subcate->status }}</td>
												<td>
													@if ( Sentry::getUser()->hasAnyAccess(['news','news.editcategory']) )
														<a href="{{ route('update/category', $subcate->id) }}" class="btn btn-default btn-xs">@lang('button.edit')</a>
													@endif
												</td>
											</tr>
										@endforeach
									@endif
								@endforeach
							</tbody>
						</table>
	    			</div>
	    		</div>
	    	</div>
	    </div>
	</div>
	<h3>
    	<span class="glyphicon glyphicon-pencil"></span> Chuyên mục
    </h3>
    </h3>
	<div class="box">
	    <div class="box-header">
	    </div><!-- /.box-header -->
	    <div class="box-body">
		</div>
	</div>
@stop
