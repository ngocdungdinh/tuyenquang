<div class="box box-solid">
	<div class="box-header">
		<i class="ion ion-ios7-people info"></i> <h3 class="box-title">Hoạt động</h3>
		<div class="box-tools pull-right">
			@if(isset($is_edit) && $is_edit)
            	<a href="javascript:void(0)" id="addNote" class="btn btn-default btn-sm"><i class="fa fa-plus"></i> Thêm ghi chú</a>
            @endif
        </div>
	</div>
	<div class="box-body">
		<div id="activities-box">
			<ul class="timeline">
				@foreach($activities as $activity)
				    <!-- timeline item -->
				    <li>
				        <!-- timeline icon -->
				        <span class="fa avatar">{{ User::avatar($activity->avatar, '100x100_crop', 35) }}</span>
				        <div class="timeline-item">
				            <span class="time"><i class="fa fa-clock-o"></i> {{ $activity->created_at->diffForHumans() }}</span>

				            <h3 class="timeline-header"><i class="{{ $activity->icon }}"></i> <a href="{{ route('update/user', $activity->user_id) }}">
				            	{{ $activity->first_name }} {{ $activity->last_name }}</a> {{ $activity->name }} 	
				            	@if(!isset($is_edit) || !$is_edit)
				                	<a href="{{ $activity->url }}">{{ $activity->title }}</a>
				                @endif
				                @if($activity->publish_date)
				                <small>Ngày XB: {{ $activity->publish_date }}</small>
				                @endif
				            </h3>
				            @if($activity->content)
					            <div class="timeline-body">			            	
					                <blockquote style="margin-top: 4px; font-size: 13.5px; margin-bottom: 0">{{ $activity->content }}</blockquote>
					            </div>
				            @endif
				        </div>
				    </li>
				    <!-- END timeline item -->
				@endforeach
			</ul>
		</div>
	</div>
</div>
@if(isset($is_edit) && $is_edit)
	<script type="text/javascript">
		$('#addNote').popover({
			animation: true,
			html: true,
			placement: 'bottom',
			title: '<i class="glyphicon glyphicon-pencil"></i> Ghi chú cho bài viết',
			content: '<textarea id="noteContent" class="form-control" style="width: 245px; height: 115px;"></textarea><p style="padding-top: 6px;" align="right"> <a id="saveBehere" onclick="addNote({{ $post->id }});" class="btn btn-info btn-sm btn-flat" href="javascript:void(0)"><span class="glyphicon glyphicon-chevron-down"></span> ok</a></p>',
			trigger: 'click'
		});
	</script>
@endif