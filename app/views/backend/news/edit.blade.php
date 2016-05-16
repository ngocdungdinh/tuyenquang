@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Sửa tin ::
@parent
@stop

{{-- Page content --}}
@section('content')
	<div class="row">
		<div class="col-sm-4 col-md-4">
			<h3>
		    	<span class="glyphicon glyphicon-pencil"></span> Sửa bài viết
		    </h3>
    	</div>
		<div class="col-sm-8 col-md-8">
			<div align="right" class="pull-right">
				@include('backend/news/inc-action')
			</div>
		</div>
	</div>
	<form method="post" action="" autocomplete="off" role="form" id="updatePost">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<input type="hidden" name="status" id="status" value="{{ $post->status }}" />
		<input type="hidden" name="postid" id="postid" value="{{ $post->id }}" />
		<div class="row">
			<div class="col-md-9">
				<!-- Tabs -->
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab-general" data-toggle="tab"><strong><span class="glyphicon glyphicon-list-alt"></span> Thông tin chung</a></strong></li>
						<li><a href="#tab-royalties" data-toggle="tab"><strong><span class="fa fa-money"></span> Nhuận bút ({{ number_format($royalyTotal) }})</strong></a></li>
						<li><a href="#tab-meta-data" data-toggle="tab"><strong><span class="glyphicon glyphicon-info-sign"></span> SEO</strong></a></li>
						@if($postVersions->count()>1)
                        	<li><a href="{{URL::to('admin/news/diff?postid='.$post->id)}}" data-toogle="modal" data-target="#modal_diff_post" class="show-modal"><strong><span class="glyphicon glyphicon-transfer"></span> So sánh phiên bản</strong></a></li>
                        @endif
					</ul>
					<!-- Tabs Content -->
					<div class="tab-content">
						<!-- General tab -->
						<div class="tab-pane active" id="tab-general">
							<!-- Post Title -->
							<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
								<label class="control-label" for="title">Tiêu đề</label>
								<input class="form-control" type="text" name="title" id="title" value="{{ Input::old('title', e($post->title)) }}" />
							</div>
							<!-- Post Slug -->
							<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
								<label class="control-label" for="slug" style="display: block">Đường dẫn bài 
									@if($post->status=='published')<a href="{{ $post->url() }}" target="_blank" class="btn btn-xs"><i class="fa fa-eye"></i> Xem</a>
									@endif
									<span class="pull-right" style="font-weight: normal"><i>Mẹo: để trống slug bài để tạo lại từ tiêu đề</i></span>
								</label>
								<div class="input-group">
								  <span class="input-group-addon">
								  	{{ str_finish(URL::to('/'), '/') }}<b>{{ isset($post->category_url) ? $post->category_url : '*chưa chọn danh mục*' }}/</b>
								  </span>
								  <input class="form-control" type="text" name="slug" id="slug" value="{{ Input::old('slug', $post->slug) }}">
								</div>
							</div>
							<!-- Post Title -->
							<div id="subtitleInput" class="form-group {{ $errors->has('subtitle') ? 'has-error' : '' }}" {{ empty($post->subtitle) ? 'style="display: none"' : '' }}>
								<label class="control-label" for="subtitle">Tiêu đề ngắn</label>
								<input class="form-control" type="text" name="subtitle" id="subtitle" value="{{ Input::old('subtitle', e($post->subtitle)) }}" />
							</div>

							<!-- excerpt -->
							<div class="form-group {{ $errors->has('excerpt') ? 'has-error' : '' }}">
								<label class="control-label" for="excerpt">Tóm tắt</label>
								<textarea class="form-control" name="excerpt" id="excerpt" value="excerpt" rows="3">{{ Input::old('excerpt', $post->excerpt) }}</textarea>
							</div>
							<div>
								@if(empty($post->subtitle))
									<a href="javascript:void(0)" onclick="$('#subtitleInput').toggle(); $('#subtitle').focus();" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-plus-sign"></span> Thêm tiêu đề ngắn</a>
								@endif
								<a data-toggle="modal" href="{{ URL::to('admin/news/postlist?post_id='.$post->id) }}" data-target="#modal_addposts" class="btn btn-xs btn-default show-modal"><i class="glyphicon glyphicon-th-list"></i> Thêm tin liên quan</a>
							</div>
							<div id="relatePosts" style="padding: 10px 0;">
								@if($relatePosts)
									<h4>Tin liên quan</h4>
									@foreach($relatePosts as $rp)
										<p id="postrelate-{{ $rp->id }}"><a href="javascript:void(0)" onclick="addRelatePost( '{{ $post->id }}', '{{ $rp->id }}', 0)"><span class="glyphicon glyphicon-minus-sign"></span></a> <a href="{{ $rp->url() }}" target="_blank">{{ $rp->title }}</a></p>
									@endforeach
								@endif
							</div>
							<hr style="margin: 5px 0 10px 0" />
							<!-- Content -->
							<div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
								<div style="padding-bottom: 4px;">
									<label class="control-label" for="textareabox">Nội dung</label>
									<span class="pull-right">
										<a class="btn btn-info btn-xs media-modal" data-url="{{ URL::to('medias/upload?env=news') }}"><i class="glyphicon glyphicon-cloud-upload"></i> Thư viện</a>
									</span>
								</div>
								<textarea class="form-control" name="content" id="textareabox" value="content" rows="40">{{ Input::old('content', $post->content) }}</textarea>
							</div>
							<div class="box box-default" style="background: transparent">
								<div class="box-header">
									<i class="fa fa-book"></i> <h3 class="box-title">Luồng sự kiện</h3>
									<div class="box-tools pull-right">
							            <a class="btn btn-default btn-sm show-modal" data-toggle="modal" href="{{ URL::to('admin/tags/listpopup') }}" data-target="#modal_taglist"><i class="fa fa-plus"></i> Thêm</a>
							        </div>
								</div>
								<div class="box-body">
									<div id="topicList">
										<div class="row">
											@if($topics->count())
												@foreach($topics as $topic)
													@include('backend/tags/ptitem')
												@endforeach
											@else
												<div class="col-md-12"><p><i>- sử dụng nút Thêm để tạo luồng sự kiện -</i></p></div>
											@endif
										</div>
									</div>
									<input type="hidden" name="topics" id="topicIds" value="{{ implode(',', $topicIds) }}" />
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

						<!-- Meta Data tab -->
						<div class="tab-pane" id="tab-meta-data">
					      @include('backend/inc/seo_update')
						</div>
						<!-- Meta Data tab -->
						<div class="tab-pane" id="tab-royalties">
							@if ( Permission::has_access('royalty', 'full') || Permission::has_access('royalty', 'view') || Permission::has_access('royalty', 'full', $post->user_id))
							<div id="royaltiesResult">
								<table class="table table-hover">
									<thead>
										<tr>
											<th width="120">Người nhận</th>
											<th width="60">Nhuận bút</th>
											<th width="60">Thuế</th>
											<th width="70">Được nhận</th>
											<th width="150">Ghi chú</th>
											<th width="60">Đã nhận?</th>
											<th width="60"></th>
										</tr>
									</thead>
									<tbody>
										@if(isset($royalties))
										@foreach ($royalties as $royalty)
											<tr>
												<td>
													{{ $royalty->author->fullName() }}
												</td>
												<td>
													{{ number_format($royalty->royalty) }}
												</td>
												<td>
													{{ number_format($royalty->tax) }}
												</td>
												<td>
													{{ number_format($royalty->total) }}
												</td>
												<td>
													{{ $royalty->description }}
												</td>
												<td>
													{{ $royalty->received ? '<span class="label label-success">Đúng</span>' : '<span class="label label-success">Sai</span>' }}
												</td>
												<td>
													@if ( Permission::has_access('royalty', 'full') || Permission::has_access('royalty', 'set'))
														<a data-toggle="modal" href="{{ URL::to('admin/royalties/form?royal_id='.$royalty->id) }}" data-target="#modal_royaltyform" class="show-modal label label-default">Sửa</a>
														<a onclick="DeleteRoyalties('{{ $royalty->id }}');" href="javascript:void(0)" class="label label-danger">Xóa</a>
													@endif
												</td>
											</tr>
										@endforeach
											<tr class="success">
												<td colspan="2"></td>
												<td>Tổng</td>
												<td>{{ number_format($royalyTotal) }}</td>
												<td colspan="3"></td>
											</tr>									
										@endif
									</tbody>
								</table>
							</div>
							@else
								<div>Bạn không thể xem nội dung này.</div>
							@endif
							<hr />
							@if ( Permission::has_access('royalty', 'full') || Permission::has_access('royalty', 'set'))
								<a data-toggle="modal" href="{{ URL::to('admin/royalties/form?writer_id='.$post->user_id.'&item_id='.$post->id) }}" data-target="#modal_royaltyform" class="show-modal btn btn-info btn-xs"><span class="glyphicon glyphicon-plus"></span> Thêm nhuận bút</a>
							@endif
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 nopl">
				<div class="box box-danger" style="background: transparent">
					<div class="box-body">
						<div class="row" align="center">
							<div class="col-xs-3 col-sm-3 col-md-3">
								<div class="checkbox">
									<label>
										<i class="ion-chatboxes fa-2x btooltip" data-toggle="tooltip" title="Cho phép bình luận"></i><br />
										<input type="checkbox" name="allow_comments" value="1" class="flat-red" {{ $post->allow_comments ? 'checked="checked"' : ''}} />
									</label>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-3">
								<div class="checkbox">
									<label>
										<i class="ion-images fa-2x btooltip" data-toggle="tooltip" title="Tin có ảnh"></i><br />
										<input type="checkbox" name="has_picture" value="1" class="flat-red" {{ $post->has_picture ? 'checked="checked"' : ''}} />
									</label>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-3">
								<div class="checkbox">
									<label>
										<i class="ion-videocamera fa-2x btooltip" data-toggle="tooltip" title="Tin chứa video"></i><br />
										<input type="checkbox" name="has_video" value="1" class="flat-red" {{ $post->has_video ? 'checked="checked"' : ''}} />
									</label>
								</div>
							</div>
							<div class="col-xs-3 col-sm-3 col-md-3">
								<div class="checkbox">
									<label>
										<i class="ion-headphone fa-2x btooltip" data-toggle="tooltip" title="Tin chứa audio"></i><br />
										<input type="checkbox" name="has_audio" value="1" class="flat-red" {{ $post->has_audio ? 'checked="checked"' : ''}} />
									</label>
								</div>
							</div>
						</div>
						<hr />
						<div class="row">
							<div class="col-sm-6">
								<div class="checkbox">
									<label><input type="checkbox" name="is_featured" value="1" {{ Input::old('is_featured', $post->is_featured) ? 'checked="checked"' : ''}}> Bài nổi bật</label>
								</div>
								<div class="checkbox">
									<label><input type="checkbox" name="is_popular" value="1" {{ Input::old('is_popular', $post->is_popular) ? 'checked="checked"' : ''}}> Tiêu điểm</label>
								</div>
							</div>
							<div class="col-sm-6">								
								<div class="checkbox">
									<label><input type="checkbox" name="showon_category" value="1" {{ Input::old('showon_category', $post->showon_category) ? 'checked="checked"' : ''}}> Danh mục</label>
								</div>
								<div class="checkbox">
									<label><input type="checkbox" name="showon_homepage" value="1" {{ Input::old('showon_homepage', $post->showon_homepage) ? 'checked="checked"' : ''}}> Trang chủ</label>
								</div>
							</div>
						</div>
						<hr />
		                <div class="form-group {{ $errors->has('publish_date') ? 'has-error' : '' }}">
		                	<h5><label for="datetimepicker">Ngày xuất bản</label></h5>
			                <div id="datetimepicker" class="date input-group">
								<span class="input-group-addon" style="padding: 6px 9px;"><i data-time-icon="icon-time" data-date-icon="icon-calendar" class="glyphicon glyphicon-calendar"></i></span>
								<input class="form-control" readonly type="text" name="publish_date" id="publish_date" value="{{ Input::old('publish_date', $post->publish_date) }}" />
			                </div>
						</div>
		                <div class="form-group">
		                	<h5><label for="writer">Người viết</label></h5>
		                	<div id="writer">
		                		{{ $post->author->fullName() }}
		                	</div>
		                </div>
						<div class="form-group ">
							<h5><label class="control-label" for="source_news">Nguồn tin</label></h5>
							<input class="form-control" type="text" name="source_news" id="source_news" value="{{ Input::old('source_news', $post->source_news) }}" />
						</div>
						<div class="form-group">
							<h5><label class="control-label" for="type">Phân loại tin</label></h5>
							<div id="type-list">
								{{Form::select('post_kind',array('0'=>'Tin chưa phân loại','1'=>'Tin sản xuất','2'=>'Tin dịch','3'=>'Tin tổng hợp','4'=>'Tin biên tập'),Input::old('post_kind',$post->type),array('class'=>'form-control'))}}
							</div>
						</div>
						<div class="form-group ">
							<h5><label class="control-label" for="cover-image">Ảnh đại diện</label></h5>
						    <div class="help-block" id="cover-image">
						    	@if($media)
						    		@if($media->mtype == 'image')
						    		<img src="{{ asset($media->mpath . '/'.Config::get('image.featuredsize').'/' . $media->mname) }}?v={{ time() }}" width="100%" />
						    		<span style="display: block; margin-top: 6px;">
							    		<a class="btn btn-primary btn-xs show-modal" data-toggle="modal" href="{{ URL::to('medias/cropthumb/'.$media->id) }}" data-target="#modal_cropmedia" ><i class="fa fa-scissors"></i> Sửa ảnh</a>
							    		<a class="btn btn-default btn-xs" href="javascript:void(0)" onclick="removeNewsCover()" ><i class="fa fa-chain-broken"></i> Bỏ ảnh</a>
						    		</span>
						    		@elseif($media->mtype == 'video')
						    			<div class="flex-video"><iframe src="http://www.youtube.com/embed/{{ $media->mname }}?rel=0&showinfo=0&ps=docs&autoplay=0&autohide=1&iv_load_policy=3&vq=large&modestbranding=1&nologo=1&enablejsapi=1" frameborder="0" allowfullscreen="1"></iframe>
						    			</div>
						    			<a class="label label-default" href="javascript:void(0)" onclick="removeNewsCover()" >Bỏ video</a>
						    		@endif
						    	@else
						    		Chưa có ảnh đại diện
						    	@endif
						    </div>
						    <input type="hidden" name="media_id" value="{{ $post->media_id }}" id="media-cover-id" />
						</div>
						<div class="form-group ">
							<h5><label class="control-label" for="category-list">Chuyên mục</label></h5>
							<div style="color: #ba251e"><strong>Bắt buộc:</strong> tick chọn <span class="glyphicon glyphicon-flag"></span> để làm chuyên mục chính cho bài viết</div>
							<div id="category-list" style="height: 400px; overflow-y: auto; border: 5px solid #ededed; padding: 5px;">
								@foreach($categories as $category)
									@if($category->parent_id == 0)
										@if(array_get($userPermissions, 'category.c'.$category->id) === 1 && $category->id != 79)
											<div class="checkbox">
											  <label class="scat category-id-{{ $category->id }} {{ $category->id == $post->category_id ? 'active' : '' }}" id="category-id-{{ $category->id }}">
											    <input name="categories[]" type="checkbox" value="{{ $category->id}}" {{ in_array($category->id, $catIds) ? 'checked="checked"' : ''}}> <strong>{{ $category->name}} </strong>
											    @if($category->id == $post->category_id)
											    	<span class="glyphicon glyphicon-flag"></span>
											    @endif
											    <a href="javascript:void(0)" onclick="setPrimaryCat('{{ $post->id }}', '{{ $category->id }}')" style="display: none"><span class="glyphicon glyphicon-flag"></span></a>
											  </label>
											</div>
											@foreach ($category->subscategories as $subcate)
												<div class="checkbox">
												  <label class="scat {{ $subcate->id == $post->category_id ? 'active' : '' }}" id="category-id-{{ $subcate->id }}">
												    <input name="categories[]" type="checkbox" value="{{ $subcate->id}}" {{ in_array($subcate->id, $catIds) ? 'checked="checked"' : ''}}> -- {{ $subcate->name}} 
												    @if($subcate->id == $post->category_id)
												    	<span class="glyphicon glyphicon-flag"></span>
												    @else
												    	<a href="javascript:void(0)" onclick="setPrimaryCat('{{ $post->id }}', '{{ $subcate->id }}')" style="display: none"><span class="glyphicon glyphicon-flag"></span></a>
												    @endif
												  </label>
												</div>
											@endforeach
										@endif
									@endif
								@endforeach
							</div>
						</div>
						<div class="form-group ">
							<h5><label class="control-label" for="cover-image"><span class="glyphicon glyphicon-tags"></span> Tags</label></h5>
							<i>Nhập tên tag, Enter để thêm.</i>
							<div style="margin-bottom: 5px; padding-bottom: 5px; border-bottom: 1px solid #eeeeee">
								<input type="text" name="tagname" id="tagName" class="form-control" value="" style="width: 100%" />
							</div>
							<div id="tagList">
								@foreach($tags as $tag)
									<p>
										<input type="hidden" name="tagId[]" value="{{ $tag->id }}" />
										<a href="javascript:void(0)" onclick="removeTaginPost('{{ $tag->id }}', this)" class="btn btn-default btn-xs"><i class="fa fa-times"></i></a> {{ $tag->name}}
										@if($tag->type=='topic')
										<strong>(Luồng sự kiện)</strong>
										@endif
									</p>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
	
<div class="modal fade" id="modal_taglist" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="modalTagList" ></div>
<div class="modal fade" id="modal_topictype" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="modalTopicType" ></div>
<div class="modal fade" id="modal_royaltyform" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="modalRoyaltyForm" ></div>
<div class="modal fade" id="modal_diff_post" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="modalDiffPost"></div>
<!-- add news to tag -->
<div class="modal fade" id="modal_addposts" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="modalRelatePost" ></div><!-- /.modal -->
<div class="modal fade" id="modal_cropmedia" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="modalCropMedia" ></div><!-- /.modal -->
@if($post->status == 'published')
	<script type="text/javascript">
		updatePublishApi('{{ $post->id }}');
		@if(Config::get('settings.auto_sortfeatured') == 'yes')
			updatePostsSort('home');
		@endif
		@if(Config::get('settings.auto_sortpopular') == 'yes')
			updatePostsSort('home_populars');
		@endif
	</script>
@endif
@stop
