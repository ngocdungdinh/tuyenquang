@foreach($comments as $key => $cmt)
	@include('frontend/comments/item')
@endforeach
<div id="moreComment">
	@if($comments->count())
		<div class="cmt-paging" align="center" style="margin-bottom: 20px; margin-top: 10px;">
			<a href="javascript:void(0)" onclick="BB.moreComment('{{ $cmt->post_id }}', '{{ $page + 1 }}', '{{ $order }}')" class="btn btn-default">Xem thêm</a>
		</div>
	@endif
</div>