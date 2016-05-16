<?php
	$wdata = json_decode($widget->content);
?>
@if($widget->status == 'open')
	@if(isset($wdata->showtitle))
		@if($wdata->showtitle)
			<h3 class="headline text-color">
				<span class="border-color">{{ $widget->title }}</span>
			</h3>
		@endif
		<form method="post" action="/widget/contact" class="form-horizontal" role="form">
			<!-- CSRF Token -->
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />

			<fieldset>
				<!-- Name -->
				<div  class="form-group{{ $errors->first('name', ' has-error') }}">
					<div class="col-lg-7">
						<input type="text" id="name" name="name" class="input-block-level form-control" placeholder="Tên bạn">
						{{ $errors->first('name', '<span class="help-block">:message</span>') }}
					</div>
				</div>

				<!-- Email -->
				<div  class="form-group{{ $errors->first('email', ' has-error') }}">
					<div class="col-lg-7">
						<input type="text" id="email" name="email" class="input-block-level form-control" placeholder="Địa chỉ Email">
						{{ $errors->first('email', '<span class="help-block">:message</span>') }}
					</div>
				</div>
				<!-- Description -->
				<div  class="form-group{{ $errors->first('description', ' has-error') }}">
					<div class="col-lg-12">
						<textarea rows="4" id="description" name="description" class="input-block-level form-control" placeholder="Nội dung"></textarea>
						{{ $errors->first('description', '<span class="help-block">:message</span>') }}
					</div>
				</div>

				<!-- Form actions -->
				<button type="submit" class="btn btn-warning pull-right">Gửi</button>
			</fieldset>
		</form>
	@endif
@endif