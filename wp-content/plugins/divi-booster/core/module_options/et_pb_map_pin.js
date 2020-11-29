jQuery(function($){

	var dbdb_checkMapExists = setInterval(function(){

		$map_containers = $('.et_pb_map_container'); 
		$map_containers.find('.et_pb_map_pin[data-initial="open"]').each(function(){

			var $this_marker = $(this);						
			var $this_map_container = $this_marker.closest('.et_pb_map_container');
			
			if ($this_map_container.data('map')) {
				clearInterval(dbdb_checkMapExists);

				var marker = new google.maps.Marker({
					position: new google.maps.LatLng( parseFloat( $this_marker.attr('data-lat') ) , parseFloat( $this_marker.attr('data-lng') ) ),
					map: $this_map_container.data('map'),
					title: $this_marker.attr('data-title'),
					icon: { url: et_pb_custom.builder_images_uri + '/marker.png', size: new google.maps.Size( 46, 43 ), anchor: new google.maps.Point( 16, 43 ) },
					shape: { coord: [1, 1, 46, 43], type: 'rect' },
					anchorPoint: new google.maps.Point(0, -45),
					opacity: 0
				});
				
				if ( $this_marker.find('.infowindow').length ) {
					var infowindow = new google.maps.InfoWindow({
						content: $this_marker.html()
					});
					
					infowindow.open( $this_map_container.data('map'), marker );
					
					google.maps.event.addListener( $this_map_container.data('map'), 'click', function() {
						infowindow.close();
						marker.setMap(null);
					});
					
					google.maps.event.addListener(infowindow, 'closeclick', function() {
						infowindow.close();
						marker.setMap(null);
					});
				}
			} 
		});
		
	}, 400);
});