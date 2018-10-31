		<footer class="col-xs-12 col-sm-12">

			<!--Logo Display  -->
			<div class="container">
				<div class="row">
					<div class="col-sm-3 col-xs-12">
						<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
							<?php dynamic_sidebar( 'footer-1' ); ?>
						<?php endif; ?>
						<hr>
						<?php echo do_shortcode('[mc4wp_form id="494"]'); ?>
						<ul class="share-buttons">
							<?php 
								$facebook = get_theme_mod( 'er-facebook' );
								if($facebook){
									$result = '<li><a href="'.$facebook.'"><i class="fa fa-facebook"></i></a></li>';
									echo $result;
								}
							?>
							<?php 
								$insta = get_theme_mod( 'er-insta' );
								if($insta){
									$result = '<li><a href="'.$insta.'"><i class="fa fa-instagram"></i></a></li>';
									echo $result;
								}
							?>
							<?php 
								$youtube = get_theme_mod( 'er-youtube' );
								if($youtube){
									$result = '<li><a href="'.$youtube.'"><i class="fa fa-youtube"></i></a></li>';
									echo $result;
								}
							?>
						</ul>
						<p>Le Conservatoire populaire de musique, danse et théâtre, école accréditée par le département de l'instruction publique, de la formation et de la jeunesse, bénéficie du soutien de la République et canton de Genève.</p>
						
						
					</div>
					<div class="col-sm-3 col-xs-12">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/footer-image_03.png" alt="">

						<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
							<?php dynamic_sidebar( 'footer-2' ); ?>
						<?php endif; ?>
						<p style="margin-bottom:0;">IBAN : CH73 0900 0000 1200 5505 3</p>
						<p>BIC : POFICHBEXXX</p>
						<hr>
						<img style="height:40px;margin-right:10px;" src="<?php echo get_template_directory_uri(); ?>/assets/footer-image_01.png" alt="">
						<img style="height:40px;" src="<?php echo get_template_directory_uri(); ?>/assets/footer-image_02.png" alt="">
					</div>
					<div class="col-sm-5 col-sm-push-1 col-xs-12 googlemaps-footerview">
						<h4>les centres d’enseignements</h4>
						<div class="locations-select">
							<select style="color: #000" name="locations" id="locations_dropdownFooter">
								<option value="-1" selected></option>
							</select>
						</div>
						<!-- The element that will contain our Google Map. This is used in both the Javascript and CSS above. -->
						<div id="footer-pins" class="footer-map"></div>
					</div>
				</div>
			</div>
		</footer>
		
		<!-- Scripts -->
		<?php wp_footer(); ?>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBZqgRQ08i04MKCWwTbFD9MpUVUzlTNOF0"></script>
		<script>

			/*! Places array */
			var places = [];

			/*! Getting data from the request */
			jQuery(document).ready(function(){
				jQuery.ajax({
					url: '/program-data/?request=locations_json',
					type: 'GET',
					success: function(locations){
						places = locations;
						addPlaces();
						addLocationPlacesInDropdown();
					},
					error: function(){
						//alert("Error while geting locations");
					}
				});

			});
			
			function addLocationPlacesInDropdown(){
				var siteUrl = "<?php echo site_url() ?>";
				
				for (var i=0; i<places.length; i++){
					jQuery('#locations_dropdownFooter').append('<option value="'+i+'">'+places[i].post_title+'</option>'); 
				}
				jQuery('#locations_dropdownFooter').change(function(){
					var value = jQuery(this).val();
					
					window.location.href = siteUrl + "/centres-denseignement/" + "#" + value;
					
					var placesInformation = jQuery('.locations-container .information').html('<div class="title">'+places[value].post_title+'</div><div class="col-sm-6 col-xs-12 information-row"><b>Adresse:</b><span>'+places[value].addresse+'</span></div><div class="col-sm-6 col-xs-12 information-row"><b>Google Map:</b><a href="https://maps.google.com/?q='+places[value].addresse+'" style="color: inherit;"><span>Afficher le plan</span></a></div><div class="col-sm-12 col-xs-12 information-row"><b>Infos TPG:</b><span>'+places[value].infos+'</span></div><div class="col-sm-12 col-xs-12 information-row"><b>Description:</b><span>'+places[value].description+'</span></div><div class="col-sm-12 col-xs-12 information-row"><b>Responsable TPG:</b><span>'+places[value].responsible+'</span></div>');

					var placesHeader = jQuery('.locations-connections .container').html('<div class="col-sm-12 col-xs-12"><h4>Disciplines enseignées:</h4></div>');
					
					var programs = places[value].program_data;
					var p_data = "";
					for(var j=0;j<programs.length;j++){
						p_data = '<div class="col-sm-12 col-xs-12 connection-row"><div class="row"> <div class="col-sm-6 col-xs-12"><a href="'+programs[j].permalink+'">'+programs[j].program+'</a></div><div class="col-sm-6 col-xs-12"><ul><li>'+programs[j].teachers+'</li></ul></div></div></div>';
					}
					jQuery('.locations-connections .container').append(p_data);
				})
			}

			/*! Map function */
			function addPlaces(){
				/*! Creating bounds for Switzerland*/
				var bounds = new google.maps.LatLngBounds();

				/*! For each loop */
				for (var i=0; i<places.length; i++) {
					var place_latitude = Number(places[i].latitude);
					var place_longitude = Number(places[i].longitude);
					var given_coordinates = {lat: place_latitude, lng: place_longitude};

					/*! Markers icon for 'centres-denseignement' page */
					var icon = {
						// url: '<?php echo get_template_directory_uri(); ?>/assets/icon-map_pin.png',
						scaledSize: new google.maps.Size(80, 80), // scaled size
						origin: new google.maps.Point(0,0), // origin
						anchor: new google.maps.Point(0, 0), // anchor
						path: "M15,1.1C9.3,1.1,4.7,5.7,4.7,11.4c0,7.3,7.7,15.3,9.8,17.3c0.3,0.3,0.7,0.3,1,0c2.1-2,9.8-10,9.8-17.3 C25.3,5.7,20.7,1.1,15,1.1z M15,19.6c-4.5,0-8.2-3.7-8.2-8.2s3.7-8.2,8.2-8.2s8.2,3.7,8.2,8.2C23.2,16,19.5,19.6,15,19.6z",
						fillColor: '#000',
						fillOpacity: 1,
						strokeWeight: 0,
						scale: 1
					}

					/*! Add marker for each company from results */
					marker = new google.maps.Marker({
						position: given_coordinates,
						map: map,
						icon: icon
					});

					/*! Extend bounds with new/each marker */
					bounds.extend(given_coordinates);
				} /*! Exit foreach loop */

				/*! Update bounds to include all markers */
				map.fitBounds(bounds);
			}/*! Exit addPlaces function */


			/*! Initialize map */
			function initMap(lat, lng) {
				var given_location = {lat: lat, lng: lng};
				var mapOptions = {	
					center: given_location,
					zoom: 11,
					styles: [{"featureType":"administrative","elementType":"all","stylers":[{"saturation":"-100"}]},{"featureType":"administrative.province","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"all","stylers":[{"saturation":100},{"lightness":90},{"visibility":"on"}]},{"featureType":"poi","elementType":"all","stylers":[{"saturation":-100},{"lightness":"50"},{"visibility":"simplified"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":"-100"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"all","stylers":[{"lightness":"30"}]},{"featureType":"road.local","elementType":"all","stylers":[{"lightness":"40"}]},{"featureType":"transit","elementType":"all","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]},{"featureType":"water","elementType":"labels","stylers":[{"lightness":-25},{"saturation":-100}]}]
				};
				map = new google.maps.Map(document.getElementById('footer-pins'), mapOptions);
			}
				
			jQuery(document).ready(function(){
				initMap(46.8041122,7.4338763);
			});
		</script>


		<script>
			jQuery('.program').on("touchstart", function (e) {
			'use strict'; //satisfy code inspectors
			var link = jQuery(this); //preselect the link
			if (link.hasClass('hover')) {
				return true;
			} 
			else {
				link.addClass('hover');
				jQuery('.program').not(this).removeClass('hover');
				e.preventDefault();
				return false; //extra, and to make sure the function has consistent return points
			}
			});
		</script>
	</body>
</html>