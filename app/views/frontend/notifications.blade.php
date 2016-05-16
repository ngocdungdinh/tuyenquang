@if ($errors->any())
<div class="alert alert-danger alert-message show">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	Có lỗi xảy ra, hãy kiểm tra lại các thông tin!
</div>
@endif

@if ($message = Session::get('success'))
<div class="alert alert-success alert-message show">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	{{ $message }}
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger alert-message show">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	{{ $message }}
</div>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-message show">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	{{ $message }}
</div>
@endif

@if ($message = Session::get('info'))
<div class="alert alert-info alert-message show">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	{{ $message }}
</div>
@endif
