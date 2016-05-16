<div class="comment-item " id="comment-{{$key}}">
	<div class="comment-author">
		<span style="font-weight: bold;">{{ $cmt->fullname }}</span> - <span class="comment-date" data-datetime="{{ strtotime($cmt->created_at) }}">{{ date('H:i - d/m/Y', strtotime($cmt->created_at)) }}</span>
		<span class="pull-right">
			<strong id="cmt-vote-{{ $cmt->id }}" style="font-size: 14px; color: #aa1801">{{ $cmt->vote }}</strong> <button class="btn btn-xs btn-default btn-comment-vote" data-cmtid="{{ $cmt->id }}"><i class="fa fa-thumbs-o-up"></i> Hay</button>
		</span>
	</div>
	<div class="comment-body">
		{{ nl2br($cmt->content) }}
	</div>
</div>