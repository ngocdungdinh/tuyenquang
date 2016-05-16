@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Sắp xếp bài viết ::
@parent
@stop

{{-- Page content --}}
@section('content')
<h3>
	<i class="fa fa-sort-numeric-asc"></i> Sắp xếp bài viết
	@if ( Sentry::getUser()->hasAnyAccess(['news','news.sort']) )
		Bạn có thể sắp xếp
	@endif
	<span class="pull-right">
		<small>Sắp xếp lại: </small>
		<a href="{{ URL::to('admin/news/resorts?type=home') }}" class="btn btn-primary btn-xs">Bài nổi bật</a>
		<a href="{{ URL::to('admin/news/resorts?type=home_populars') }}" class="btn btn-info btn-xs">Bài tiêu điểm</a>
		<a href="{{ URL::to('admin/news/resorts?type=category') }}" class="btn btn-warning btn-xs">Các chuyên mục</a>
	</span>
</h3>
<div class="box">
    <div class="box-header">
    </div><!-- /.box-header -->
    <div class="box-body">
    	<div class="row">
    		<div class="col-ld-2 col-md-3 col-sm-3">
    			<ul class="nav nav-pills nav-stacked">
					<li {{ $type=='home' ? 'class="active"' : '' }}><a href="{{ URL::to('admin/news/sorts') }}"><span class="glyphicon glyphicon-th-list"></span> <strong>Bài nổi bật Trang chủ</strong></a></li>
					<li {{ $type=='home_populars' ? 'class="active"' : '' }}><a href="{{ URL::to('admin/news/sorts?type=home_populars') }}"><span class="glyphicon glyphicon-th-list"></span> <strong>Bài tiêu điểm Trang chủ</strong></a></li>
					@foreach($categories as $category)
						<li {{ $cat==$category->id ? 'class="active"' : '' }}><a href="{{ URL::to('admin/news/sorts?type=category_'.$category->id) }}"><i class="fa fa-minus"></i> <strong>{{ $category->name }}</strong></a></li>
						@foreach ($category->subscategories as $subcate)
							<li {{ $cat==$subcate->id ? 'class="active"' : '' }}><a href="{{ URL::to('admin/news/sorts?type=category_'.$subcate->id) }}"><i class="fa fa-minus"></i> -- {{ $subcate->name }}</a></li>
						@endforeach
					@endforeach
				</ul>
    		</div>
    		<div class="col-ld-10 col-md-9 col-sm-9">
    			<p>
    				<a data-toggle="modal" href="/admin/news/postlist?type_sort={{ $type == 'category' ? $type.'_'.$cat : $type }}" data-target="#modal_addposts" class="btn btn-xs btn-default show-modal"><i class="fa fa-plus"></i> Thêm bài</a>
    			</p>
    			@if(isset($posts_position))
					<div class="panel-group" id="accordion">
					  <ol class="itemsort">
					  	@foreach($posts_position as $key => $post)
					  	<li class="link-item big" data-type="{{$type == 'category' ? $type.'_'.$cat : $type}}" data-pid="{{$post->id}}" data-position="{{$key+1}}">
						  <div class="panel panel-default">
						    <div class="panel-heading" style="padding: 4px;">
						      <h4 class="panel-title">
						      	<div class="row">
						      		<div class="col-xs-1">
								      	<span class="drag-to-move">
								      		<button class="btn btn-default order-num" style="cursor: move; ">{{ $key+1 }}</button>
								      	</span>
								    </div>
						      		<div class="col-xs-1" style="padding: 0 3px;">
								      	<span class="drag-to-move">
									      	@if(isset($post->mname) && $post->mtype == 'image')
												<img src="{{ asset($post->mpath . '/100x100_crop/'. $post->mname) }}" class="img-thumbnail img-responsive">
											@endif
								      	</span>
								    </div>
						      		<div class="col-xs-6 drag-to-move" style="padding: 5px 5px;">
								      	<strong>{{ $post->title }}</strong>
								      	<small># {{ $post->id }}</small>
						      		</div>
						      		<div class="col-xs-4" align="right" style="padding: 5px 15px;">
							      		<span style="padding-bottom: 4px; display: block">
								      		<small>{{ $post->author->first_name }} {{ $post->author->last_name }} - </small>
								      		<span title="{{ $post->publish_date }}">{{ date("H:i - d/m/Y",strtotime($post->publish_date)) }}</span>
							      		</span>
										<span style="position: relative !important; display:inline-block"> 
										  <a href="{{ route('update/news', $post->id) }}" class="btn btn-default  btn-xs" target="_blank">Sửa</a> 
										  <a href="javascript:void(0)" class="btn btn-danger btn-xs" onclick="postRemovePosition('{{$post->id}}', '{{$type}}', '{{ $post->is_featured }}', '{{ $post->is_popular }}', '{{ $post->showon_category }}')">Bỏ</a>
										</span>
						      		</div>
						      	</div>
						      </h4>
						    </div>
						  </div>					  		
					  	</li>
					  	@endforeach
					  </ol>
					</div>
				@endif
    		</div>
    	</div>
    </div>
</div>
<div class="modal fade" id="modal_addposts" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="modalRelatePost" ></div><!-- /.modal -->
<script src="{{ asset('assets/js/jquery-sortable.min.js') }}"></script>
<script type="text/javascript">    	

	var adjustment;
	var p = 1;
  	$("ol.itemsort").sortable({
	  group: 'itemsort',
	  handle: '.drag-to-move',
	  pullPlaceholder: true,
	  onDrop: function  ($item, container, _super) {
		$item.removeClass("dragged").removeAttr("style")
		$("body").removeClass("dragging")
		  
		// $("ol.itemsort").children("li").attr('data-drive', 1).attr('data-sure', 1);

		p = 1;
		var po = 1;
	    var dataSort = '';
	    var dataType = '';
		$("ol.itemsort").children("li").each(function(){
			po = p++;
			$(this).attr('data-position', po);

	        dataSort = dataSort + $(this).data('pid') + ':' + po + ',';
	        dataType = $(this).data('type');
		});

		$(".order-num").each(function(index, e) {
			$(this).html(index + 1);
		});

		updatePostPosition(dataType, dataSort);
	  }
	});
</script>
@stop