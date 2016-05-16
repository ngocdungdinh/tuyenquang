
@if($notifications->count())
	<li>
		<ul class="menu">
		@foreach($notifications as $noti)
	        <li>
	            <a class="item-noti {{ $noti->read ? 'read' : '' }}" href="{{ URL::to($noti->url) }}" style="white-space: normal">
	                <div class="pull-left">
	                    {{ User::avatar($noti->avatar, '60x60_crop', 30) }} 
	                </div>
	                <h4>
	                    {{ $noti->first_name }} {{ $noti->last_name }}
	                    <small><i class="fa fa-clock-o"></i> {{ $noti->created_at->diffForHumans() }}</small>
	                </h4>
	                <p style="display: block">
						@if($noti->noti_id==3)
							đã quan tâm đến bạn
						@else
							@if($noti->people)
								và {{ $noti->people }} người khác 
							@endif
							{{ $noti->name }} 
							<strong>{{ $noti->item_title }}</strong>
							@if($noti->noti_id==1)
								<span class="glyphicon glyphicon-heart" style="color: #E06666"></span>
							@elseif($noti->noti_id==2)
								<span class="glyphicon glyphicon-comment" style="color: #5CB85C"></span>
							@endif
						@endif
					</p>
	            </a>
	        </li>
		@endforeach
		</ul>
	</li>
@else
<li><a href="javascript:void(0)">Chưa có thông báo.</a></li>
@endif