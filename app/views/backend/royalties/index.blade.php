@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Nhuận bút ::
@parent
@stop

{{-- Page content --}}
@section('content')
<h3>
	<span class="glyphicon glyphicon-usd"></span> Nhuận bút
</h3>
<div class="dashboard"> 
  	<form method="get" action="{{ route('royalties') }}" autocomplete="off" role="form" class="form-horizontal">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<div style="oveflow: hidden;" align="right">
		</div>
		<hr />
		<div class="form-group {{ $errors->has('key') ? 'has-error' : '' }}">
			<div class="col-lg-5" style="position: relative">
				<div id="reportrange" class="btn btn-default" style="position: relative; display: inline-block">
				    <i class="glyphicon glyphicon-calendar"></i>
				    <span id="time_select">{{ $start_date }} - {{ $end_date }}</span> <b class="caret"></b>
					<input type="hidden" name="start_date" id="start_date" value="{{ $start_date }}" />
					<input type="hidden" name="end_date" id="end_date" value="{{ $end_date }}" />
				</div>
			</div>
			<div class="col-lg-2 nop">
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
			<div class="col-lg-2 nop">
				<select class="form-control" name="type">
					<option value="0">Loại tin</option>
					<option value="lastest" {{ isset($type) && $type == 'lastest' ? 'selected="selected"' : '' }}> Mới nhất</option>
					<option value="oldest" {{ isset($type) && $type == 'oldest' ? 'selected="selected"' : '' }}> Cũ nhất</option>
					<option value="mostview" {{ isset($type) && $type == 'mostview' ? 'selected="selected"' : '' }}> Xem nhiều</option>
				</select>
			</div>
			<div class="col-lg-1">
				<input type="submit" class="btn btn-default btn-info" name="search" value="Lọc" />
			</div>
		</div>
	</form>
	<hr />
	<a href="javascript:void(0)" onclick="printWebPart('printContent')" class="btn btn-default pull-right"><span class="glyphicon glyphicon-print"></span> In</a>
	<div id="printContent">
		<div align="center">
			<h3>
				BẢNG NHUẬN BÚT
			</h3>
			<h5><span id="time_select2"></span></h5>
			<hr />
		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-hover">
					<thead>
						<tr>
							<th width="30">STT</th>
							<th width="250">@lang('admin/news/table.title')</th>
							<th width="100">Người viết</th>
							<th width="70">Đăng ngày</th>
							<th width="70">Ghi chú</th>
							<th width="70">Nhuận bút</th>
							<th width="70">Thuế</th>
							<th width="70">Còn nhận</th>
							<th width="80">Chữ kí</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($posts as $key => $post)
						<tr>
							<td>
								{{ ($key++)+1 }}
							</td>
							<td>
								@if(!Permission::has_access('news', 'edit') || ($post->status == 'published' && !Permission::has_access('news', 'editpublish')) || (Permission::has_access('news', 'editowner') && !Permission::has_access('news', 'editowner', $post->user_id)))
									{{ $post->title }}
								@else
									<a href="{{ $post->url() }}"><strong>{{ $post->title }}</strong></a>
								@endif
								<br />
								<a style="color: #666666" href="{{ $post->url() }}" target="_blank"># {{ $post->id }}</a>
							</td>
							<td>{{ $post->author->fullName() }}</td>
							<td>
								<span title="{{ $post->publish_date }}">{{ date("H:i d/m/Y",strtotime($post->publish_date)) }}</span>
							</td>
							<td>
								{{ $post->description }}
							</td>
							<td>
								{{ number_format($post->royalty) }}
							</td>
							<td>
								{{ number_format($post->tax) }}
							</td>
							<td>
								{{ number_format($post->total) }}
							</td>
							<td>
								
							</td>
						</tr>
						@endforeach
						@if(isset($counts['royal']['royalty']))
						<tr class="success">
							<td colspan="4">Tổng</td>
							<td>{{ number_format($counts['royal']['royalty']) }}</td>
							<td>{{ number_format($counts['royal']['tax']) }}</td>
							<td>{{ number_format($counts['royal']['total']) }}</td>
							<td></td>
						</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<table class="table table-hover">
					<tbody>
						<tr class="danger">
							<td width="150px">Tổng bài viết:</td>
							<td class="tdbold">{{ $posts->count() }} bài</td>
						</tr>
						<tr class="warning">
							<td>Tổng nhuận bút:</td>
							<td class="tdbold">{{ isset($counts['royal']['royalty']) ? number_format($counts['royal']['royalty']) : 0 }}</td>
						</tr>
						<tr class="warning">
							<td>Tổng thuế:</td>
							<td class="tdbold">{{ isset($counts['royal']['tax']) ? number_format($counts['royal']['tax']) : 0 }}</td>
						</tr>
						<tr class="warning">
							<td>Tổng số còn nhận:</td>
							<td class="tdbold">{{ isset($counts['royal']['total']) ? number_format($counts['royal']['total']) : 0 }}</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Người viết</h3>
					</div>
					<div class="panel-body">
						<ul class="list-group">
							@foreach($writers as $writer)
								<li class="list-group-item">
								    <span class="badge">{{ isset($counts['user'][$writer->id]['count']) ? $counts['user'][$writer->id]['count'] : 0 }}</span>
								    {{ $writer->first_name }} {{ $writer->last_name }}
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Chuyên mục</h3>
					</div>
					<div class="panel-body">
						<ul class="list-group">
							@foreach($categories as $category)
								@if($category->parent_id == 0)
									<li class="list-group-item">
									    <span class="badge">{{ isset($counts['cat'][$category->id]['count']) ? $counts['cat'][$category->id]['count'] : 0 }}</span>
									    {{ $category->name }}
									</li>
									@foreach ($category->subscategories as $subcate)
										<li class="list-group-item">
										    <span class="badge">{{ isset($counts['cat'][$subcate->id]['count']) ? $counts['cat'][$subcate->id]['count'] : 0 }}</span>
										    - {{ $subcate->name }}
										</li>
									@endforeach
								@endif
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
		<hr />
		<div class="row signature">
			<div class="col-md-3">Tổng biên tập</div>
			<div class="col-md-3">Kế toán trưởng</div>
			<div class="col-md-3">Người kiểm tra</div>
			<div class="col-md-3">Người lập bảng</div>
		</div>
	</div>
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
		var timeSelect = moment('{{ $start_date }}').format('D MMMM, YYYY') + ' - ' + moment('{{ $end_date }}').format('D MMMM, YYYY');
		$('#time_select').html(timeSelect);
		$('#time_select2').html(timeSelect);
	</script>
</div>
@stop
