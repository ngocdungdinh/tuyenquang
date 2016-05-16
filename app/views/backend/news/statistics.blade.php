@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Thống kê tin ::
@parent
@stop

{{-- Page content --}}
@section('content')
<h3>
	<span class="glyphicon glyphicon-stats"></span> Thống kê
</h3>
<div class="dashboard"> 
  	<form method="get" action="{{ route('statistics/news') }}" autocomplete="off" role="form" class="form-horizontal">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<div style="oveflow: hidden;" align="right">
		</div>
		<hr />
		<div class="form-group {{ $errors->has('key') ? 'has-error' : '' }}">
			<div class="col-lg-5">
				<div id="reportrange" class="btn btn-default">
				    <i class="glyphicon glyphicon-calendar"></i>
				    <span id="time_select">{{ $start_date }} - {{ $end_date }}</span> <b class="caret"></b>
					<input type="hidden" name="start_date" id="start_date" value="{{ $start_date }}" />
					<input type="hidden" name="end_date" id="end_date" value="{{ $end_date }}" />
				</div>
			</div>
			<div class="col-lg-2">
				<select class="form-control" name="user_id">
					<option value="0">Người viết</option>
					<option value="{{ $u->id }}"> - Tôi -</option>
					@foreach($writers as $writer)
						<option value="{{ $writer->id }}" {{ (isset($user_id) && $writer->id == $user_id) ? 'selected="selected"' : '' }}> {{ $writer->first_name }} {{ $writer->last_name }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-lg-2">
				<select class="form-control" name="category_id">
					<option value="0">Chuyên mục</option>
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
			<div class="col-lg-2">
				<select class="form-control" name="type">
					<option value="0">Loại tin</option>
					<option value="lastest" {{ isset($type) && $type == 'lastest' ? 'selected="selected"' : '' }}> Mới nhất</option>
					<option value="oldest" {{ isset($type) && $type == 'oldest' ? 'selected="selected"' : '' }}> Cũ nhất</option>
					<option value="mostview" {{ isset($type) && $type == 'mostview' ? 'selected="selected"' : '' }}> Xem nhiều</option>
					<option value="royalty" {{ isset($type) && $type == 'royalty' ? 'selected="selected"' : '' }}> Đã chấm NB</option>
					<option value="notroyalty" {{ isset($type) && $type == 'notroyalty' ? 'selected="selected"' : '' }}> Chưa chấm NB</option>
				</select>
			</div>
			<div class="col-lg-1">
				<input type="submit" class="btn btn-default btn-info" name="search" value="Lọc" />
			</div>
		</div>
	</form>
	<hr />
	<div>
		<h4>Tổng số bài: <strong>{{ $posts->getTotal() }}</strong></h4>
	</div>
	<div class="row">
		<div class="col-md-8">
			<table class="table table-hover">
				<thead>
					<tr>
						<th class="span6">@lang('admin/news/table.title')</th>
						<th class="span2">Người đăng</th>
						<th width="150">Đăng ngày</th>
						<th width="80">Lượt xem</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($posts as $post)
					<tr>
						<td>
							@if(!Permission::has_access('news', 'edit') || ($post->status == 'published' && !Permission::has_access('news', 'editpublish')) || (Permission::has_access('news', 'editowner') && !Permission::has_access('news', 'editowner', $post->user_id)))
								{{ $post->title }}
							@else
								<a href="{{ route('update/news', $post->id) }}"><strong>{{ $post->title }}</strong></a>
							@endif
							<br />
							<a style="color: #666666" href="{{ $post->url() }}" target="_blank"># {{ $post->id }}</a>
						</td>
						<td>{{ $post->first_name }} {{ $post->last_name }}</td>
						<td>
							<span title="{{ $post->publish_date }}">{{ date("H:i - d/m/Y",strtotime($post->publish_date)) }}</span>
						</td>
						<td>
							{{ $post->view_count }}
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="col-md-4">
			<div>
				<h4>Chuyên mục</h4>
				<ul class="list-group">
					@foreach($categories as $category)
						@if($category->parent_id == 0)
							@if(isset($counts['cat'][$category->id]['count']) && $counts['cat'][$category->id]['count'] > 0)
							<li class="list-group-item">
							    <span class="badge">{{ isset($counts['cat'][$category->id]['count']) ? $counts['cat'][$category->id]['count'] : 0 }}</span>
							    {{ $category->name }}
							</li>
							@endif
							@foreach ($category->subscategories as $subcate)
								@if(isset($counts['cat'][$subcate->id]['count']) && $counts['cat'][$subcate->id]['count'] > 0)
									<li class="list-group-item">
									    <span class="badge">{{ isset($counts['cat'][$subcate->id]['count']) ? $counts['cat'][$subcate->id]['count'] : 0 }}</span>
									    - {{ $subcate->name }}
									</li>
								@endif
							@endforeach
						@endif
					@endforeach
				</ul>
			</div>
			<div>
				<h4>Người viết</h4>
				<ul class="list-group">
					@foreach($writers as $writer)
						@if(isset($counts['user'][$writer->id]['count']) && $counts['user'][$writer->id]['count'] > 0)
						<li class="list-group-item">
						    <span class="badge">{{ isset($counts['user'][$writer->id]['count']) ? $counts['user'][$writer->id]['count'] : 0 }}</span>
						    {{ $writer->first_name }} {{ $writer->last_name }}
						</li>
						@endif
					@endforeach
				</ul>
			</div>
		</div>
	</div>
	{{ $posts->appends($appends)->links() }}

	<script type="text/javascript">
		$('#reportrange').daterangepicker(
		    {
		      ranges: {
		         'Hôm nay': [moment(), moment()],
		         'Hôm qua': [moment().subtract('days', 1), moment().subtract('days', 1)],
		         '7 ngày trước': [moment().subtract('days', 6), moment()],
		         '30 ngày trước': [moment().subtract('days', 29), moment()],
		         'Tháng này': [moment().startOf('month'), moment().endOf('month')],
		         'Tháng trước': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
		      },
		      startDate: moment('{{ $start_date }}'),
		      endDate: moment('{{ $end_date }}')
		    },
		    function(start, end) {
		        $('#reportrange span').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
		        $('#start_date').val(start.format('YYYY-MM-DD hh:mm:ss'));
		        $('#end_date').val(end.format('YYYY-MM-DD hh:mm:ss'));
		    }
		);
		$('#time_select').html(moment('{{ $start_date }}').format('D MMMM, YYYY') + ' - ' + moment('{{ $end_date }}').format('D MMMM, YYYY'))
	</script>
</div>
@stop
