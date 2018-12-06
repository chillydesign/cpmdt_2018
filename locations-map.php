<!-- The element that will contain our Google Map. This is used in both the Javascript and CSS above. -->



	<div id="footer-pins" class="footer-map"></div>
    <script type="text/javascript">
    	var locations_for_map = <?php locations_for_map(); ?>;
    	var theme_directory = '<?php echo get_template_directory_uri(); ?>';
    </script>
