@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Quản lý trang ::
@parent
@stop

{{-- Page content --}}
@section('content')
	<h3>
    	<span class="glyphicon glyphicon-book"></span> Quản lý menu
    </h3>
    <div class="row">
    	<div class="col-md-4">
	    	<div class="panel panel-default">
			  <div class="panel-heading">
			  	Menu
			  	@if ( Sentry::getUser()->hasAnyAccess(['menus','menus.create']) )
			  		<a href="javascript:void(0)" onclick="$('#add-menu').fadeToggle(); $('#create-title').focus()" class="pull-right"><span class="glyphicon glyphicon-plus"></span></a>
			  	@endif
			  </div>
			  <div class="panel-body">
				<div class="panel-group" id="accordion">					
				  @foreach($menus as $menu)
					  <div class="panel {{ (isset($mId) && $mId == $menu->id) ? 'panel-primary' : 'panel-info' }}">
					    <div class="panel-heading">
					      <h4 class="panel-title" style="overflow: hidden">
					      	<a href="{{ URL::to('admin/menus?m='.$menu->id) }}" class="pull-left">{{ $menu->title }} <small>- {{ $menu->position }}</small></a>
					        <a data-toggle="collapse" data-parent="#accordion" href="#menu{{ $menu->id }}" class="pull-right">
					          <span class="glyphicon glyphicon-collapse-down"></span>
					        </a>
					      </h4>
					    </div>
					    <div id="menu{{ $menu->id }}" class="panel-collapse collapse">
					      <div class="panel-body">
					    	@if ( Sentry::getUser()->hasAnyAccess(['menus','menus.edit']) )
					    		<div>
					    			<form method="post" action="{{ route('create/menu') }}" autocomplete="off" class="form-horizontal" role="form">
										<!-- CSRF Token -->
										<input type="hidden" name="_token" value="{{ csrf_token() }}" />
										<input type="hidden" name="menu_id" value="{{ $menu->id }}" />
										<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
											<label class="col-sm-4 control-label" for="title">Tên menu</label>
											<div class="col-lg-8">
												<input class="form-control" type="text" name="title" id="title" value="{{ $menu->title }}" />
											</div>
										</div>
										<div class="form-group">
											<label for="position" class="col-sm-4 control-label">Vị trí</label>
											<div class="col-lg-8">
												<select name="position" id="position" class="form-control">
													<option value="nav" {{ $menu->position=='nav' ? 'selected="selected"' : '' }}>- Navigation</option>
													<option value="sidebar" {{ $menu->position=='sidebar' ? 'selected="selected"' : '' }}>- sidebar</option>
													<option value="top" {{ $menu->position=='top' ? 'selected="selected"' : '' }}>- Top</option>
													<option value="middle" {{ $menu->position=='middle' ? 'selected="selected"' : '' }}>- Middle</option>
													<option value="bottom" {{ $menu->position=='bottom' ? 'selected="selected"' : '' }}>- Bottom</option>
												</select>
											</div>
										</div>
										<div class="col-lg-12" align="right">
											<button type="submit" class="btn btn-success btn-sm">Sửa</button>
											@if ( Sentry::getUser()->hasAnyAccess(['menus','menus.delete']) )
												<a onclick="confirmDelete(this); return false;" href="{{ route('delete/menu', $menu->id) }}" class="btn btn-danger btn-xs">@lang('button.delete')</a>
											@endif
										</div>
					    			</form>
					    		</div>
					    	@endif
					      </div>
					    </div>
					  </div>
				  @endforeach
				</div>
			    <div id="add-menu" style="display:none">
			    	@if ( Sentry::getUser()->hasAnyAccess(['menus','menus.create']) )
			    		<hr />
			    		<div>
			    			<form method="post" action="{{ route('create/menu') }}" autocomplete="off" class="form-horizontal" role="form">
								<!-- CSRF Token -->
								<input type="hidden" name="_token" value="{{ csrf_token() }}" />
								<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
									<label class="col-sm-3 control-label" for="create-title">Tên menu</label>
									<div class="col-lg-8">
										<input class="form-control" type="text" name="title" id="create-title" value="{{ Input::old('name') }}" />
									</div>
								</div>
								<div class="form-group">
									<label for="position" class="col-sm-4 control-label">Vị trí</label>
									<div class="col-lg-8">
										<select name="position" id="position" class="form-control">
											<option value="nav">- Navigation</option>
											<option value="sidebar">- sidebar</option>
											<option value="top">- Top</option>
											<option value="middle">- Middle</option>
											<option value="bottom">- Bottom</option>
										</select>
									</div>
								</div>
								<div class="col-lg-12" align="right">
									<button type="submit" class="btn btn-success btn-sm">Tạo</button>
								</div>
			    			</form>
			    		</div>
			    	@endif
			    </div>
			  </div>
			</div>
		</div>
    	<div class="col-md-8 nopl">
	    	<div class="panel panel-default">
			  <div class="panel-heading">
			  	Cấu trúc liên kết của menu
			  	@if ( Sentry::getUser()->hasAnyAccess(['menus','menus.create']) && isset($links) )
			  		<a href="javascript:void(0)" onclick="$('#add-link').fadeToggle(); $('#link-title').focus()" class="pull-right"><span class="glyphicon glyphicon-plus"></span></a>
			  	@endif
			  </div>
			  <div class="panel-body">
			  	<div class="box box-solid" id="add-link" style="display:none;">
			  		<div class="box-body">
					  	<div>
				    		<div>
				    			<form method="post" action="{{ route('create/link') }}" autocomplete="off" class="form-horizontal" role="form">
									<!-- CSRF Token -->
									<input type="hidden" name="_token" value="{{ csrf_token() }}" />
									<input type="hidden" name="menu_id" value="{{ $mId }}" />
									<input type="hidden" name="parent_id" value="0" />
									<input type="hidden" name="item_id" id="item_id" value="0" />
									<div class="form-group {{ $errors->has('alt') ? 'has-error' : '' }}">
										<label class="col-sm-3 control-label" for="url">Đường dẫn</label>
										<div class="col-sm-4">
											<select name="type" id="type" class="form-control" onchange="optionMenuType($(this).val());">
												<option value="category">Chuyên mục</option>
												<option value="page">Trang</option>
												<option value="custom">Tùy chỉnh</option>
											</select>
										</div>
										<div class="col-lg-4">
											<div class="menu_type" id="type_page" style="display: none">
												page
											</div>
											<div class="menu_type" id="type_category">
												<select class="form-control" name="type_item_id" onchange="$('#item_id').val($(this).val())">
													@foreach($categories as $category)
														@if($category->parent_id == 0 && $category->id != 79)
															<option value="{{ $category->id }}" {{ (isset($category_id) && $category->id == $category_id) ? 'selected="selected"' : '' }}>{{ $category->name }}</option>
															@foreach ($category->subscategories as $subcate)
																<option value="{{ $subcate->id }}" {{ (isset($category_id) && $subcate->id == $category_id) ? 'selected="selected"' : '' }}> - {{ $subcate->name }}</option>
															@endforeach
														@endif
													@endforeach
												</select>
											</div>
											<div class="menu_type" id="type_custom" style="display: none">
												<input class="form-control" type="text" name="url" id="url" value="{{ Input::old('url') }}" placeholder="http://" />
											</div>
										</div>
									</div>
									<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}" style="display: none" id="menu_link_name">
										<label class="col-sm-3 control-label" for="link-title">Tên liên kết</label>
										<div class="col-sm-4">
											<input class="form-control" type="text" name="title" id="link-title" value="{{ Input::old('title') }}" />
										</div>
										<div class="col-sm-4">
											<input class="form-control" type="text" name="alt" id="" value="{{ Input::old('alt') }}" placeholder="alt..." />
										</div>
									</div>
									<div class="form-group">
										<label for="target" class="col-sm-3 control-label">Loại</label>
										<div class="col-sm-4">
											<select name="target" id="target" class="form-control">
												<option value="_self">Mở ở trang hiện tại</option>
												<option value="_blank">Mở ở cửa sổ mới</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label"></label>
										<div class="col-sm-4">
										<button type="submit" class="btn btn-success btn-sm">Tạo</button>
										</div>
									</div>
				    			</form>
				    		</div>
					  	</div>
			  		</div>
			  	</div>
			    @if(isset($links))
			    	@if($links->count())
				  		<div class="dd" id="sortableList">
						    <ol class="dd-list">
						    	@foreach($links as $link)
								<li class="dd-item nested-list-item" data-order="{{ $link->position }}" data-id="{{ $link->id }}">
									@include('backend/menus/item')
									<ol class="dd-list">
										@foreach ($link->sublinks()->orderBy('position', 'ASC')->get() as $link)
											<li class="dd-item nested-list-item" data-order="{{ $link->position }}" data-id="{{ $link->id }}">
												@include('backend/menus/item')
										    </li>
										@endforeach
									</ol>
							    </li>
								@endforeach
						    </ol>
						</div>
						<div style="padding: 5px 2px; color: #666666" align="right"><i>Kéo thả để sắp xếp vị trí</i></div>
			    	@else
			    		Chưa có liên kết
			    	@endif
			    @else
			    	<p>Chọn một menu bên trái để thêm liên kết</p>
			    @endif
			  </div>
			</div>
		</div>
    </div>
	<script type="text/javascript">
		$(document).ready(function()
		{
		    // activate Nestable for list 1
		    $('#sortableList').nestable({ 
			   dropCallback: function(details) {
			       console.log(details);
			       var order = new Array();
			       $("li[data-id='"+details.destId +"']").find('ol:first').children().each(function(index,elem) {
			         order[index] = $(elem).attr('data-id');
			       });

			       if (order.length === 0){
			        var rootOrder = new Array();
			        $("#sortableList > ol > li").each(function(index,elem) {
			          rootOrder[index] = $(elem).attr('data-id');
			        });
			       }

			       $.post('/admin/menus/updateLinksPosition', 
			        { 
			          source : details.sourceId, 
			          destination: details.destId, 
			          order:JSON.stringify(order),
			          rootOrder:JSON.stringify(rootOrder) 
			        }, 
			        function(data) {
			         // console.log('data '+data); 
			        })
			       .done(function() { 
			          $( "#success-indicator" ).fadeIn(100).delay(1000).fadeOut();
			       })
			       .fail(function() {  })
			       .always(function() {  });
		     }
		   })
		});
	</script>
@stop
