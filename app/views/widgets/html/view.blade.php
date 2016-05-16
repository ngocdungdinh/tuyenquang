@if($wdata->status == 'open')
	@if(isset($wdata->showtitle) && $wdata->showtitle == 'yes')
		<h3 class="headline text-color">
			<span class="border-color">{{ $widget->title }}</span>
		</h3>
	@endif
	{{ $wdata->content }}
@endif