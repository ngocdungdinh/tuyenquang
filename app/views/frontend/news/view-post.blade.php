@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
{{ $post->meta_title ? $post->meta_title : $post->title }} ::
@parent
@stop

{{-- Update the Meta Title --}}
@section('meta_title', $post->meta_title ? $post->meta_title : $post->title)
@section('meta_keywords', $post->meta_keywords.','.Config::get('settings.keywords'))
@section('meta_description', $post->meta_description ? $post->meta_description : $post->excerpt)
@section('meta_image', ($post->mname ? asset($post->mpath . '/550x500/'. $post->mname) : ''))

{{-- Page content --}}
@section('content')

	<div class="row mix_content">
		<!---------------------------------------------- left content-------------------------------------------------->
		<div class="col-md-8 left-content">
			<div class="row">
				<div class="col-md-7 contact">
					<div class="tab line_text2">
						<span class="tit_underline" style="margin-left:10px">{{ $parent_category->name }}</span>
					</div>
					<div class="top-content">
						<div class="news_detail">
							<div class="col-md-8 news_detail_text">
								<div class="item-news-bottom">
									<div class="news_detail_sub">
										<a href="#" class="tit3">{{ $post->title }}</a>
										<div class="col-md-8 ddmmyy">
											<span style="color:#999;">[{{ date("H:i - d/m/Y",strtotime($post->publish_date)) }}]</span>
										</div>
										<p class="news-content-excerpt"><strong>{{ $post->excerpt }}</strong></p>
										<p>{{ $post->content }}</p>
									</div>

									<div class="news_detail_sub" style="margin-top:20px;">
										<a href="#" class="tit3"><i>Bài viết khác</i></a>
										<ul style="margin:0; float:left; padding:5px;">
											@foreach ($category_posts as $key => $cp)
												<li class="link"><img src="{{ asset('assets/img/icon_text.png') }}" style="margin:5px;"><a href="{{ $cp->url() }}" title="{{ $cp->title }}" style="color:#666;">{{ $cp->title }}</a></li>
											@endforeach
										</ul>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div><!--row-->
		</div>
		<!---------------------------------------------------end left------------------------------------------------------------->

		<div class="col-md-3 right-content">
			@include('frontend/partials/right-content')
		</div><!---end right-content---->

	</div>
<script type="text/javascript">

	BB.updateViewCount('{{ $currPostId }}');
	BB.commentList('vote');
</script>
@stop
