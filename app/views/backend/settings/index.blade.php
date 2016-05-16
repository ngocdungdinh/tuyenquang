@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Thiết lập ::
@parent
@stop

{{-- Page content --}}
@section('content')
<h3>
	<span class="glyphicon glyphicon-cog"></span> Thiết lập
</h3>
<form method="post" action="" autocomplete="off" class="form-horizontal" role="form">
<!-- CSRF Token -->
<input type="hidden" name="_token" value="{{ csrf_token() }}" />
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
		<li class="active"><a href="#tab-general" data-toggle="tab">Thông tin chung</a></li>
		<li><a href="#tab-news" data-toggle="tab">Tin tức</a></li>
		<li><a href="#tab-comments" data-toggle="tab">Bình luận</a></li>
		<li><a href="#tab-analytics" data-toggle="tab">Analytics</a></li>
    </ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab-general">
			<div class="form-group">
				<label for="sitename" class="col-sm-2 control-label">Tiêu đề</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="sitename" name="configs[sitename]" value="{{ Config::get('settings.sitename') }}" placeholder="" />
				</div>
			</div>
			<div class="form-group">
				<label for="siteinfo" class="col-sm-2 control-label">Mô tả</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="siteinfo" name="configs[site_info]" value="{{ Config::get('settings.site_info') }}" placeholder="" />
				</div>
			</div>
			<div class="form-group">
				<label for="keywords" class="col-sm-2 control-label">Từ khóa</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="keywords" name="configs[keywords]" value="{{ Config::get('settings.keywords') }}" placeholder="" />
				</div>
			</div>
			<div class="form-group">
				<label for="siteurl" class="col-sm-2 control-label">Địa chỉ web</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="siteurl" name="configs[site_url]" value="{{ Config::get('settings.site_url') }}" placeholder="" />
				</div>
			</div>
			<div class="form-group">
				<label for="admin_email" class="col-sm-2 control-label">Admin Email</label>
				<div class="col-sm-5">
					<input type="email" class="form-control" id="admin_email" name="configs[admin_email]" value="{{ Config::get('settings.admin_email') }}" placeholder="" />
				</div>
			</div>
			<div class="form-group">
				<label for="language" class="col-sm-2 control-label">Ngôn ngữ</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="language" name="configs[language]" value="{{ Config::get('settings.language') }}" placeholder="" />
				</div>
			</div>
			<hr />
			<div class="form-group">
				<label for="maintain_mode" class="col-sm-2 control-label">Bảo trì</label>
				<div class="col-sm-2">
					<select id="maintain_mode" name="configs[maintain_mode]" class="form-control">
						<option value="no" {{ Config::get('settings.maintain_mode')=='no' ? 'selected="selected"' : '' }}>Sai</option>
						<option value="yes" {{ Config::get('settings.maintain_mode')=='yes' ? 'selected="selected"' : '' }}>Đúng</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="maintain_info" class="col-sm-2 control-label">Thông tin bảo trì</label>
				<div class="col-sm-5">
					<textarea rows="5" class="form-control" id="maintain_info" name="configs[maintain_info]">{{ Config::get('settings.maintain_info') }}</textarea>
				</div>
			</div>
			<div class="form-group">
				<label for="maintain_info" class="col-sm-2 control-label">Thời gian hoạt động trở lại</label>
				<div class="col-sm-5">
	                <div id="datetimepicker" class="date input-group">
						<span class="input-group-addon" style="padding: 6px 9px;"><i data-time-icon="icon-time" data-date-icon="icon-calendar" class="glyphicon glyphicon-calendar"></i></span>
						<input class="form-control" readonly type="text" name="configs[active_date]" id="active_date" value="{{ Config::get('settings.active_date') }}" />
	                </div>
				</div>
			</div>
		</div>
		<div class="tab-pane" id="tab-news">
			<div class="form-group">
				<label for="auto_sortfeatured" class="col-sm-2 control-label">Tự động sắp xếp tin nổi bật</label>
				<div class="col-sm-2">
					<select id="auto_sortfeatured" name="configs[auto_sortfeatured]" class="form-control">
						<option value="no" {{ Config::get('settings.auto_sortfeatured')=='no' ? 'selected="selected"' : '' }}>Sai</option>
						<option value="yes" {{ Config::get('settings.auto_sortfeatured')=='yes' ? 'selected="selected"' : '' }}>Đúng</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="auto_sortfeatured" class="col-sm-2 control-label">Tự động sắp xếp tin tiêu điểm</label>
				<div class="col-sm-2">
					<select id="auto_sortpopular" name="configs[auto_sortpopular]" class="form-control">
						<option value="no" {{ Config::get('settings.auto_sortpopular')=='no' ? 'selected="selected"' : '' }}>Sai</option>
						<option value="yes" {{ Config::get('settings.auto_sortpopular')=='yes' ? 'selected="selected"' : '' }}>Đúng</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="featured_posts" class="col-sm-2 control-label">Số tin nổi bật</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="featured_posts" name="configs[featured_posts]" value="{{ Config::get('settings.featured_posts') }}" placeholder="" />
				</div>
			</div>
			<div class="form-group">
				<label for="popular_posts" class="col-sm-2 control-label">Số tin tiêu điểm</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="popular_posts" name="configs[popular_posts]" value="{{ Config::get('settings.popular_posts') }}" placeholder="" />
				</div>
			</div>
			<div class="form-group">
				<label for="lastest_posts" class="col-sm-2 control-label">Số tin mới</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="lastest_posts" name="configs[lastest_posts]" value="{{ Config::get('settings.lastest_posts') }}" placeholder="" />
				</div>
			</div>
			<hr />
			<div class="form-group">
				<label for="paging_posts" class="col-sm-2 control-label">Số tin trên một trang</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="paging_posts" name="configs[paging_posts]" value="{{ Config::get('settings.paging_posts') }}" placeholder="" />
				</div>
			</div>
		</div>
		<div class="tab-pane" id="tab-comments">
			<div class="form-group">
				<label for="comment_status" class="col-sm-2 control-label">Chế độ bình luận:</label>
				<div class="col-sm-3">
					<select id="comment_status" name="configs[comment_status]" class="form-control">
						<option value="on" {{ Config::get('settings.comment_status')=='on' ? 'selected="selected"' : '' }}>Tiền kiểm</option>
						<option value="off" {{ Config::get('settings.comment_status')=='off' ? 'selected="selected"' : '' }}>Hậu kiểm</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="comment_allow" class="col-sm-2 control-label">Cho phép bình luận:</label>
				<div class="col-sm-3">
					<select id="comment_allow" name="configs[comment_allow]" class="form-control">
						<option value="no" {{ Config::get('settings.comment_allow')=='no' ? 'selected="selected"' : '' }}>Sai</option>
						<option value="yes" {{ Config::get('settings.comment_allow')=='yes' ? 'selected="selected"' : '' }}>Đúng</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="comment_allow_guest" class="col-sm-2 control-label">Khách có thể bình luận:</label>
				<div class="col-sm-3">
					<select id="comment_allow_guest" name="configs[comment_allow_guest]" class="form-control">
						<option value="no" {{ Config::get('settings.comment_allow_guest')=='no' ? 'selected="selected"' : '' }}>Sai</option>
						<option value="yes" {{ Config::get('settings.comment_allow_guest')=='yes' ? 'selected="selected"' : '' }}>Đúng</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="comment_perpage" class="col-sm-2 control-label">Số bình luận hiển thị:</label>
				<div class="col-sm-1">
					<input type="text" class="form-control" id="comment_perpage" name="configs[comment_perpage]" value="{{ Config::get('settings.comment_perpage') ? Config::get('settings.comment_perpage') : 10 }}" placeholder="" />
				</div>
			</div>
		</div>
		<div class="tab-pane" id="tab-analytics">
			<div class="form-group">
				<label for="analytic_client_id" class="col-sm-2 control-label">Client Id: *</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="analytic_client_id" name="configs[analytic_client_id]" value="{{ Config::get('settings.analytic_client_id') }}" placeholder="" />
				</div>
			</div>
			<div class="form-group">
				<label for="analytic_service_email" class="col-sm-2 control-label">Service Email: *</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="analytic_service_email" name="configs[analytic_service_email]" value="{{ Config::get('settings.analytic_service_email') }}" placeholder="" />
				</div>
			</div>
			<div class="form-group">
				<label for="analytic_p12_file" class="col-sm-2 control-label">P12 file: *</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="analytic_p12_file" name="configs[analytic_p12_file]" value="{{ Config::get('settings.analytic_p12_file') }}" placeholder="" />
					<p style="padding: 5px 0;">Nhập tên file lưu tại: Config/packages/thujohn/analytics/</p>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-primary">Cập nhật</button>
			</div>
		</div>
		<hr />
	</div>
</div>
</form>

@stop