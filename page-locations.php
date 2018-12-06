<?php
    /* Template Name: Locations Page */
    get_header(); ?>
    <div class="page-title" style="margin-bottom: 50px;">
        <div class="container">
            <h2> <?php the_title(); ?> </h2>
        </div>
    </div>


    <!-- Map -->
    <div class="container locations-select">
        <h4>Sélectionner un centre:</h4>
        <select name="locations" id="locations_dropdown"></select>
    </div>

    <div id="locations-pins" class="col-sm-12 col-xs-12">
    </div>

    <!-- Locations information -->
    <div class="locations-container col-sm-12 col-xs-12">
        <div class="container">
            <div class="information">
            </div>
        </div>
    </div>

    <!-- Connections -->
    <div class="locations-connections col-sm-12 col-xs-12 text-uppercase">
        <div class="container">
        </div>
    </div>


    <!-- Scripts -->
    <?php get_footer(); ?>

    <script>

        /*! Places array */
        var locationPlaces = [];
        var givenHash = parseInt(window.location.hash.split('#')[1]);

        /*! Getting data from the request */
        jQuery(document).ready(function(){
            jQuery.ajax({
                url: '/program-data/?request=locations_json',
                type: 'GET',
                success: function(locations){
                    locationPlaces = locations;
                    addLocationPlaces();
                    // Add locations in Dropdown menu
                    addLocationPlacesInDropdown();
                    if (typeof givenHash == 'number'){
                        jQuery('#locations_dropdown').val(givenHash);
                        appendData(givenHash);
                        jQuery("body").scrollTop(800);
                    }
                },
                error: function(){
                   // alert("Error while geting locations");
                }
            });
        });

        function appendData(value){
            var placesInformation = jQuery('.locations-container .information').html('<div class="title">'+locationPlaces[value].post_title+'</div><div class="col-sm-6 col-xs-12 information-row"><b>Adresse:</b><span>'+locationPlaces[value].addresse+'</span></div><div class="col-sm-6 col-xs-12 information-row"><b>Google Map:</b><a target="_blank" href="https://www.google.com/maps/?q='+locationPlaces[value].latitude+','+locationPlaces[value].longitude+'" style="color: inherit;"><span>Afficher le plan</span></a></div><div class="col-sm-12 col-xs-12 information-row"><b>Infos TPG:</b><span>'+locationPlaces[value].infos+'</span></div><div class="col-sm-12 col-xs-12 information-row"><b>Description:</b><span>'+locationPlaces[value].description+'</span></div><div class="col-sm-12 col-xs-12 information-row"><b>Responsable:</b><span>'+locationPlaces[value].responsible+'</span></div>');

            var placesHeader = jQuery('.locations-connections .container').html('<div class="col-sm-12 col-xs-12"><h4>Disciplines enseignées:</h4></div>');

            var programs = locationPlaces[value].program_data;
            console.log(locationPlaces[value].program_data.length);
            var p_data;
            for(var j=0;j<programs.length;j++){
                p_data = '<div class="col-sm-12 col-xs-12 connection-row"><div class="row"> <div class="col-sm-6 col-xs-12"><a href="'+programs[j].permalink+'">'+programs[j].program+'</a></div><div class="col-sm-6 col-xs-12"><ul><li>'+programs[j].teachers+'</li></ul></div></div></div>';
                jQuery('.locations-connections .container').append(p_data);
            }
            // jQuery('.locations-connections .container').append(p_data);
        }

        function addLocationPlacesInDropdown(){
            for (var i=0; i<locationPlaces.length; i++){
                jQuery('#locations_dropdown').append('<option value="'+i+'">'+locationPlaces[i].post_title+'</option>');
            }
            jQuery('#locations_dropdown').change(function(){
                var value = jQuery(this).val();
                appendData(value);
            })
        }

        /*! Map function */
        function addLocationPlaces(){
            /*! Creating bounds for Switzerland*/
            var locationBounds = new google.maps.LatLngBounds();

            /*! For each loop */
            for (var i=0; i<locationPlaces.length; i++) {
                var place_latitude = Number(locationPlaces[i].latitude);
                var place_longitude = Number(locationPlaces[i].longitude);
                var locations_given_coordinates = {lat: place_latitude, lng: place_longitude};

                var icon3 = {
                    scaledSize: new google.maps.Size(80, 80), // scaled size
                    origin: new google.maps.Point(0,0), // origin
                    anchor: new google.maps.Point(0, 0), // anchor
                    path: "M15,1.1C9.3,1.1,4.7,5.7,4.7,11.4c0,7.3,7.7,15.3,9.8,17.3c0.3,0.3,0.7,0.3,1,0c2.1-2,9.8-10,9.8-17.3 C25.3,5.7,20.7,1.1,15,1.1z M15,19.6c-4.5,0-8.2-3.7-8.2-8.2s3.7-8.2,8.2-8.2s8.2,3.7,8.2,8.2C23.2,16,19.5,19.6,15,19.6z",
                    fillColor: '#000',
                    fillOpacity: 1,
                    strokeWeight: 0,
                    scale: .8
                };

                /*! Add marker for each company from results */
                locationsMarker = new google.maps.Marker({
                    position: locations_given_coordinates,
                    map: locationsMap,
                    icon: icon3
                });

                /*! Marker event */
                google.maps.event.addListener(locationsMarker, 'click', (function (locationsMarker, i) {
                    return function () {
                        appendData(i);
                    }
                })(locationsMarker, i));

                /*! Extend bounds with new/each marker */
                locationBounds.extend(locations_given_coordinates);
            } /*! Exit foreach loop */

            /*! Update bounds to include all markers */
            locationsMap.fitBounds(locationBounds);
        }/*! Exit addPlaces function */


        /*! Initialize map */
        function initLocationsMap(lat, lng) {
            var given_locations = {lat: lat, lng: lng};
            var locationOptions = {
                center: given_locations,
                zoom: 13,
                styles: [{"featureType":"administrative","elementType":"all","stylers":[{"saturation":"-100"}]},{"featureType":"administrative.province","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"all","stylers":[{"saturation":100},{"lightness":90},{"visibility":"on"}]},{"featureType":"poi","elementType":"all","stylers":[{"saturation":-100},{"lightness":"50"},{"visibility":"simplified"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":"-100"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"all","stylers":[{"lightness":"30"}]},{"featureType":"road.local","elementType":"all","stylers":[{"lightness":"40"}]},{"featureType":"transit","elementType":"all","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]},{"featureType":"water","elementType":"labels","stylers":[{"lightness":-25},{"saturation":-100}]}]
            };
            locationsMap = new google.maps.Map(document.getElementById('locations-pins'), locationOptions);
        }
        initLocationsMap(46.8041122,7.4338763);

        jQuery(document).ready(function(){
            initMap(46.8041122,7.4338763);
        });
    </script>
