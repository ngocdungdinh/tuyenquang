@if($comments->count())
	<div align="center">
		<div class="btn-group">
		  <button type="button" class="btn btn-xs btn-default active btn-comment-sort" data-type="vote"><i class="fa fa-thumbs-o-up"></i> Quan tâm</button>
		  <button type="button" class="btn btn-xs btn-default btn-comment-sort" data-type="up"><i class="fa fa-chevron-up"></i> Mới</button>
		  <button type="button" class="btn btn-xs btn-default btn-comment-sort" data-type="down"><i class="fa fa-chevron-down"></i> Cũ</button>
		</div>
	</div>
	<div class="comment-list">
		@foreach($comments as $key => $cmt)
			@include('frontend/comments/item')
		@endforeach
		<div id="moreComment">
			@if($comments->getTotal() > $key+1)
				<div class="cmt-paging" align="center" style="margin-bottom: 20px; margin-top: 10px;">
					<a href="javascript:void(0)" onclick="BB.moreComment('{{ $cmt->post_id }}', 2, '{{ $order }}')" class="btn btn-default">Xem thêm</a>
				</div>
			@endif
		</div>
	</div>
@endif

<div style="background-color: #efefef; padding: 10px; margin-top: -5px;">
	<form action="/comments/{{ $post->id }}/add" method="post" class="form-horizontal" role="form" id="submitComment" data-serialize >
		<textarea class="form-control" rows="3" name="comment_content" placeholder="Ý kiến của bạn cho bài viết này..." style="width: 100%"></textarea>
		<div style="margin-top: 4px;" align="right">
			<span style="font-size: 11px; color: #aaaaaa" class="pull-left"><i class="fa fa-warning"></i> Vui lòng gõ tiếng Việt có dấu</span>
			@if (Sentry::check())
				<span style="position: relative; text-align: left; display: inline-block; margin-right: 20px;">
					<span>{{ User::avatar($u->avatar, '60x60_crop', 25, 'img-circle') }} </span>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						{{ $u->first_name }} {{ $u->last_name }} <b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="{{ route('logout') }}"><i class="glyphicon glyphicon-log-out"></i> Thoát</a></li>
					</ul>
				</span>
			@endif
			<input type="submit" class="btn btn-color" name="submit" value="Gửi" />
		</div>
			<input type="hidden" name="step" value="0" />
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
	</form>
</div>
<script type="text/javascript">
	BB.submitComment();
</script>