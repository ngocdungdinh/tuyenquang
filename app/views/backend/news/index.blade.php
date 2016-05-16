@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Quản lý tin ::
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
			    		<h3 class="box-title">Bài viết</h3>
                    </div>
			    	@if ( Sentry::getUser()->hasAnyAccess(['news','news.create']) )
			    		<a href="javascript:void(0)" data-toggle="modal" data-target="#modal_newpost" class="btn btn-block btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> Tạo bài viết</a>
			    	@endif
                    <div style="margin-top: 15px;">
		    			<ul class="nav nav-pills nav-stacked">	    				
						  <li {{ $status=='' ? 'class="active"' : '' }}><a href="{{ URL::to('admin/news') }}"><span class="glyphicon glyphicon-th-list"></span> Tất cả ({{ $countposts->total }})</a></li>
						  <li {{ $status=='published' ? 'class="active"' : '' }}><a href="{{ URL::to('admin/news?status=published') }}"><span class="glyphicon glyphicon-ok-sign"></span> @lang('admin/news/table.published') <span class="badge bg-green pull-right">{{ $countposts->published }}</span></a></li>
						  <li {{ $status=='reviewed' ? 'class="active"' : '' }}><a href="{{ URL::to('admin/news?status=reviewed') }}"><span class="glyphicon glyphicon-check"></span> @lang('admin/news/table.reviewed') <span class="badge bg-info pull-right">{{ $countposts->reviewed }}</span></a></li>
						  <li {{ $status=='submitted' ? 'class="active"' : '' }}><a href="{{ URL::to('admin/news?status=submitted') }}"><span class="glyphicon glyphicon-time"></span> @lang('admin/news/table.submitted') <span class="badge bg-info pull-right">{{ $countposts->submitted }}</span></a></li>
						  <li {{ $status=='unpublish' ? 'class="active"' : '' }}><a href="{{ URL::to('admin/news?status=unpublish') }}"><span class="glyphicon glyphicon-share"></span> @lang('admin/news/table.unpublish') <span class="badge bg-danger pull-right">{{ $countposts->unpublish }}</span></a></li>
						  <li {{ $status=='returned' ? 'class="active"' : '' }}><a href="{{ URL::to('admin/news?status=returned') }}"><span class="glyphicon glyphicon-repeat"></span> @lang('admin/news/table.returned') <span class="badge bg-warning pull-right">{{ $countposts->returned }}</span></a></li>
						  <li {{ $status=='draft' ? 'class="active"' : '' }}><a href="{{ URL::to('admin/news?status=draft') }}"><span class="glyphicon glyphicon-floppy-disk"></span> @lang('admin/news/table.draft') <span class="badge bg-default pull-right">{{ $countposts->draft }}</span></a></li>
						  <li {{ $status=='deleted' ? 'class="active"' : '' }}><a href="{{ URL::to('admin/news?status=deleted') }}"><span class="glyphicon glyphicon-trash"></span> @lang('admin/news/table.deleted') <span class="badge bg-default pull-right">{{ $countposts->deleteds }}</span></a></li>
		    			</ul>
	    			</div>
	    		</div>
	    		<div class="col-ld-10 col-md-9 col-sm-9">	   
	    			<div style="padding: 10px 0">
	    				<div align="left">
						  	<form method="get" action="" autocomplete="off" role="form" class="form-inline">
								<!-- CSRF Token -->
								<input type="hidden" name="_token" value="{{ csrf_token() }}" />
								<input type="hidden" name="status" value="{{ $status }}" />
								<div class="form-group {{ $errors->has('key') ? 'has-error' : '' }}">
									<input class="form-control" type="text" name="key" id="key" value="{{ Input::old('key', (isset($keyword) ? $keyword : '')) }}" placeholder="Tiêu đề" style="width: 150px;" />
								</div>
								<div class="form-group">
									<select class="form-control" name="type" style="width: 120px;">
										<option value="0">- Loại tin -</option>
										<option value="lastest" {{ isset($type) && $type == 'lastest' ? 'selected="selected"' : '' }}> Mới nhất</option>
										<option value="oldest" {{ isset($type) && $type == 'oldest' ? 'selected="selected"' : '' }}> Cũ nhất</option>
										<option value="homepage" {{ isset($type) && $type == 'homepage' ? 'selected="selected"' : '' }}> Trang chủ</option>
										<option value="featured" {{ isset($type) && $type == 'featured' ? 'selected="selected"' : '' }}> Nổi bật</option>
										<option value="popular" {{ isset($type) && $type == 'popular' ? 'selected="selected"' : '' }}> Tiêu điểm</option>
									</select>
								</div>
								@if (!$u->hasAnyAccess(['news', 'news.editowner']))
								<div class="form-group">
									<select class="form-control" name="user_id" style="width: 140px;">
										<option value="0">- Người viết -</option>
										<option value="{{ $u->id }}"> - Tôi -</option>
										@foreach($writers as $writer)
											<option value="{{ $writer->id }}" {{ (isset($user_id) && $writer->id == $user_id) ? 'selected="selected"' : '' }}> {{ $writer->first_name }} {{ $writer->last_name }}</option>
										@endforeach
									</select>
								</div>
								@endif
								<div class="form-group">
									<select class="form-control" name="category_id" style="width: 150px;">
										<option value="0">- Chuyên mục -</option>
										@foreach($categories as $category)
											@if($category->parent_id == 0)
												<option value="{{ $category->id }}" {{ (isset($category_id) && $category->id == $category_id) ? 'selected="selected"' : '' }}>{{ $category->name }}</option>
												@foreach ($category->subscategories as $subcate)
													<option value="{{ $subcate->id }}" {{ (isset($category_id) && $subcate->id == $category_id) ? 'selected="selected"' : '' }}> - {{ $subcate->name }}</option>
												@endforeach
											@endif
										@endforeach
									</select>
								</div>
								<input type="submit" class="btn btn-default btn-info" name="search" value="Tìm" />
						  	</form>
	    				</div>
	    			</div>
	    			<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th></th>
									<th>@lang('admin/news/table.title')</th>
									<th>Người viết</th>
									<th><span class="glyphicon glyphicon-comment"></span> / <span class="glyphicon glyphicon-eye-open"></span></th>
									<th>Ngày</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($posts as $post)
								<tr>
									<td width="1">
										@if(isset($post->mname) && $post->mtype == 'image')
											<img src="{{ asset($post->mpath . '/100x100_crop/'. $post->mname) }}" width="50">
										@elseif($post->mtype == 'video')
											<img src="{{ asset('http://i.ytimg.com/vi/'. $post->mname.'/0.jpg') }}" width="50">
										@else
											<img src="/assets/img/noimage.jpg" alt="Chưa có ảnh đại điện" width="50">
										@endif
									</td>
									<td>
										@if($post->status == 'draft' && (Permission::has_access('news', 'editowner', $post->user_id)))
											<a href="{{ route('update/news', $post->id) }}"><strong>{{ $post->title }}</strong></a>
										@else
											<a style="color: #444444" data-toggle="modal" href="{{ route('view/news', $post->id) }}" class="show-modal" data-target="#modal_display" ><strong>{{ $post->title }}</strong></a>
										@endif
										{{ $post->wc('ccontent') }}
										@if($post->category)
											<div style="padding-top: 3px;"><strong>Chuyên mục: </strong> <a href="{{ URL::to('admin/news/search?category_id='.$post->category->id) }}"> {{ $post->category->name }}</a></div>
										@endif
										{{ $post->has_picture ? '<i class="ion-images fa-red"></i>' : '' }} {{ $post->has_video ? '<i class="ion-videocamera fa-red"></i>' : '' }}
									</td>
									<td>{{ $post->author->first_name }} {{ $post->author->last_name }}</td>
									<td>{{ $post->comment_count }} <span class="glyphicon glyphicon-comment" style="color:#76797c"></span> / {{ $post->view_count }}</td>
									<td>
										@if($post->status == 'published')
											<span title="{{ $post->publish_date }}">{{ date("H:i - d/m/Y",strtotime($post->publish_date)) }}</span>
										@else
											<span title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</span>
										@endif
										<br />
										@if($post->deleted_at)
											<a onclick="confirmDelete(this); return false;" href="{{ route('restore/news', $post->id) }}" class="btn btn-xs btn-default btooltip" data-toggle="tooltip" title="Nhận viết bài này">Khôi phục</a>
										@elseif($post->status == 'published')
											@if($post->publish_date >= $curr_time->format('Y-m-d H:i'))
												<label class="label" style="color: #46a246"><span class="glyphicon glyphicon-time"></span> Sắp xuất bản</label>
											@else
												<label class="label label-success">Đã xuất bản</label>
												<a href="{{ $post->url() }}" target="_blank"># {{ $post->id }}</a>
											@endif
										@elseif($post->status == 'unpublish')
											<label class="label label-warning">Bị gỡ</label>
										@elseif($post->status == 'reviewing')
											<label class="label label-info">Đang biên tập</label>
										@elseif($post->status == 'reviewed')
											<label class="label label-info">Đã biên tập</label>
										@elseif($post->status == 'submitted')
											<label class="label label-info">Đang chờ biên tập</label>
										@elseif($post->status == 'returned')
											<label class="label label-warning">Bị trả lại</label>
										@elseif($post->status == 'deleted')
											<label class="label label-danger">Bị xóa</label>
										@else
											<label class="label label-default">Bản nháp</label>
										@endif					
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						{{ $posts->appends($appends)->links() }}
					</div>
	    		</div>
	    	</div>
		</div>
	</div>
@stop
