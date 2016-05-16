<div class="col-md-6 col-sm-6">
	<div id="ptitem-{{ $topic->ptid }}">
		<div class="callout {{ $topic->pttype }}">
		    <h4>
		    	Topic: <strong>{{ $topic->name}}</strong>
		    	<span class="pull-right">
		        	<a class="btn btn-default btn-xs show-modal" data-toggle="modal" href="{{ URL::to('admin/tags/topicinfo/'.$topic->ptid) }}" data-target="#modal_topictype"><i class="glyphicon glyphicon-bookmark"></i></a> 
		        	<a class="btn btn-default btn-xs" href="/admin/tags/{{ $topic->tid }}/edit" target="_blank" data-toggle="tooltip" title="" data-original-title="Thêm/bớt tin"><i class="glyphicon glyphicon-th-list"></i></a> 
		        	<a href="javascript:void(0)" onclick="removeTopicInfo('{{ $topic->ptid }}')" class="btn btn-default btn-xs" data-toggle="tooltip" title="" data-original-title="Xóa luồng sự kiện"><i class="fa fa-times"></i></a> 
		    	</span></h4>
		    <h5>
		    	<strong>
			    	@if($topic->pttype == 'default')
			    		Mặc định sau tóm tắt
			    	@elseif($topic->pttype == 'related')
			    		Tin liên quan
			    	@elseif($topic->pttype == 'mostview')
			    		Tin đọc nhiều
			    	@elseif($topic->pttype == 'mostcomment')
			    		Tin nhiều bình luận
			    	@endif
		    	</strong>
		    </h5>
		    @if($topic->topicposts()->count())
			    @foreach($topic->topicposts as $tp)
			    <p>- <a href="{{ $tp->url() }}" target="_blank">{{ $tp->title }}</a></p>
			    @endforeach
		    @else
		    	<p>- chưa có dữ liệu -</p>
		    @endif
		</div>
	</div>
</div>