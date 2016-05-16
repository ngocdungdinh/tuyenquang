@extends('backend/layouts/widget')

{{-- Page title --}}
@section('title')
Thư viện của tôi ::
@parent
@stop
{{-- Page content --}}
@section('content')
<div class=""  >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Xem bài viết</h4>
      </div>
      <div class="modal-body">
      		<div class="row inc-action" style="margin: 0">
	      		<div class="callout callout-info">
	      		@if($post->status=='published')
      				<div class="col-sm-4">
	                    <h4>Bài viết đã xuất bản</h4>
	                    <p><a href="{{ $post->url() }}" target="_blank" class="btn btn-xs"><i class="fa fa-eye"></i> Xem</a></p>
	                </div>
				@elseif($post->status=='reviewed')
      				<div class="col-sm-4">
	                    <h4>Bài viết đã được biên tập</h4>
	                </div>
				@elseif($post->status=='reviewing')
      				<div class="col-sm-4">
	                    <h4>Bài viết đang biên tập</h4>
	                </div>
				@elseif($post->status=='submitted')
      				<div class="col-sm-4">
	                    <h4>Bài viết chờ biên tập</h4>
	                </div>
				@elseif($post->status=='unpublish')
      				<div class="col-sm-4">
	                    <h4>Bài viết bị gỡ bỏ</h4>
	                </div>
				@elseif($post->status=='returned')
      				<div class="col-sm-4">
	                    <h4>Bài viết bị trả lại</h4>
	                </div>
				@elseif($post->status=='draft')
      				<div class="col-sm-4">
	                    <h4>Bản nháp</h4>
	                </div>
				@endif
				@if (Permission::has_access('news', 'full') || !Permission::has_access('news', 'editowner') || (($post->status=='draft' || $post->status=='submitted') && Permission::has_access('news', 'editowner', $post->user_id)))
					<a href="{{ route('update/news', $post->id) }}" class="btn btn-app btooltip"><span class="glyphicon glyphicon-pencil"></span> Sửa</a>
				@endif

				@if ( ($post->status=='returned' || $post->status=='unpublish' || $post->status=='unpublish' || $post->status=='draft') && Permission::has_access('news', 'delete', $post->user_id))
					<a onclick="confirmDelete(this); return false;" href="{{ route('delete/news', $post->id) }}" class="btn btn-app"><span class="glyphicon glyphicon-trash"></span> @lang('button.delete')</a>
				@endif
      			</div>
      		</div>
      		<hr style="margin: 8px 0" />
	    	<div class="row">
	    		<div class="col-sm-9">
					<div class="box box-solid">
	                    <div class="box-header">
				    		<h3 class="box-title">{{ $post->title }}</h3>
	                    </div>
	                    <div class="box-body" style="font-size: 14px; line-height: 20px;">
							<p><strong>{{ $post->excerpt }}</strong></p>
							<!-- Content -->
							<div>
								{{ $post->content }}
							</div>
	                    </div>
                    </div>
					@if(Sentry::getUser()->hasAnyAccess(['activities', 'activities.post']))
						<!-- Activities Box -->
						<div id="activities-container{{$post->id}}">
							<div class="pad loading" align="center"><img src="/assets/img/loader.gif" /></div>
						</div>
						<script type="text/javascript">
							getActivities('{{$post->id}}');
						</script>
					@endif
                </div>
	    		<div class="col-sm-3">
					<div class="panel panel-default">
						<div class="panel-heading">Thông tin chung</div>
						<div class="panel-body">
							<dl>
	                            <dt><span class="glyphicon glyphicon-user"></span> Người viết:</dt>
	                            <dd style="margin-bottom: 10px;">{{ $post->author->fullName() }}</dd>
	                            <dt><span class="glyphicon glyphicon-time"></span> Ngày viết:</dt>
	                            <dd style="margin-bottom: 10px;">{{ $post->created_at }}</dd>
	                            <dt><span class="glyphicon glyphicon-time"></span> Chỉnh sửa gần đây:</dt>
	                            <dd style="margin-bottom: 10px;">{{ $post->updated_at }}</dd>
	                            <dt><span class="glyphicon glyphicon-time"></span> Ngày xuất bản:</dt>
	                            <dd style="margin-bottom: 10px;">{{ $post->publish_date }}</dd>
	                        </dl>
							<h4></h4>
		                	
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">Ảnh đại diện</div>
						<div class="panel-body">
						  <div class="form-group">
						    <p class="help-block" id="cover-image">
						    	@if($media)
						    		<img src="{{ asset($media->mpath . '/200x130_crop/' . $media->mname) }}" width="100%" />
						    	@else
						    		Chưa có ảnh đại diện
						    	@endif
						    </p>
						  </div>
						</div>
					</div>
					@if($post->tags->count())
					<div class="panel panel-default">
						<div class="panel-heading">Tags</div>
						<div class="panel-body">
							<div id="tagList">
								@foreach($post->tags as $tag)
									<p>{{ $tag->name}}</p>
								@endforeach
							</div>
						</div>
					</div>
					@endif
                </div>
            </div>
      </div>
    </div>
  </div>
</div>
