@extends('frontend/layouts/default')

{{-- Page title --}}
@section('title')

@parent
@stop

{{-- Page content --}}
@section('content')

	<div class="row mix_content">
		<!---------------------------------------------- left content-------------------------------------------------->
		<div class="col-md-9 left-content">

			<div style="margin-top:10px;"></div>
			<div class="row">
				<div class="col-md-5 tintuc_div_left">
					<div class="tt_item">
						<div class="tab line_text2">
							<p><span class="tit_underline">{{$newsHomeCate->name}}</span></p>
							<p class="sub_tab">
							@foreach($newsHomeCate->subscategories as $key => $subCate)
								<span><a href="{{ route('view-category', $subCate->slug) }}">{{$subCate->name}}</a></span>
								@if($key <= count($subCate))
								<span> | </span>
								@endif
                            @endforeach
							</p>
						</div>
						@if(count($newshome) > 0)
							@for ($i = 0; $i <= 1; $i++)
								<div class="tin01">
									<div class="tt_thumb2"><img class="tt_thumb" src="{{ asset($newshome[$i]->mpath . '/140x106_crop/'. $newshome[$i]->mname) }}" align="left"/></div>
									<div class="content2">
										<p><a href="{{ $newshome[$i]->url() }}" title="{{ $newshome[$i]->title }}">{{ $newshome[$i]->title }}<br/></a></p>
										<p class="date"><span >[{{ date("H:i - d/m/Y",strtotime($newshome[$i]->created_at)) }}]</span></p>
									</div>
								</div>
							@endfor
						@endif

						<ul style="margin:0; float:left; padding:5px;;">
							@if(count($newshome) > 0)
								@for ($i = 2; $i < count($newshome); $i++)
									<li class="link invisible-resp"><img src="{{ asset('assets/img/icon_text.png') }}" style="margin:5px;"><a href="{{ $newshome[$i]->url() }}" title="{{ $newshome[$i]->title }}" style="color:#666;">{{ $newshome[$i]->title }}</a></li>
								@endfor
							@endif
						</ul>
					</div>
				</div><!--tintuc_div-->

				<div class="col-md-5 tintuc_div_left2">
					<div class="tt_item">
						<div class="tab line_text2">
							<p><span class="tit_underline">{{$overseasCate->name}}</span></p>
							<p class="sub_tab">
                            @foreach($overseasCate->subscategories as $key => $subCate)
                                <span><a href="{{ route('view-category', $subCate->slug) }}">{{$subCate->name}}</a></span>
                                @if($key <= count($subCate))
                                <span> | </span>
                                @endif
                            @endforeach
                            </p>
						</div>
						@if(count($overseas) > 0)
							@for ($i = 0; $i <= 1; $i++)
								<div class="tin01">
									<div class="tt_thumb2"><img class="tt_thumb" src="{{ asset($overseas[$i]->mpath . '/140x106_crop/'. $overseas[$i]->mname) }}" align="left"/></div>
									<div class="content2">
										<p><a href="{{ $overseas[$i]->url() }}" title="{{ $overseas[$i]->title }}">{{ $overseas[$i]->title }}<br/></a></p>
										<p class="date"><span >[{{ date("d/m/Y",strtotime($overseas[$i]->created_at)) }}]</span></p>
									</div>
								</div>
							@endfor
						@endif
						<ul style="margin:0; float:left; padding:5px;;">
							@if(count($overseas) > 0)
								@for ($i = 2; $i < count($overseas); $i++)
									<li class="link invisible-resp"><img src="{{ asset('assets/img/icon_text.png') }}" style="margin:5px;"><a href="{{ $overseas[$i]->url() }}" title="{{ $overseas[$i]->title }}" style="color:#666;">{{ $overseas[$i]->title }}</a></li>
								@endfor
							@endif
						</ul>
					</div>
				</div><!--tintuc_div-->
			</div>

			<div class="row">
				<div class="col-md-10 tintuc_div">
					<div class="tt_item">
						<div class="tab line_text2">
							<p><span class="tit_underline">{{$interCate->name}}</span></p>
							<p class="sub_tab">
                            @foreach($interCate->subscategories as $key => $subCate)
                                <span><a href="{{ route('view-category', $subCate->slug) }}">{{$subCate->name}}</a></span>
                                @if($key <= count($subCate))
                                <span> | </span>
                                @endif
                            @endforeach
                            </p>
						</div>
						@if(count($international) > 0)
						<?php
						$topInt = $international->first();
						?>
						<div class="tin1" style="padding:0;">
							<div class="col-md-3 tt_thumb2"><img src="{{ asset($topInt->mpath . '/235x178_crop/'. $topInt->mname) }}"/></span></div>
							<div class="col-md-8 content" style="margin-left:45px;">
								<a class="title_left" href="{{ $topInt->url() }}" title="{{ $topInt->title }}">{{ $topInt->title }}</a>
								<span>{{$topInt->excerpt}}</span>
							</div>
						</div><!--tin--->
						@endif
					</div>
					<ul style="margin:0; float:left; padding:5px;">
						@foreach($international as $key => $int)
							@if($key > 0)
								<li class="link invisible-resp"><img src="{{ asset('assets/img/icon_text.png') }}" style="margin:5px;"><a href="{{$int->url()}}" title="{{$int->title}}" style="color:#666;">{{$int->title}}</a></li>
							@endif
						@endforeach
					</ul>
				</div>
			</div>
			<div class="row">
			</div><!--tintuc_div-->
			<div class="row" style="margin-top:10px;">
				<div class="col-md-5 tintuc_div_left">
					<div class="tt_item">
						<div class="tab line_text2"><span class="tit_underline">dự án fngo</span></div>
						@if(count($fngo) > 0)
							@foreach($fngo as $key => $fngo)
							<img class="tt_thumb" src="{{ asset($fngo->mpath . '/140x106_crop/'. $fngo->mname) }}" align="left"/>
							<a href="{{$fngo->url()}}" title="{{$fngo->title}}">{{$fngo->title}}<br/>
								<span style="color:#999999;">{{ date("d/m/Y",strtotime($fngo->created_at)) }}</span>
							</a>
							@endforeach
						@endif
					</div>
				</div><!--tintuc_div-->
				<div class="col-md-5 tintuc_div_left2">
					<div class="tt_item">
						<div class="tab line_text2"><span class="tit_underline">dự án FDI</span></div>

						@if(count($fdi) > 0)
							@foreach($fdi as $key => $fdi)
								<img class="tt_thumb" src="{{ asset($fdi->mpath . '/140x106_crop/'. $fdi->mname) }}" align="left"/>
								<a href="{{$fdi->url()}}" title="{{$fdi->title}}">{{$fdi->title}}<br/>
									<span style="color:#999999;">{{ date("d/m/Y",strtotime($fdi->created_at)) }}</span>
								</a>
							@endforeach
						@endif


					</div>
				</div><!--tintuc_div-->
			</div>
		</div>
		<!---------------------------------------------------end left------------------------------------------------------------->

		<div class="col-md-3 right-content">
            @include('frontend/partials/right-content')
		</div><!---end right-content---->

	</div>
@stop
