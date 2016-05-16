<div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h4 class="modal-title">Gửi tin nhắn</h4>
	  </div>
	  <div class="modal-body">
	  	<form role="form" method="post" action="/profile/messages/compose" id="from-messages-compose" class="form-horizontal" role="form">
		  <!-- CSRF Token -->
		  <input type="hidden" name="_token" value="{{ csrf_token() }}" />
		  <div class="form-group">
		    <label for="name" class="col-sm-1 control-label"></label>
		    <div class="col-sm-10">
	   			<input disabled type="text" name="name" class="form-control" value="{{ $user_two->first_name }} {{ $user_two->last_name }}" placeholder="Tên người nhận">
	   			<input type="hidden" name="receipt_id" class="form-control" value="{{ $user_two->id }}">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="content" class="col-sm-1 control-label"></label>
		    <div class="col-sm-10">
	   			<textarea name="content" class="form-control" placeholder="Nội dung tin nhắn"></textarea>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="submit" class="col-sm-1 control-label"></label>
		    <div class="col-sm-10">
				<input type="submit" class="btn btn-success" name="submit" value="Gửi" />
		    </div>
		  </div>
		</form>
	   </div>
	</div>
</div>