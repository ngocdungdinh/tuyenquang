@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')
{{ $page->title }} ::
@parent
@stop

{{-- Update the Meta Title --}}
@section('meta_title')

@parent
@stop

{{-- Update the Meta Description --}}
@section('meta_description')

@parent
@stop

{{-- Update the Meta Keywords --}}
@section('meta_keywords')

@parent
@stop

{{-- Page content --}}
@section('content')
<hr />
<div class="row">
	<div>
		<div class="box-info">
			<div class="">
				<div class="row">
					<div class="col-md-3">
						<ul class="nav nav-pills nav-stacked bs-sidebar affix-top" data-spy="affix" data-offset-top="110" data-offset-bottom="365">
							@foreach($pages as $p)
						        <li {{ $page->slug ==  $p->slug ? 'class="active"' : ''}}><a href="{{ URL::to('page/'.$p->slug) }}">{{ $p->title }}</a></li>
							@endforeach
					    </ul>
					</div>
					<div class="col-md-9">
						<div style="border: 1px solid #dddddd; padding: 0 15px 15px 15px;">
							<h3>{{ $page->title }}</h3>
							<p><strong>{{ $page->excerpt }}</strong></p>
							<p>{{ $page->content }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop