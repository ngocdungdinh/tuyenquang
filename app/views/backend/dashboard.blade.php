@extends('backend/layouts/default')
{{-- Page title --}}
@section('title')
Dashboard ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="dashboard">
	<div class="box box-solid">
		<div class="box-header" align="center" style="border-bottom: 1px solid #eeeeee;">
			<i class="fa fa-flash" style="float: none"></i> <h3 class="box-title" style="float: none">Hôm nay</h3>
		</div>
		<div class="box-body">
			<div class="row" align="center">
				<div class="col-lg-6 col-sm-12 col-xs-12">
                    <div class="row">
                    	<div class="col-lg-6 col-sm-6 col-xs-12">
							<div class="box box-solid">
								<div class="box-header">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                    <h3 class="box-title">{{$posts["today"]->total}} bài viết</h3>
                                </div>
                                <div class="box-body table-responsive no-padding">
	                    			<table class="table">
	                                    <tr>
	                                        <td>
	                                			<a href="/admin/news?status=published"><span class="glyphicon glyphicon-ok-sign"></span> @lang('admin/news/table.published') </a>
	                                		</td>
	                                        <td><span class="badge bg-green">{{ $posts["today"]->published }} bài</span></td>
	                                    </tr>
	                                    <tr>
	                                        <td>
	                                			<a href="/admin/news?status=reviewed"><span class="glyphicon glyphicon-check"></span> @lang('admin/news/table.reviewed')</a>
	                                		</td>
	                                        <td><span class="badge bg-light-blue">{{ $posts["today"]->reviewed }} bài</span></td>
	                                    </tr>
	                                    <tr>
	                                        <td>
	                                			<a href="/admin/news?status=reviewing"><span class="glyphicon glyphicon-time"></span> @lang('admin/news/table.reviewing')</a>
	                                		</td>
	                                        <td><span class="badge bg-aqua">{{ $posts["today"]->reviewing }} bài</span></td>
	                                    </tr>
	                                    <tr>
	                                        <td>
	                                			<a href="/admin/news?status=submitted"><span class="glyphicon glyphicon-time"></span> @lang('admin/news/table.submitted')</a>
	                                		</td>
	                                        <td><span class="badge bg-yellow">{{ $posts["today"]->submitted }} bài</span></td>
	                                    </tr>
	                                    <tr>
	                                        <td>
	                                			<a href="/admin/news?status=unpublish"><span class="glyphicon glyphicon-repeat"></span> @lang('admin/news/table.unpublish')/trả lại</a>
	                                		</td>
	                                        <td><span class="badge bg-red">{{ $posts["today"]->returned+$posts["today"]->unpublish+$posts["today"]->deleteds }} bài</span></td>
	                                    </tr>
	                                </tbody></table>
                                </div>
                            </div>
                        </div>
                    	<div class="col-lg-6 col-sm-6 col-xs-12">
                    		@if($posts["today"]->total)
                    			<div id="donut-chart" style="height: 220px;"></div>
                    		@else
                    			<div class="well">Hôm nay chưa có bài viết nào</div>
                    		@endif
                    	</div>
                    </div>
                    <hr />
                    <div align="left">
                    	<p class="text-green"><i class="fa fa-square text-green"></i> Đang online ({{ $users_online->count() }}):</p>
	                    @if ($u->hasAccess('user.online'))
		                    <p>
		                    	@foreach($users_online as $key => $uo)
		                    		@if ($u->hasAccess('news.full'))
		                    			<a href="/admin/news?user_id={{ $uo->id }}" class="btn btn-default" alt="{{ $uo->last_activity }}">{{ User::avatar($uo->avatar, '100x100_crop', 20) }} {{ $uo->first_name }} {{ $uo->last_name }}</a>
		                    		@else
		                    			<a href="javascript:void(0)" class="btn btn-default" alt="{{ $uo->last_activity }}">{{ User::avatar($uo->avatar, '100x100_crop', 20) }} {{ $uo->first_name }} {{ $uo->last_name }}</a>
		                    		@endif
		                    	@endforeach
		                    </p>
	                    @endif
                    </div>
				</div>
				<div class="col-lg-6 col-sm-12 col-xs-12">
                    <div class="row">
                    	<div class="col-xs-12">
							<div class="box box-solid" style="background-color: #fefbed">
								<div class="box-header">
                                    <i class="fa fa-comments-o"></i>
                                    <h3 class="box-title">{{ $comments->count() }} Bình luận</h3>
                                </div>
                                <div class="box-body table-responsive no-padding" id="comments-box">
                                	@if($comments->count())
                                    <table class="table table-hover">
                                        <tbody>
                                        @foreach ($comments as $comment)
	                                        <tr>
	                                            <td>
	                                            	<p >
		                                            	@if($comment->user_id)
		                                            		<strong>{{ $comment->first_name. ' ' .$comment->last_name }}</strong> ({{$comment->email}})
		                                            	@else
		                                            		<strong>{{ $comment->first_name. ' ' .$comment->fullname }}</strong> ({{$comment->email}})
		                                            	@endif
	                                            	</p>
	                                            	<p>{{ nl2br($comment->content) }}</p>
	                                            	<p>
	                                            		<small>
	                                            			{{ $comment->created_at->diffForHumans() }} - 
	                                            			<a href="{{ $comment->post->url() }}" target="_blank">{{ $comment->post->title }}
	                                            		</small>
	                                            	</p>
	                                            </td>
	                                            <td width="1">
	                                            	<p class="comment-status">
														<input type="checkbox" name="comment_status" value="1" class="minimal-red update-cmt-status" data-commentid="{{ $comment->id }}" {{ $comment->status == 'on' ? 'checked="checked"' : ''}} />
													</p>
	                                            </td>
	                                        </tr>
                                        @endforeach
                                    </tbody></table>
                                    @else
	                                    <div class="callout callout-warning">
	                                        <!-- <h4>I am a warning callout!</h4> -->
	                                        <p>- Chưa có bình luận -</p>
	                                    </div>
                                    @endif
                                </div><!-- /.box-body -->
                            </div>
                    	</div>
                    </div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-md-12">
            <div class="box box-solid">
                <div class="box-header">
                    <i class="glyphicon glyphicon-user"></i>
                    <h3 class="box-title">Bài viết của tôi</h3>
                    <div class="box-tools pull-right">
                        <a href="javascript:void(0)" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_newpost"><i class="fa fa-plus"></i> Viết bài mới</a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                	<table class="table">
                		@foreach($ownposts as $post)
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
							<td>
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
							<td>
								@if($post->status == 'published')
									<span title="{{ $post->publish_date }}">{{ date("H:i - d/m/Y",strtotime($post->publish_date)) }}</span>
								@else
									<span title="{{ $post->created_at }}">{{ $post->created_at->diffForHumans() }}</span>
								@endif
							</td>
	                    </tr>
	                    @endforeach
                	</table>
                </div><!-- /.box-body -->
            </div>
            
		</div>
		<div class="col-md-6 col-md-12">
			@if (Sentry::getUser()->hasAccess('viewanalytics'))
	            <div class="box box-solid">
	                <div class="box-header">
	                    <i class="fa fa-bar-chart-o"></i>
	                    <h3 class="box-title">Lượng truy cập 7 ngày qua</h3>
	                </div>
	                <div class="box-body">
	                    <div id="line-chart" style="height: 300px;"><div class="pad" align="center"><img src="/assets/img/loader.gif" /></div></div>
	                </div><!-- /.box-body-->
	            </div><!-- /.box -->
	            <script type="text/javascript">
    				loadAnalytics();
	            </script>
            @endif
            <div class="box box-solid">
                <div class="box-header">
                    <i class="fa fa-bar-chart-o"></i>
                    <h3 class="box-title">Bài xem nhiều hôm nay</h3>
                </div>
                <div class="box-body">
                	<table class="table" id="top-page-today"><div class="pad loading" align="center"><img src="/assets/img/loader.gif" /></div></table>
                </div><!-- /.box-body-->
            </div><!-- /.box -->
            <script type="text/javascript">
				loadAnalyticsTopPage();
            </script>
		</div>
	</div>
</div>
@if($posts["today"]->total > 0)
	<script type="text/javascript">
	    $(function() {

	        /*
	         * DONUT CHART
	         * -----------
	         */

	        var donutData = [
	            {label: "Xuất bản", data: '{{ ($posts["today"]->published/$posts["today"]->total)*100 }}', color: "#00a65a"},
	            {label: "Đã biên tập", data: '{{ ($posts["today"]->reviewed/$posts["today"]->total)*100 }}', color: "#3c8dbc"},
	            {label: "Đang biên tập", data: '{{ ($posts["today"]->reviewing/$posts["today"]->total)*100 }}', color: "#00c0ef"},
	            {label: "Chờ biên tập", data: '{{ ($posts["today"]->submitted/$posts["today"]->total)*100 }}', color: "#f39c12"},
	            {label: "Bị trả lại", data: '{{ (($posts["today"]->returned+$posts["today"]->unpublish+$posts["today"]->deleteds)/$posts["today"]->total)*100 }}', color: "#cf5947"}
	        ];
	        $.plot("#donut-chart", donutData, {
	            series: {
	                pie: {
	                    show: true,
	                    radius: 1,
	                    innerRadius: 0.5,
	                    label: {
	                        show: false,
	                        radius: 2 / 3,
	                        formatter: labelFormatter,
	                        threshold: 0.1
	                    }

	                }
	            },
	            legend: {
	                show: false
	            }
	        });
	        /*
	         * END DONUT CHART
	         */

	        /*
	         * Custom Label formatter
	         * ----------------------
	         */
	        function labelFormatter(label, series) {
	            return "<div style='font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;'>"
	                    + label
	                    + "<br/>"
	                    + Math.round(series.percent) + "%</div>";
	        }
	    });
	</script>
@endif
@stop
