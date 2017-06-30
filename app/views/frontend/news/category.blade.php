@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
{{ $category->name }} ::
@parent
@stop

{{-- Page content --}}
@section('content')
	<div class="row mix_content">
		<!---------------------------------------------- left content-------------------------------------------------->
		<div class="col-md-8 left-content">
			<div class="row">
				<div class="col-md-10 tintuc_div">
					<div class="tt_item">
						<div class="tab line_text2">
							<p><span class="tit_underline">{{ strtoupper($category->name) }}</span></p>
							<p class="sub_tab">
								@foreach($subcate as $submenu)
									<span><a href="{{ route('view-category', $submenu->slug) }}">{{ $submenu->name }}</a></span>
									<span> | </span>
								@endforeach
							</p>
						</div>
                        @foreach ($posts as $key => $post)
                        <div class="tin">
							<div class="col-md-4 tt_thumb2"><span><img src="{{ asset($post->mpath . '/235x178_crop/'. $post->mname) }}"/></span></div>
							<div class="col-md-8 content">
								<a class="title_left" href="{{ $post->url() }}" title="{{ $post->title }}">{{ $post->title }}<br/>
									<span style="color:#999999;">[{{ date("H:i - d/m/Y",strtotime($post->created_at)) }}]</span>
								</a>
								<span>{{ Str::words($post->excerpt, 24) }}</span>
							</div>
						</div>
                        @endforeach
					</div>

				</div>
                <div class="paging">
                    {{ $posts->links() }}
                </div>
			</div>
		</div>
		<!---------------------------------------------------end left------------------------------------------------------------->

		<div class="col-md-3 right-content">
			@include('frontend/partials/right-content')
		</div><!---end right-content---->

	</div>
@stop
