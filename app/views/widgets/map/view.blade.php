<?php
	$wdata = json_decode($widget->content);
?>
@if($widget->status == 'open')
	@if(isset($wdata->showtitle))
	<style type="text/css">
		#map_canvas{{ $widget->wrid }} {
			width: {{ $wdata->width }}; 
			height: {{ $wdata->height }}
		}
	</style>
		@if($wdata->showtitle)
			<h3 class="headline text-color">
				<span class="border-color">{{ $widget->title }}</span>
			</h3>
		@endif
		<!-- GOOGLE Maps -->
		<script src="https://maps.googleapis.com/maps/api/js?sensor=false&amp;language=en"></script>
		<div id="map_canvas{{ $widget->wrid }}" style=""></div>

		<script type="text/javascript">
			// GOOGLE MAPS
		  function widgetinitialize{{ $widget->wrid }}() {
		  	var myLatlng = new google.maps.LatLng({{ $wdata->location }});
			  var mapOptions = {
				zoom: {{ $wdata->zoom }},
				center: myLatlng,
				mapTypeControl: true,
					mapTypeControlOptions: {
		  			style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
				},
				zoomControl: true,
				zoomControlOptions: {
		  			style: google.maps.ZoomControlStyle.SMALL
				},
				mapTypeId: google.maps.MapTypeId.{{ $wdata->maptype }}
			}
				var map = new google.maps.Map(document.getElementById("map_canvas{{ $widget->wrid }}"),
		  	mapOptions);
				var contentString = '{{ $wdata->content }}';
				var infowindow = new google.maps.InfoWindow({
				  content: contentString
				});

				var marker = new google.maps.Marker({
				  position: myLatlng,
				  map: map,
				});

				infowindow.open(map,marker);
		  }  
		  $(document).ready(function(){
		  	google.maps.event.addDomListener(window, 'load', widgetinitialize{{ $widget->wrid }});
		  });
		</script>
	@endif
@endif