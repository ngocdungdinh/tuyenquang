@extends('frontend/layouts/modal')

{{-- Page content --}}
@section('content')
<div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h4 class="modal-title">{{ $status ? 'Thành công' : 'Có lỗi xảy ra!' }}</h4>
	  </div>
	  <div class="modal-body">
	  	{{ $message }}
	  </div>
	</div>
</div>
@if($status)
	<script type="text/javascript">
        setTimeout(function() {
              location.reload();
        }, 1000);
	</script>
@endif